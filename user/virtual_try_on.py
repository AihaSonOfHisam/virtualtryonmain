from flask import Flask, Response, request, jsonify
import cv2
import mediapipe as mp
import numpy as np

app = Flask(__name__)

# Initialize Mediapipe Pose solution
mp_pose = mp.solutions.pose
pose = mp_pose.Pose()
mp_drawing = mp.solutions.drawing_utils

# Placeholder clothing image
clothing_image = None

@app.route('/tryon', methods=['POST'])
def try_on():
    # Update the clothing image based on the form data
    global clothing_image
    clothing = request.form.get('clothing', 'T-shirt')  # Default to T-shirt
    clothing_image_path = f'images/{clothing}-overlay.png'
    
    # Load the image for the selected clothing item
    clothing_image = cv2.imread(clothing_image_path, cv2.IMREAD_UNCHANGED)
    
    # If the image is not found, send a response indicating an issue
    if clothing_image is None:
        return jsonify({"error": "Clothing image not found"}), 400
    
    return jsonify({"message": "Clothing updated"}), 200

def overlay_clothing(frame, landmarks):
    """Overlay clothing image on the detected person based on landmarks."""
    if clothing_image is None:
        return frame
    
    # Get the dimensions of the clothing image
    h, w, _ = clothing_image.shape
    
    # Example: Use landmarks to calculate position for the overlay (for simplicity)
    # Here, we just overlay the clothing at a fixed position on the frame
    x, y = int(landmarks[mp_pose.POSE_LANDMARKS['LEFT_SHOULDER']].x * frame.shape[1]), int(landmarks[mp_pose.POSE_LANDMARKS['LEFT_SHOULDER']].y * frame.shape[0])

    # Calculate the region where we want to overlay the clothing
    h_offset, w_offset = 100, 50  # Offset to adjust the overlay position

    clothing_resized = cv2.resize(clothing_image, (w + w_offset, h + h_offset))

    # Create mask for the alpha channel
    clothing_mask = clothing_resized[:, :, 3]
    clothing_mask = cv2.merge([clothing_mask, clothing_mask, clothing_mask])

    # Overlay clothing on the frame
    for c in range(0, 3):
        frame[y:y + clothing_resized.shape[0], x:x + clothing_resized.shape[1], c] = (clothing_mask[:, :, c] * (clothing_resized[:, :, c] / 255.0)) + (frame[y:y + clothing_resized.shape[0], x:x + clothing_resized.shape[1], c] * (1.0 - clothing_mask[:, :, c] / 255.0))
    
    return frame

def process_frame(frame):
    """Process frame to detect pose and overlay clothing."""
    rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    results = pose.process(rgb_frame)

    if results.pose_landmarks:
        # Draw landmarks for visualization (optional)
        mp_drawing.draw_landmarks(frame, results.pose_landmarks, mp_pose.POSE_CONNECTIONS)

        # Overlay clothing if landmarks are detected
        frame = overlay_clothing(frame, results.pose_landmarks.landmark)
    
    return frame

@app.route('/video_feed')
def video_feed():
    """Generate video feed with live camera input and clothing overlay."""
    def generate():
        cap = cv2.VideoCapture(0)  # Open webcam
        while cap.isOpened():
            ret, frame = cap.read()
            if not ret:
                break

            # Process each frame with pose detection and overlay
            frame = process_frame(frame)

            # Encode the frame to JPEG and stream it to the frontend
            _, buffer = cv2.imencode('.jpg', frame)
            yield (b'--frame\r\nContent-Type: image/jpeg\r\n\r\n' + buffer.tobytes() + b'\r\n')

        cap.release()

    return Response(generate(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)

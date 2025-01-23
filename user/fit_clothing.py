import cv2
import mediapipe as mp
import numpy as np
import sys

# Initialize MediaPipe pose detection
mp_pose = mp.solutions.pose
pose = mp_pose.Pose()

def fit_clothing_on_user(user_img_path, cloth_img_path, output_path):
    # Load images
    user_img = cv2.imread(user_img_path)
    cloth_img = cv2.imread(cloth_img_path)

    # Convert the user image to RGB for MediaPipe
    user_img_rgb = cv2.cvtColor(user_img, cv2.COLOR_BGR2RGB)

    # Detect pose on the user image
    results = pose.process(user_img_rgb)

    if results.pose_landmarks:
        # Get coordinates for the shoulder and waist
        shoulder_left = results.pose_landmarks.landmark[mp_pose.PoseLandmark.LEFT_SHOULDER]
        shoulder_right = results.pose_landmarks.landmark[mp_pose.PoseLandmark.RIGHT_SHOULDER]
        waist = results.pose_landmarks.landmark[mp_pose.PoseLandmark.LEFT_HIP]

        # Convert landmarks to pixel coordinates
        shoulder_left_coords = (int(shoulder_left.x * user_img.shape[1]), int(shoulder_left.y * user_img.shape[0]))
        shoulder_right_coords = (int(shoulder_right.x * user_img.shape[1]), int(shoulder_right.y * user_img.shape[0]))
        waist_coords = (int(waist.x * user_img.shape[1]), int(waist.y * user_img.shape[0]))

        # Resize clothing image
        cloth_width = abs(shoulder_left_coords[0] - shoulder_right_coords[0])
        cloth_height = int(cloth_width * (cloth_img.shape[0] / cloth_img.shape[1]))
        cloth_resized = cv2.resize(cloth_img, (cloth_width, cloth_height))

        # Define region to place the clothing image
        top_left = (shoulder_left_coords[0], shoulder_left_coords[1] - cloth_height)
        bottom_right = (top_left[0] + cloth_width, top_left[1] + cloth_height)

        # Place the clothing image on top of the user image
        user_img[top_left[1]:bottom_right[1], top_left[0]:bottom_right[0]] = cloth_resized

        # Save the resulting image
        cv2.imwrite(output_path, user_img)

        print(f"Fitted image saved at {output_path}")

# Get arguments from the PHP script
user_img_path = sys.argv[1]
cloth_img_path = sys.argv[2]
output_path = sys.argv[3]

# Process the images
fit_clothing_on_user(user_img_path, cloth_img_path, output_path)

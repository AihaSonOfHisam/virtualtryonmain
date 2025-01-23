<?php
// filepath: /c:/xampp/htdocs/Virtual-Try-On/user/index.php

// Start the session
session_start();

$isLoggedIn = isset($_SESSION['id']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try On</title>
    <link rel="stylesheet" href="index-style.css">
    <style>
        .banner_main {
            background: url(images/model.png);
            background-repeat: no-repeat;
            min-height: 600px;
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
            background-size: 100% 100%;
        }

        .text-bg {
            text-align: center;
            padding-bottom: 50px;
        }

        .text-bg h1 {
            color: black;
            font-size: 67px;
            line-height: 90px;
            font-weight: bold;
        }

        .text-bg strong {
            font-size: 34px;
            line-height: 50px;
            color: black;
            padding-bottom: 10px;
            display: block;
            font-weight: bold;
        }

        .text-bg span {
            /* font-family: 'Righteous', cursive; */
            color: black;
            font-size: 34px;
            line-height: 50px;
            font-weight: bold;
            padding-bottom: 20px;
            display: block;
        }

        .text-bg a {
            /* font-family: 'Righteous', cursive; */
            font-size: 17px;
            background-color: #af4ff0;
            color: #000;
            padding: 13px 0px;
            width: 100%;
            max-width: 190px;
            text-align: center;
            display: inline-block;
            transition: ease-in all 0.5s;
        }

        .d_flex {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search By Typing Keywords...">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <img src="images/account-logo.png" alt="Account Icon">
            <a href="userprofile.php"><span>Account</span> </a>
            <?php if ($isLoggedIn): ?>
                <a href="logoutprocess.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn">Logout</a>
            <?php endif; ?>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>
    <!-- <main>
        <div class="model-display">
            <div class="model-display">
                <img src="images/model.png" alt="Models" class="models-image">
            </div>
        </div>
    </main> -->
    <section class="banner_main">
         <div class="container">
            <div class="row d_flex">
               <div class="col-md-12">
                  <div class="text-bg">
                     <h1>Virtual Try On</h1>
                     <strong>Discover the Freedom of Fashion</strong>
                     <span>Try on Your Desired Clothes!</span>
                     <a style="border-radius: 10px" href="category.php">Try-On Now!</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['puzzle3_solved']) || $_SESSION['puzzle3_solved'] !== true) {
    header("Location: index.php");
    exit();
}

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game Result - Winner</title>
    <link rel="stylesheet" href="winner.css">
</head>

<body>
    <div class="result-container">
        <!-- WINNING MESSAGE -->
        <h1 class="win">🎉 You Escaped! 🎉</h1>
        <p class="message">Congratulations on solving all the puzzles and escaping the vault!</p>

        <a href="homepage.html"><button>Play Again</button></a>
    </div>

    <!-- Winning image (optional, you can change the image or remove it) -->
    <img src="./images/vistory.png" alt="Victory" class="flash-image">
</body>

</html>
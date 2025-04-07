<?php
session_start();

if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 1;
}

$correctAnswer = "echo";
$hint = "Think of something that reflects sound.";
$feedback = "";
$useFadeEffect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hint'])) {
        $_SESSION['used_hint_' . $_POST['level']] = true;
    } else {
        $answer = strtolower(trim($_POST['answer']));
        
        if ($answer === $correctAnswer) {
            $_SESSION['level'] = 2;
            $_SESSION['puzzle1_solved'] = true;
            $useFadeEffect = true;
        } else {
            $feedback = "Wrong answer! Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="level_1_styles.css">
    <title>Level 1</title>
    <?php if ($useFadeEffect): ?>
        <meta http-equiv="refresh" content="1;url=puzzle2.php">
    <?php endif; ?>
</head>
<body>
<div id="canvas">
    <div class="room">
        <h2>Level 1: Riddle</h2>
        <p>"I speak without a mouth and hear without ears..."</p>
        <form method="POST">
            <input type="text" name="answer" required>
            <button type="submit">Unlock</button>
        </form>
        <p class="feedback"><?= $feedback ?></p>
        <form method="POST">
            <input type="hidden" name="level" value="1">
            <button name="hint" type="submit">Use Hint</button>
        </form>
        <?php if (isset($_SESSION['used_hint_1']) && $_SESSION['used_hint_1']): ?>
            <p class="hint"><?= $hint ?></p>
        <?php endif; ?>
    </div>
    <?php if ($useFadeEffect): ?>
        <div class="overlay"></div>
    <?php endif; ?>
</div>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] < 2) {
    header("Location: index.php");
    exit();
}

$correctAnswer = "hello";
$hint = "Match each number to a letter in the alphabet.";
$feedback = "";
$useFadeEffect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hint'])) {
        $_SESSION['used_hint_' . $_POST['level']] = true;
    } else {
        $answer = strtolower(trim($_POST['answer']));
        
        if ($answer === $correctAnswer) {
            $_SESSION['level'] = 3;
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
    <title>Level 2</title>
    <?php if ($useFadeEffect): ?>
        <meta http-equiv="refresh" content="1;url=level3.php">
    <?php endif; ?>
</head>
<body>
<div id="canvas2">
    <div class="room">
        <h2>Level 2: Codebreaker</h2>
        <p>"Decode the message: <strong>8 5 12 12 15</strong><br>(A=1, B=2, ..., Z=26)"</p>
        <form method="POST">
            <input type="text" name="answer" required>
            <button type="submit">Unlock</button>
        </form>
        <p class="feedback"><?= $feedback ?></p>
        <form method="POST">
            <input type="hidden" name="level" value="2">
            <button name="hint" type="submit">Use Hint</button>
        </form>
        <?php if (isset($_SESSION['used_hint_2']) && $_SESSION['used_hint_2']): ?>
            <p class="hint"><?= $hint ?></p>
        <?php endif; ?>
    </div>
    <?php if ($useFadeEffect): ?>
        <div class="overlay"></div>
    <?php endif; ?>
</div>
</body>
</html>

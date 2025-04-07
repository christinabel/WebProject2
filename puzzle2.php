<?php
session_start();

if (!isset($_SESSION['puzzle1_solved']) || $_SESSION['puzzle1_solved'] !== true) {
    header("Location: index.php");
    exit();
}

$words = [
    "ESCAPE" => "What you must do to win.",
    "LOCKED" => "How the vault door currently is.",
    "PUZZLE" => "You must solve this to proceed.",
    "CODE" => "A secret sequence to unlock something.",
    "KEYPAD" => "What you use to enter the digits.",
];

if (!isset($_SESSION['current_word'])) {
    $keys = array_keys($words);
    $random_word = $keys[array_rand($keys)];
    $_SESSION['current_word'] = $random_word;
    $_SESSION['incorrect_attempts'] = 0;
}

$current_word = $_SESSION['current_word'];
$scrambled = str_shuffle($current_word);
$hint = $words[$current_word];
$message = "";
$containerClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answer = strtoupper(trim($_POST['answer']));

    if ($user_answer === $current_word) {
        $_SESSION['puzzle2_solved'] = true;
        unset($_SESSION['current_word'], $_SESSION['incorrect_attempts']);
        header("Location: puzzle3.php");
        exit();
    } else {
        $_SESSION['incorrect_attempts']++;
        $message = "❌ Incorrect! Try again.";

        if ($_SESSION['incorrect_attempts'] >= 3) {
            $keys = array_keys($words);
            $new_word = $current_word;
            while ($new_word === $current_word) {
                $new_word = $keys[array_rand($keys)];
            }
            $_SESSION['current_word'] = $new_word;
            $_SESSION['incorrect_attempts'] = 0;
            $message .= " The word has changed.";
        }

        $containerClass = "shake";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Puzzle 2 - Word Scramble</title>
    <link rel="stylesheet" href="puzzle2.css">
</head>
<body>
    <div class="fog"></div>

    <div class="container <?= $containerClass ?>">
        <h1>🔐 Vault Puzzle 2</h1>
        <p class="puzzle">Unscramble the word:</p>
        <p class="scrambled-word"><?= str_shuffle($_SESSION['current_word']) ?></p>
        <p class="hint">💡 Hint: <?= htmlspecialchars($words[$_SESSION['current_word']]) ?></p>

        <form method="post">
            <input type="text" name="answer" placeholder="Enter your answer..." required>
            <br>
            <button type="submit">Submit</button>
        </form>

        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

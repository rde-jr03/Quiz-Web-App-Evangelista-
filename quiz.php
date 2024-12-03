<?php
session_start();
if (!isset($_SESSION['level'])) {
    header('Location: settings.php');
    exit;
}

$level = $_SESSION['level'];
$range_start = isset($_SESSION['range_start']) && is_numeric($_SESSION['range_start']) ? (int)$_SESSION['range_start'] : ($level === '1-10' ? 1 : 11);
$range_end = isset($_SESSION['range_end']) && is_numeric($_SESSION['range_end']) ? (int)$_SESSION['range_end'] : ($level === '1-10' ? 10 : 100);
$operator = $_SESSION['operator'];
$num_questions = $_SESSION['num_questions'];
$max_diff = $_SESSION['max_diff'];
$current_question = $_SESSION['current_question'];

function generateQuestion($range_start, $range_end, $operator) {
    $num1 = rand($range_start, $range_end);
    $num2 = rand($range_start, $range_end);
    switch ($operator) {
        case 'add': return ["$num1 + $num2", $num1 + $num2];
        case 'sub': return ["$num1 - $num2", $num1 - $num2];
        case 'mul': return ["$num1 × $num2", $num1 * $num2];
    }
    return [null, null];
}

function generateChoices($answer, $max_diff) {
    $choices = [$answer];
    while (count($choices) < 4) {
        $fake = $answer + rand(-$max_diff, $max_diff);
        if ($fake != $answer && !in_array($fake, $choices)) {
            $choices[] = $fake;
        }
    }
    shuffle($choices);
    return $choices;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['end_quiz'])) {
        header('Location: results.php');
        exit;
    }

    $selected = (int)$_POST['choice'];
    $correct = (int)$_POST['correct_answer'];
    if ($selected === $correct) {
        $_SESSION['score']['correct']++;
    } else {
        $_SESSION['score']['wrong']++;
    }
    $_SESSION['current_question']++;

    if ($_SESSION['current_question'] >= $num_questions) {
        header('Location: results.php');
        exit;
    }
}

[$question, $answer] = generateQuestion($range_start, $range_end, $operator);
$choices = generateChoices($answer, $max_diff);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Math Quiz</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1, h2 {
            text-align: center;
            color: black;
        }

        h1 {
            margin-top: 5px;
            font-size: 30px;
        }

        h2 {
            font-size: 60px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .choices {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .choices button {
            padding: 10px 20px;
            font-size: 25px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #acdf87;
        }

        .end-quiz {
            background-color: green;
            font-weight: bold;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 50px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h1>Question <?= $current_question + 1 ?> of <?= $num_questions ?></h1>
        <h2><?= $question ?> = ?</h2>
        <form method="POST" action="quiz.php">
            <div class="choices">
                <?php foreach ($choices as $choice): ?>
                    <button type="submit" name="choice" value="<?= $choice ?>"><?= $choice ?></button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="correct_answer" value="<?= $answer ?>">
            <button type="submit" name="end_quiz" class="end-quiz">End Quiz</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['score'])) {
    header('Location: settings.php');
    exit;
}

$correct = $_SESSION['score']['correct'];
$wrong = $_SESSION['score']['wrong'];
$total = $correct + $wrong;
$grade = ($correct / $total) * 100;

session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
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


        .container {
            max-width: 600px;
            margin: 50px;
            padding: 50px;
            background-color: green;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 40px;
            color: white;
        }

        p {
            font-size: 20px;
            margin: 10px 0;
            color: white;
            margin-bottom: 10px;
        }

        .grade {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .score {
            font-size: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: white;
            color: black;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            margin-bottom: 40px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Results</h1>
        <p class="score">Correct Answers: <?= $correct ?></p>
        <p class="score">Wrong Answers: <?= $wrong ?></p>
        <p class="grade">Grade: <?= number_format($grade, 2) ?>%</p>
        <a href="settings.php">Back to Settings</a>
    </div>
</body>
</html>

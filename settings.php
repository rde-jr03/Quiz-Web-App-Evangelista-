<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['level'] = $_POST['level'];
    $_SESSION['range_start'] = $_POST['range_start'];
    $_SESSION['range_end'] = $_POST['range_end'];
    $_SESSION['operator'] = $_POST['operator'];
    $_SESSION['num_questions'] = (int)$_POST['num_questions'];
    $_SESSION['max_diff'] = (int)$_POST['max_diff'];

    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = ['correct' => 0, 'wrong' => 0];

    header('Location: quiz.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz Settings</title>
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

        h1 {
            color: black;
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            background-color: green;
            padding: 50px;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            color: white;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        select{
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="number"] {
            width: 95%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: white;
            color: black;
            font-weight: bold;
            padding: 10px 15px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            width: 100%;
        }

        #custom-range {
            display: none;
            margin-bottom: 20px;
        }

        #custom-range input {
            width: 48%;
            margin-right: 4%;
        }
        
    </style>
</head>
<body>
    <div>
        <h1>Settings</h1>
        <form method="POST" action="settings.php">
            <label for="level">Level:</label>
            <select name="level" id="level" required onchange="toggleCustomRange(this.value)">
                <option value="1-10">Level 1 (1-10)</option>
                <option value="11-100">Level 2 (11-100)</option>
                <option value="custom">Custom Level</option>
            </select>

            <div id="custom-range">
                <label>Custom Range:</label>
                <input type="number" name="range_start" placeholder="Start" min="1" max="100">
                <input type="number" name="range_end" placeholder="End" min="1" max="100">
            </div>

            <label for="operator">Operator:</label>
            <select name="operator" required>
                <option value="add">Addition</option>
                <option value="sub">Subtraction</option>
                <option value="mul">Multiplication</option>
            </select>

            <label for="num_questions">Number of Questions:</label>
            <input type="number" name="num_questions" min="1" max="50" required>

            <label for="max_diff">Max Difference for Choices:</label>
            <input type="number" name="max_diff" min="1" max="50" required>

            <button type="submit">Start Quiz</button>
        </form>
    </div>

    <script>
        function toggleCustomRange(value) {
            document.getElementById('custom-range').style.display = (value === 'custom') ? 'block' : 'none';
        }
    </script>
</body>
</html>

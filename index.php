<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Органайзер</title>
    <link rel="stylesheet" type="text/css" href="Style.css">
</head>
<body>
<h1>Органайзер</h1>
<form action="index.php" method="post">
    <label for="task">Название задача:</label>
    <textarea type="text" id="task" name="task" required></textarea>
    <label for="date">Дата:</label>
    <input type="date" id="date" name="date" required>
    <button type="submit" name="addTask">Добавить задачу</button>
</form>

<h2>Отобразить задачи по</h2>
<form action="index.php" method="post">
    <label for="day">День:</label>
    <input type="date" id="day" name="day">
    <button type="submit" name="filterDay">Показать по дням</button>
</form>
<form action="index.php" method="post">
    <label for="week">Неделя (Год-Неделя):</label>
    <input type="week" id="week" name="week">
    <button type="submit" name="filterWeek">Показать по неделям</button>
</form>
<form action="index.php" method="post">
    <label for="month">Месяц (Год-Месяц):</label>
    <input type="month" id="month" name="month">
    <button type="submit" name="filterMonth">Показать по месяцам</button>
</form>

<h2>Задачи</h2>
<?php
include 'Organizer.php';
session_start();


if (!isset($_SESSION['organizer'])) {
    $_SESSION['organizer'] = new Organizer();
}

$organizer = $_SESSION['organizer'];

if (isset($_POST['addTask'])) {
    $task = $_POST['task'];
    $date = $_POST['date'];
    $organizer->addTask($task, $date);
    $_SESSION['organizer'] = $organizer;
}

if (isset($_POST['removeTask'])) {
    $index = $_POST['index'];
    $organizer->removeTask($index);
    $_SESSION['organizer'] = $organizer;
}

if (isset($_POST['filterDay'])) {
    $day = $_POST['day'];
    $tasks = $organizer->getTasksByDay($day);
} elseif (isset($_POST['filterWeek'])) {
    $week = date('W', strtotime($_POST['week'] . '-1'));
    $tasks = $organizer->getTasksByWeek($week);
} elseif (isset($_POST['filterMonth'])) {
    $month = $_POST['month'];
    $tasks = $organizer->getTasksByMonth($month);
} else {
    $tasks = $organizer->getAllTasks();
}
?>

<ul>
    <?php foreach ($tasks as $index => $task): ?>
        <li>
            <?php echo htmlspecialchars($task['task']) . " - " . htmlspecialchars($task['date']); ?>
            <form action="index.php" method="post" style="display:inline;">
                <input type="hidden" name="index" value="<?php echo $index; ?>">
                <button type="submit" name="removeTask">Удалить</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>

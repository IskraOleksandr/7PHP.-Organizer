<?php
class Organizer {
    private $tasks = [];

    public function __construct() {
        // Инициализируем список дел
        $this->tasks = [];
    }

    public function addTask($task, $date) {
        $this->tasks[] = ['task' => $task, 'date' => $date];
    }

    public function getTasksByDay($day) {
        return array_filter($this->tasks, function($task) use ($day) {
            return date('Y-m-d', strtotime($task['date'])) == $day;
        });
    }

    public function getTasksByWeek($week) {
        return array_filter($this->tasks, function($task) use ($week) {
            return date('W', strtotime($task['date'])) == $week;
        });
    }

    public function getTasksByMonth($month) {
        return array_filter($this->tasks, function($task) use ($month) {
            return date('Y-m', strtotime($task['date'])) == $month;
        });
    }

    public function removeTask($index) {
        if (isset($this->tasks[$index])) {
            unset($this->tasks[$index]);
            $this->tasks = array_values($this->tasks);
        }
    }

    public function getAllTasks() {
        return $this->tasks;
    }
}
?>


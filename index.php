<?php
    require 'vendor/autoload.php';

    use Service\Task;


    try {
        $task = new Task();
        $data = json_decode(file_get_contents('php://input'), true);
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST':
                $task->saveTask($data);
                break;

            case 'PUT':
                $task->editTask($data);
                break;

            case 'GET':
                $tasks = $task->getTasks();
                var_dump($tasks);
                break;

            case 'DELETE':
                $task->deleteTask($data);
                break;
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

    $task = null;

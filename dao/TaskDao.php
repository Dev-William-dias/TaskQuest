<?php

class TaskDao {

    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function create(string $title, string $reward, string $priority, int $points, DateTime $createdAt): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tasks (title, reward, points, priority, status, created_at) VALUES (:title, :reward, :points, :priority, :status, :created_at)");

            $stmt->bindValue(":title", $title);
            $stmt->bindValue(":reward", $reward);
            $stmt->bindValue(":points", $points);
            $stmt->bindValue(":priority", $priority);
            $stmt->bindValue(":status", 0);
            $stmt->bindValue(":created_at", $createdAt->format('Y-m-d H:i:s'));

            return $stmt->execute();
        } catch (Exception $e) {
            Utill::logError("TaskDao create: ".$e->getMessage());
            return false;
        }
    }


    public function getAll(): array {
        try {
            $arrayTasks = [];
        
            $sql = "SELECT * FROM tasks";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($tasks as $task) {
                $arrayTasks[] = ["id" => $task["id"], "title" => $task["title"], "points" => $task["points"], "priority" => $task["priority"], "status" => $task["status"]];
            }

            return $arrayTasks;
        } catch (Exception $e) {
            Utill::logError("TaskDao getAll: ".$e->getMessage());
            return [];
        }
    }

}
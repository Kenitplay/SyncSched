<?php

class Teacher {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getTeacherCount() {
        $query = "SELECT COUNT(*) AS count FROM teachers";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}

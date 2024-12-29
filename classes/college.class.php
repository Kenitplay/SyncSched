<?php

class College {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getCollegeCount() {
        $query = "SELECT COUNT(*) AS count FROM college";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getCourseCountByCollege($college_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM course WHERE college_id = ?");
        $stmt->execute([$college_id]);
        return $stmt->fetchColumn();
    }
    

    public function getRequestCountByCollege($college_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM pending_students WHERE college_id = ?");
        $stmt->execute([$college_id]);
        return $stmt->fetchColumn();
    }
    
}

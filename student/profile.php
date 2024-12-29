<?php
require_once '../classes/database.class.php';
require_once '../classes/admin.class.php';

session_start();

// Check if the user is logged in as a student
if ($_SESSION['user_role'] !== 'student') {
    die("Access denied. This page is only accessible to students.");
}

// Fetch the logged-in student's ID (assuming it's stored in the session)
if (!isset($_SESSION['student_id'])) {
    die("Access denied. Student ID not specified.");
}

$student_id = $_SESSION['student_id'];

// Initialize database and student class
$db = new Database();
$student = new Admin($db);

// Fetch the student's profile data
$student_profile = $student->getStudentProfile($student_id);

if (!$student_profile) {
    die("Student profile not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <!-- Include Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            padding: 30px;;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Side Navigation -->
            <div class="col-md-1 side-nav">
                <?php require_once '../includes/side_nav.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="main-content">
                    <h2 class="mt-4 text-center">Student Profile</h2>
                    <div class="card mx-auto mt-4" style="max-width: 600px;">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Welcome, <?php echo htmlspecialchars($student_profile['first_name']); ?>!</h4>
                            <p class="card-text">
                                <strong>Full Name:</strong> 
                                <?php 
                                echo htmlspecialchars($student_profile['first_name']) . ' ' . 
                                    htmlspecialchars($student_profile['middle_initial']) . '. ' . 
                                    htmlspecialchars($student_profile['last_name']); 
                                ?>
                            </p>
                            <p class="card-text">
                                <strong>Course:</strong> <?php echo htmlspecialchars($student_profile['course']); ?>
                            </p>
                            <p class="card-text">
                                <strong>Year Level:</strong> <?php echo htmlspecialchars($student_profile['year_level']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
session_start(); // Start the session

// Check if the user is logged in as a teacher
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'teacher') {
    // Redirect to login page if the user is not a teacher
    header("Location: ../login.php");
    exit;
}

// Include necessary files
require_once '../classes/database.class.php';
require_once '../classes/teacher.class.php'; // Teacher class
require_once '../classes/college.class.php'; // College class
require_once '../classes/admin.class.php';

// Initialize database connection and classes
$db = new Database();
$teacher = new Teacher($db);
$college = new College($db);
$admin = new Admin($db);


$college_id = $_SESSION['college_id'] ?? null;

if (!$college_id) {
    echo "No college assigned to this teacher.";
    exit;
}

// Fetch counts specific to the teacher's assigned college
$student_count = $admin->getStudentCountByCollege($college_id);
$course_count = $college->getCourseCountByCollege($college_id);
$request_count = $college->getRequestCountByCollege($college_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<?php require_once '../includes/side_nav.php'; ?>

<!-- Main Content -->
<div class="main-content" style="margin-left: 260px; padding: 20px;">
    <div class="container mt-5">
        <div class="bg-gray-100 p-12 rounded-2xl shadow">
            <h2 class="mb-4 font-bold text-2xl bg-blue-300 p-2 rounded shadow text-center">Teacher Dashboard</h2>

            <div class="flex flex-wrap justify-between gap-4">
                <!-- Students Card -->
                <a href="students.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
                    <div class="card border p-4 h-full bg-green-200 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl">Students</h5>
                            <p class="card-text"><?= $student_count; ?></p>
                            <input type="hidden" id="studentCount" value="<?= $student_count; ?>">
                        </div>
                    </div>
                </a>

                <!-- Courses Card -->
                <a href="courses.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
                    <div class="card border p-4 h-full bg-blue-200 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl">Courses</h5>
                            <p class="card-text"><?= $course_count; ?></p>
                            <input type="hidden" id="courseCount" value="<?= $course_count; ?>">
                        </div>
                    </div>
                </a>

                <!-- Requests Card -->
                <a href="request.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
                    <div class="card border p-4 h-full bg-yellow-200 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl">Requests</h5>
                            <p class="card-text"><?= $request_count; ?></p>
                            <input type="hidden" id="requestCount" value="<?= $request_count; ?>">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="collegeDataChart" class="w-full sm:w-3/4 md:w-2/3 lg:w-1/2 h-80 mx-auto"></canvas>
        </div>
    </div>

    <script>
        // Data for chart rendering
        var ctxCollegeData = document.getElementById('collegeDataChart').getContext('2d');

        var studentCount = document.getElementById('studentCount').value;
        var courseCount = document.getElementById('courseCount').value;
        var requestCount = document.getElementById('requestCount').value;

        var collegeDataChart = new Chart(ctxCollegeData, {
            type: 'bar',
            data: {
                labels: ['Students', 'Courses', 'Requests'],
                datasets: [{
                    label: 'Counts',
                    data: [studentCount, courseCount, requestCount],
                    backgroundColor: ['green', 'blue', 'yellow']
                }]
            }
        });
    </script>
</div>
</body>
</html>

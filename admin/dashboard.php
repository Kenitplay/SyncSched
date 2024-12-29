<?php
session_start(); // Make sure this is the first thing in the file

// Check if the user is logged in as admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login page if the user is not an admin
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php require_once '../includes/side_nav.php'; ?>
</body>
</html>

<?php
require_once '../classes/database.class.php';
require_once '../classes/admin.class.php'; // Admin class to fetch admin counts
require_once '../classes/college.class.php'; // College class to fetch college counts
require_once '../classes/teacher.class.php'; // Teacher class to fetch teacher counts

// Redirect unauthorized users
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'teacher') {
    header('Location: ../accounts/login.php');
    exit;
}

// Initialize database connection and classes
$db = new Database();
$admin = new Admin($db);          // For fetching admin counts
$college = new College($db);      // For fetching college counts
$teacher = new Teacher($db);      // For fetching teacher counts

// Get the counts
$admin_counts = $admin->getAdminCount();   // Get admin counts
$college_count = $college->getCollegeCount(); // Get college count
$teacher_count = $teacher->getTeacherCount(); // Get teacher count
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="./another.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<?php require_once '../includes/side_nav.php'; ?>
<!-- Main Content -->

<div class="main-content" style="margin-left: 260px; padding: 20px;">
    <div class="container mt-5"> 
        <div class="bg-gray-100 p-12 rounded-2xl shadow">
            <h2 class="mb-4 font-bold text-2xl bg-blue-300 p-2 rounded shadow text-center">Admin Dashboard</h2>

            <div class="flex flex-wrap justify-between gap-4">
    <!-- Admin Users Card -->
    <a href="admin.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
        <div class="card border p-4 h-full bg-red-200 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="card-body">
                <h5 class="card-title font-semibold text-xl">Admin Users</h5>
                <p class="card-text"><?= $admin_counts; ?></p>
                <input type="hidden" id="adminCount" value="<?= $admin_counts; ?>">
            </div>
        </div>
    </a>

    <!-- Teacher Users Card -->
    <a href="teacher.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
        <div class="card border p-4 h-full shadow-xl bg-purple-300 hover:shadow-2xl transition-shadow duration-300">
            <div class="card-body">
                <h5 class="card-title font-semibold text-xl">Teacher Users</h5>
                <p class="card-text"><?= $teacher_count; ?></p>
                <input type="hidden" id="teacherCount" value="<?= $teacher_count; ?>">
            </div>
        </div>
    </a>

    <!-- Colleges Card -->
    <a href="colleges.php" class="w-full sm:w-1/4 md:w-1/5 lg:w-1/5">
        <div class="card border p-4 h-full rounded bg-yellow-200 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="card-body">
                <h5 class="card-title font-semibold text-xl">Colleges</h5>
                <p class="card-text"><?= $college_count; ?></p>
                <input type="hidden" id="collegeCount" value="<?= $college_count; ?>">
            </div>
        </div>
    </a>
</div>

        </div>
    </div>

    <!-- User Chart -->
    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="userCountsChart" class="w-full sm:w-3/4 md:w-2/3 lg:w-1/2 h-80 mx-auto"></canvas>
        </div>
    </div>

    <!-- Section and College Charts -->
    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="sectionsChart" class="w-full sm:w-3/4 md:w-2/3 lg:w-1/2 h-80 mx-auto"></canvas>
        </div>
        <div class="col-md-12">
            <canvas id="collegesChart" class="w-full sm:w-3/4 md:w-2/3 lg:w-1/2 h-80 mx-auto"></canvas>
        </div>
    </div>

    <script>
        // Data for chart rendering
        var ctxUserCounts = document.getElementById('userCountsChart').getContext('2d');
        var ctxSections = document.getElementById('sectionsChart').getContext('2d');
        var ctxColleges = document.getElementById('collegesChart').getContext('2d');

        var adminCount = document.getElementById('adminCount').value;
        var teacherCount = document.getElementById('teacherCount').value;
        var collegeCount = document.getElementById('collegeCount').value;

        // User Counts Chart
        var userCountsChart = new Chart(ctxUserCounts, {
            type: 'bar',
            data: {
                labels: ['Admins', 'Teachers', 'Colleges'],
                datasets: [{
                    label: 'Counts',
                    data: [adminCount, teacherCount, collegeCount],
                    backgroundColor: ['red', 'purple', 'yellow'],
                }]
            }
        });

        // Colleges Chart
        var collegesChart = new Chart(ctxColleges, {
            type: 'pie',
            data: {
                labels: ['Colleges'],
                datasets: [{
                    label: 'Colleges',
                    data: [collegeCount],
                    backgroundColor: ['yellow']
                }]
            }
        });
    </script>

    <script src="../js/dashboard.js"></script>
</div>
</body>
</html>

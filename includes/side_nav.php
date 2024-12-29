<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="./another.css" rel="stylesheet">
    <link href="../css/another.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    
<div id="sidebar" class=" w-64 h-full ">

    <?php
    if ($_SESSION['user_role'] === 'admin') {
    ?>
    <h3 class="admin text-center font-bold text-3xl pt-10 text-white">Admin</h3>
    <div class="text-bold pt-7 pl-8 sidebar text-white">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="colleges.php"><i class="fas fa-school"></i> Colleges</a>
        <a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
        <a href="admin.php"><i class="fas fa-user-shield"></i> Administrator</a>

        <div class="font-bold">
            <a href="../logout.php" 
               class="logout-button text-white px-4 py-2 rounded shadow-md">
               <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>
    <?php
    }
    ?>
    <?php
    if ($_SESSION['user_role'] === 'teacher') {
    ?>
    <h3 class="text-center font-bold text-3xl pt-10 text-white">Teacher</h3>
    <div class="text-bold pt-7 pl-8 sidebar text-white">
        <a href="../teacher/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="../teacher/courses.php"><i class="fas fa-book"></i> Courses</a>
        <a href="../teacher/schedules.php"><i class="fas fa-calendar-alt"></i> Schedules</a>
        <a href="../teacher/students.php"><i class="fas fa-users"></i> Students</a>
        <a href="../teacher/request.php"><i class="fas fa-envelope"></i> Requests</a>
        <div class="font-bold">
            <a href="../logout.php" 
               class="logout-button text-white px-4 py-2 rounded shadow-md">
               <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>
    <?php
    }
    ?>

<?php
    if ($_SESSION['user_role'] === 'student') {
    ?>
    <h3 class=" text-center font-bold text-3xl pt-10 text-white">Student</h3>
    <div class="text-bold pt-7 pl-8 sidebar text-white">
        <a href="user.php"><i class="fas fa-calendar-check"></i> My Schedules</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="edit_password.php"><i class="fas fa-lock"></i> Edit Password</a>
        <div class="font-bold">
            <a href="../logout.php" 
               class="logout-button">
               <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>
    <?php
    }
    ?>
</div>

<script>
    document.querySelectorAll('.sidebarcolor a').forEach(link => {
        link.addEventListener('click', function() {
            // Remove active class from all links
            document.querySelectorAll('.sidebarcolor a').forEach(link => link.classList.remove('active'));
            // Add active class to the clicked link
            this.classList.add('active');
        });
    });
</script>

</body>
</html>


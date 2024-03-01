<?php
session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__."/database.php";

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    // Check if user exists
    if ($user) {
        $role = $user["role"]; // Assign the role to the $role variable
    } else {
        // Handle case where user doesn't exist
        $role = "Member"; // or assign a default role if needed
    }

    // Check if user is admin or owner
    $is_admin_or_owner = ($role === "admin" || $role === "Owner");
} else {
    // If user is not logged in, assume a default role or handle as per your application's logic
    $role = "Guest";
    $is_admin_or_owner = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <header>
        <h1>Florida State RP</h1>
    </header>
    <div class="taskbar">
        <div class="task">
            <a href="#">Task 1</a>
        </div>
        <div class="task">
            <a href="#">Task 2</a>
        </div>
        <?php if ($is_admin_or_owner): ?>
            <!-- Show the following task only to admin or owner -->
            <div class="task">
                <a href="dashboard.php">Dashboard</a>
            </div>
        <?php endif; ?>
        <div class="task">
            <a href="#">Task 3</a>
        </div>
        <!-- Add more tasks here -->
    </div>
    <div class="content">
        <?php if (isset($user)): ?>
            <p>Hello, <?= htmlspecialchars($user["name"]) ?></p>
            <p>Your role is: <?= htmlspecialchars($role) ?></p> <!-- Display the user's role -->
            <p></p>
        <?php else: ?>
            <p><a href="login.php">Log in</a> or <a  href="signup.html">sign up</a></p>
        <?php endif; ?>
    </div>
</body>
</html>

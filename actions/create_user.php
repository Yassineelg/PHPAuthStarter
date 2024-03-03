<?php

// Include necessary classes
require_once '../classes/Database.php';
require_once '../classes/User.php';

// Initialize message class
$messageClass = "";

// Check if form data is set
if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    // Create new Database and User instances
    $db = new Database();
    $user = new User($db);

    // Attempt to create user
    if ($user->createUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        // Success message
        $message = "User created successfully!";
        $messageClass = "success";
    } else {
        // Failure message
        $message = "Failed to create user. Please check your inputs or try a different email.";
        $messageClass = "error";
    }
} else {
    // Form not fully filled out
    $message = "Please fill in all the fields.";
    $messageClass = "error";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Registration Result</h1>
    <!-- Display message -->
    <p class="<?php echo $messageClass; ?>">
        <?php echo $message; ?>
    </p>
    <div class="navigation">
        <!-- Navigation links -->
        <a href="../views/index.php" class="btn">Home</a>
        <?php if ($messageClass == "success"): ?>
            <a href="../views/login.php" class="btn">Login</a>
        <?php else: ?>
            <a href="../views/register.php" class="btn">Retry</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

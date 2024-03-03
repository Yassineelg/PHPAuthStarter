<?php

// Include necessary classes
require_once '../classes/Database.php';
require_once '../classes/User.php';

// Initialize message class
$messageClass = "";

// Check if form data is set
if (isset($_POST['email'], $_POST['password'])) {
    // Create new Database and User instances
    $db = new Database();
    $user = new User($db);

    // Attempt to authenticate user
    $authenticatedUser = $user->authenticateUser($_POST['email'], $_POST['password']);
    if ($authenticatedUser) {
        // Success message
        $message = "User authenticated successfully!";
        $messageClass = "success";
    } else {
        // Failure message
        $message = "Failed to authenticate user. Please check your inputs.";
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
    <title>User Authentication</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Authentication Result</h1>
    <!-- Display message -->
    <p class="<?php echo $messageClass; ?>">
        <?php echo $message; ?>
    </p>
    <div class="navigation">
        <!-- Navigation links -->
        <a href="index.php" class="btn">Home</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</div>
</body>
</html>
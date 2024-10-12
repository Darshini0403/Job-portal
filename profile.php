<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerVibe | Profile</title>
    <link rel="stylesheet" href="profilep.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav class="navbar">
                <div class="container">
                    <a href="home.html" class="logo">CareerVibe</a>
                    <ul class="nav-links">
                        <li><a href="home.html">Home</a></li>
                        <li><a href="jobs.html">Find Jobs</a></li>
                        <li><a href="post-job.html">Post a Job</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="profile-container">
            <aside class="sidebar">
                <ul class="sidebar-links">
                    <li><a href="my-jobs.php">My Jobs</a></li>
                    <li><a href="jobs-applied.php">Jobs Applied</a></li>
                    <li><a href="profile.php">Edit Details</a></li>
                </ul>
            </aside>

            <main class="profile-main">
                <h1>Edit Your Details</h1>
                <form action="profile.php" method="post" class="profile-form">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="john.doe@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="********" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="********" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Details</button>
                </form>
            </main>
        </div>

        <footer>
            <div class="container">
                <p>© 2024 CareerVibe, All Rights Reserved</p>
                <ul class="footer-links">
                    <li><a href="privacy.html">Privacy Policy</a></li>
                    <li><a href="terms.html">Terms of Service</a></li>
                </ul>
            </div>
        </footer>
    </div>
</body>
</html>
<?php
// Start session to use session variables (if needed)
session_start();

// Include your database connection file
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    // Validate password and confirm password
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Assuming the user's ID is stored in the session after login
    $userId = $_SESSION['user_id'];

    // Update the user's details in the database
    $sql = "UPDATE users SET name = '$name', email = '$email', password = '$hashedPassword' WHERE id = '$userId'";

    if (mysqli_query($conn, $sql)) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

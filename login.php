<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerVibe | Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
<header>
    <nav class="navbar">
        <a href="home.html" class="logo">CareerVibe</a> <!-- First row -->

        <div class="navbar-row">
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="find-jobs.php">Find Jobs</a></li>
                <li><a href="post-job.php">Post a Job</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>

            <div class="auth-buttons">
                <a href="login.php" class="loginapp">Login</a>
                <a href="signup.php" class="regapp">Sign Up</a>
                <a href="logout.php" class="logoutapp">Logout</a> <!-- Logout button -->
                <a href="profile.php" class="profile-icon">
                    <img src="profile image.webp" alt="Profile Icon" />
                </a>
            </div>
        </div>
    </nav>
</header>

<main>
    <section class="login">
        <div class="container">
            <h1>Login to Your Account</h1>

            <?php
            session_start();

            // Display login success or error messages
            if (isset($_SESSION['login_message'])) {
                echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['login_message']) . "</p>";
                unset($_SESSION['login_message']); // Clear the message after displaying
            }
            if (isset($_SESSION['login_error'])) {
                echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['login_error']) . "</p>";
                unset($_SESSION['login_error']); // Clear the message after displaying
            }
            ?>

            <form action="login.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="john.doe@example.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>© 2024 CareerVibe, All Rights Reserved</p>
        <ul class="footer-links">
            <li><a href="privacy.html">Privacy Policy</a></li>
            <li><a href="terms.html">Terms of Service</a></li>
        </ul>
    </div>
</footer>
</body>
</html>

<?php
// Database connection details
$servername = "localhost:3307"; // Adjust if necessary
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    // Ensure email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Prepare SQL to fetch user by email
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password']; // Get the hashed password from the DB

            // Verify the entered password with the hashed password
            if (password_verify($password, $hashed_password)) {
                // Login successful
                $_SESSION['email'] = $email; // Store user email in session
                $_SESSION['user_id'] = $row['id']; // Store user ID in session
                $_SESSION['login_message'] = "Login successful. Redirecting..."; // Success message
                header("Location: profile.php"); // Redirect to profile page
                exit();
            } else {
                // Invalid password
                $_SESSION['login_error'] = "Invalid email or password."; // Set error message
            }
        } else {
            // Invalid email
            $_SESSION['login_error'] = "Invalid email or password."; // Set error message
        }

        $stmt->close();
    } else {
        $_SESSION['login_error'] = "Please fill in both email and password."; // Set error message
    }
}

$conn->close();
?>

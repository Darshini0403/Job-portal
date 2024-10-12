<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerVibe | Sign Up</title>
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
        <section class="signup">
            <div class="container">
                <h1>Create an Account</h1>
                <form action="signup.php" method="post" class="signup-form">
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
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>

                <?php
// Database connection details
$servername = "localhost:3307"; // Update the port if necessary
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if email already exists
    $email_check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($email_check);

    if ($result->num_rows > 0) {
        echo "User already exists with this email.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. <a href='login.php'>Login</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
}
?>

<?php
session_start();

// Database connection
$servername = "localhost:3307"; // Adjust if necessary
$username = "root";
$password = "";
$dbname = "job portal";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    die("User not logged in or session ID not set.");
}

// Get the logged-in user's ID
$user_id = $_SESSION['id']; // Assuming the user ID is stored in session after login

// Fetch jobs the user has applied to
$sql = "SELECT jobs.title, jobs.company, jobs_applied.applied_date 
        FROM jobs_applied 
        JOIN jobs ON jobs_applied.job_id = jobs.id 
        WHERE jobs_applied.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Applied</title>
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
                        <li><a href="find-jobs.php">Find Jobs</a></li>
                        <li><a href="post-job.php">Post a Job</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="profile-container">
            <aside class="sidebar">
                <ul class="sidebar-links">
                    <li><a href="my-jobs.html">My Jobs</a></li>
                    <li><a href="jobs-applied.php">Jobs Applied</a></li>
                    <li><a href="profile.php">Edit Details</a></li>
                </ul>
            </aside>

            <main class="profile-main">
                <h1>Jobs You Applied For</h1>
                <?php if ($result->num_rows > 0): ?>
                    <ul class="jobs-list">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <?php echo htmlspecialchars($row['company']); ?><br>
                                Applied on: <?php echo htmlspecialchars($row['applied_date']); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>You haven't applied for any jobs yet.</p>
                <?php endif; ?>
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
$stmt->close();
$conn->close();
?>

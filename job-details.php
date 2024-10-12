<?php
session_start();

// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "job portal";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get job ID from query string
$job_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$job_id) {
    die("No job ID specified.");
}

// Fetch job details
$sql = "SELECT title, company, location, posted_date FROM jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    $job = null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="job-details.css">
</head>
<body>
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

    <main class="job-details">
        <div class="container">
            <?php if ($job): ?>
                <h1><?php echo htmlspecialchars($job['title']); ?></h1>
                <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                <p><strong>Posted on:</strong> <?php echo htmlspecialchars($job['posted_date']); ?></p>
            <?php else: ?>
                <p>Job details not found.</p>
            <?php endif; ?>
        </div>
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
$stmt->close();
$conn->close();
?>

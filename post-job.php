<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link rel="stylesheet" href="post-job.css">
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

        <div class="post-job-container">
            <h1>Post a New Job</h1>
            <form action="post-job.php" method="POST" class="post-job-form">
                <div class="form-group">
                    <label for="job_title">Job Title:</label>
                    <input type="text" id="job_title" name="job_title" required>
                </div>
                <div class="form-group">
                    <label for="company_name">Company Name:</label>
                    <input type="text" id="company_name" name="company_name" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="job_description">Job Description:</label>
                    <textarea id="job_description" name="job_description" rows="5" required></textarea>
                </div>
                <button type="submit">Post Job</button>
            </form>
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
session_start();

// Database connection details
$servername = "localhost:3307"; // Adjust if necessary
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to post a job.";
    exit();
}

// Get job details from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['job_title'];
    $company = $_POST['company_name'];
    $location = $_POST['location'];
    $description = $_POST['job_description'];
    $posted_date = date('Y-m-d'); // Use the current date

    // Insert the job into the jobs table
    $sql = "INSERT INTO jobs (title, company, location, description, posted_date, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the query
    $stmt->bind_param("sssssi", $title, $company, $location, $description, $posted_date, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "Job posted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

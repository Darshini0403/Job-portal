<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost:3307"; // Adjust if necessary
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your jobs.";
    exit();
}

// Fetch jobs posted by the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT title, company, location, description, posted_date FROM jobs WHERE user_id = ?";
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
    <title>My Jobs | CareerVibe</title>
    <link rel="stylesheet" href="my-jobs.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="home.html" class="logo">CareerVibe</a>
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="find-jobs.php">Find Jobs</a></li>
                <li><a href="post-job.php">Post a Job</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Your Posted Jobs</h1>
        <div class="job-listings">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='job-item'>";
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company']) . "</p>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Posted on:</strong> " . htmlspecialchars($row['posted_date']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>You have not posted any jobs yet.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 CareerVibe, All Rights Reserved</p>
    </footer>

    <?php
    // Close the statement and connection
    $stmt->close();
    mysqli_close($conn);
    ?>
</body>
</html>

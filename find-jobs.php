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

// Fetch all jobs from the database
$sql = "SELECT title, company, location, description, posted_date FROM jobs";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Jobs</title>
    <link rel="stylesheet" href="find-jobs.css">
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
        <h1>Available Jobs</h1>
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
                echo "<p>No jobs available.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 CareerVibe, All Rights Reserved</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Jobs</title>
    <link rel="stylesheet" href="find-jobs.css">
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

        <div class="find-jobs-container">
            <main class="find-jobs-main">
                <h1>Find Jobs</h1>
                <form action="find-jobs.php" method="post">
                    <input type="text" name="search" placeholder="Search jobs..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Search</button>
                </form>
                <?php if ($result->num_rows > 0): ?>
                    <ul class="jobs-list">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <?php echo htmlspecialchars($row['company']); ?><br>
                                <?php echo htmlspecialchars($row['description']); ?><br>
                                Posted on: <?php echo htmlspecialchars($row['posted_date']); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No jobs found.</p>
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

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve videos from the database
$sql = "SELECT * FROM videos ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-top: 0;
        }

        .video-item {
            margin-bottom: 20px;
        }

        .video-item video {
            width: 100%;
            height: auto;
        }

        .video-item h2, .video-item p {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Display videos on the homepage -->
    <h1>Latest Videos</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $videoPath = "uploads/" . $row["filename"];
            ?>
            <div class="video-item">
                <video controls>
                    <source src="<?php echo $videoPath; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h2><?php echo $row["title"]; ?></h2>
                <p><?php echo $row["description"]; ?></p>
            </div>
            <?php
        }
    } else {
        echo "No videos found.";
    }

    $conn->close();
    ?>
</body>
</html>

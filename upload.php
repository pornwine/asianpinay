<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "videos";
    
    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $title = $_POST["title"];
    $description = $_POST["description"];
    
    // Handle file upload
    $targetDir = "uploads/";
    $filename = basename($_FILES["video"]["name"]);
    $targetPath = $targetDir . $filename;
    
    if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetPath)) {
        // Insert video metadata into the database
        $sql = "INSERT INTO videos (title, description, filename) VALUES ('$title', '$description', '$filename')";
        
        if ($conn->query($sql) === true) {
            echo "Video uploaded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>
    <style>
        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], textarea, input[type="file"], input[type="submit"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Video upload form HTML -->
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <label for="title">Video Title:</label>
        <input type="text" id="title" name="title" placeholder="Video Title" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Description"></textarea>
        
        <label for="video">Choose a video:</label>
        <input type="file" id="video" name="video" accept="video/*" required>
        
        <input type="submit" value="Upload">
    </form>
</body>
</html>

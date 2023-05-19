<?php
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];

    // Process and validate the data

    // Handle file upload
    $targetDir = "uploads/";
    $filename = basename($_FILES["video"]["name"]);
    $targetPath = $targetDir . $filename;
    $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);

    // Check if the uploaded file is a video
    $allowedTypes = array("mp4", "avi", "mov", "mkv");
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetPath)) {
            // Insert video metadata into the database
            $query = "INSERT INTO videos (title, description, filename) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $title, $description, $filename);
            $stmt->execute();
            $stmt->close();

            // Redirect back to the homepage or display a success message
            header("Location: upload.php");
            exit;
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file format. Allowed formats: " . implode(", ", $allowedTypes);
    }
}
?>

<!-- Video upload form HTML -->
<form method="POST" action="upload.php" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Video Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="file" name="video" accept="video/*" required>
    <input type="submit" value="Upload">
</form>

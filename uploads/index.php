<?php
require_once 'includes/db.php';

$query = "SELECT * FROM videos ORDER BY uploaded_at DESC";
$result = $conn->query($query);
?>

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
?>

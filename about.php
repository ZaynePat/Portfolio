<?php
// Fetch about data from the database
$sql = "SELECT * FROM about LIMIT 1";
$result = $conn->query($sql);
$aboutContent = $result->fetch_assoc();
?>

<h2>About Me</h2>
<form method="post" action="save_about.php">
    <label for="about_me_header">Header:</label>
    <input type="text" id="about_me_header" name="about_me_header" value="<?php echo $aboutContent['about_me_header']; ?>" required>
    
    <label for="about_me_content">Content:</label>
    <textarea id="about_me_content" name="about_me_content" required><?php echo $aboutContent['about_me_content']; ?></textarea>
    
    <button type="submit">Save</button>
</form>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include('includes/db.php');

$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM files WHERE id =?");
$query->bind_param('i', $user_id);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Witaj! Zarządzaj swoimi plikami PDF</h1>
    <h2>Twoje pliki PDF:</h2>
    <ul>
        <?php
        while ($file = $result->fetch_assoc()): ?>
        <li><?php echo $file['filename']; ?> - <?php echo $file['upload_time'];?></li>
        <?php endwhile;?>
    </ul>
    <form action="php/upload.php" method="post" enctype="multipart/form-data">
        <label for="pdf_file">Dodaj nowy plik PDF:</label>
        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
        <button type="submit">Wyślij</button>
    </form>
    <a href="php/logout.php">Wyloguj się</a>
</body>
</html>
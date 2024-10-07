<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include('../includes/db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    if(isset($_FILES['pdf_file'])) {
        $file_name = $_FILES['pdf_file']['name'];
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $upload_dir = '../uploads/'.$file_name;
        move_uploaded_file($file_tmp, $upload_dir);
        $query = $conn->prepare("INSERT INTO files (user_id, filename) VALUES (?,?)");
        $query->bind_param('is', $user_id, $file_name);
        $query->execute();
        header('Location: ../index.php');
        exit();
    }
}
?>
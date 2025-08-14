<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskid = $_POST['taskid'];
    $tasklabel = trim($_POST['tasklabel']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $today = date('Y-m-d');

    // Validasi deadline
    if ($deadline < $today) {
        echo "<script>alert('Deadline tidak boleh sebelum hari ini!'); window.location='index.php';</script>";
        exit;
    }

    $query = "UPDATE todolist 
              SET tasklabel='$tasklabel', description='$description', priority='$priority', deadline='$deadline' 
              WHERE taskid='$taskid'";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Gagal mengupdate tugas: " . mysqli_error($conn);
    }
}
?>

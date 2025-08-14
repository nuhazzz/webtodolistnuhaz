<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $query = "INSERT INTO todolist (tasklabel, description, priority, deadline, taskstatus, createdat) 
              VALUES ('$tasklabel', '$description', '$priority', '$deadline', 'open', NOW())";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan tugas: " . mysqli_error($conn);
    }
}
?>

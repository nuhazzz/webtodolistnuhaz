<?php
include "koneksi.php";
$id = $_GET["id"];
$sql = "DELETE FROM todolist WHERE taskid=$id";
mysqli_query($conn, $sql);
header("Location: index.php");

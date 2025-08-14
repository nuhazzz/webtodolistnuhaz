<?php
include "koneksi.php";
$id = $_GET["id"];
$sql = "UPDATE todolist SET taskstatus='close' WHERE taskid=$id";
mysqli_query($conn, $sql);
header("Location: index.php");

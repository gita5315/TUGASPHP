<?php
include 'config.php';
$id = $_GET['id'];
$conn->query("UPDATE todos SET is_done=1 WHERE id=$id");
header("Location: todo.php");

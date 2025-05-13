<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) exit;
$task = $_POST['task'];
$uid = $_SESSION['user_id'];
if (!empty($task)) {
    $stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
    $stmt->bind_param("is", $uid, $task);
    $stmt->execute();
}
header("Location: todo.php");

<?php
include 'connect.php';

if (!isset($_GET['request_id'])) {
    echo json_encode([]);
    exit();
}

$request_id = $_GET['request_id'];

$select_messages = $conn->prepare("SELECT * FROM `chats` WHERE request_id = ? ORDER BY timestamp ASC");
$select_messages->execute([$request_id]);
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>

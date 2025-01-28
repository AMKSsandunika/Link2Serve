<?php
include 'connect.php';

if (!isset($_POST['sender'], $_POST['receiver'], $_POST['message'], $_POST['request_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit();
}

$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$message = $_POST['message'];
$request_id = $_POST['request_id'];

$file_name = '';
$file_path = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_name = basename($_FILES['file']['name']);
    $file_tmp_path = $_FILES['file']['tmp_name'];
    $upload_dir = '../uploads/';
    $file_path = $upload_dir . $file_name;

    // Ensure the uploads directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!move_uploaded_file($file_tmp_path, $file_path)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
        exit();
    }

    // Store only the relative path to the file
    $file_path = 'uploads/' . $file_name;
}

$insert_message = $conn->prepare("INSERT INTO `chats` (sender, receiver, message, request_id, status, file_name, file_path) VALUES (?, ?, ?, ?, 'unread', ?, ?)");
$insert_message->execute([$sender, $receiver, $message, $request_id, $file_name, $file_path]);

if ($insert_message) {
    echo json_encode(['status' => 'success', 'message' => 'Message sent']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
}
?>

<?php
include '../components/connect.php';

if (!isset($_COOKIE['user_id'])) {
    header('location:../login.php');
    exit();
}

$user_id = $_COOKIE['user_id'];
$request_id = $_GET['request_id'];

$receiver_id_query = $conn->prepare("SELECT sender, receiver FROM requests WHERE id = ?");
$receiver_id_query->execute([$request_id]);
$receiver_id_result = $receiver_id_query->fetch(PDO::FETCH_ASSOC);
$receiver_id = $receiver_id_result['sender'] == $user_id ? $receiver_id_result['receiver'] : $receiver_id_result['sender'];

$select_messages = $conn->prepare("SELECT * FROM `chats` WHERE request_id = ? ORDER BY timestamp ASC");
$select_messages->execute([$request_id]);

$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);

$update_messages = $conn->prepare("UPDATE `chats` SET status = 'read' WHERE request_id = ? AND receiver = ?");
$update_messages->execute([$request_id, $user_id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<section class="chat">
    <h1 class="heading">Chat</h1>
    <div id="chat-box" data-request-id="<?= htmlspecialchars($request_id) ?>">
        <?php foreach ($messages as $message) { ?>
            <div class="chat-message <?= $message['sender'] == $user_id ? 'self' : 'other' ?>">
                <p><?= htmlspecialchars($message['message']) ?></p>
                <span class="timestamp"><?= htmlspecialchars($message['timestamp']) ?></span>
            </div>
        <?php } ?>
    </div>
    <form id="chat-form" action="../components/send_message.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id) ?>">
        <input type="hidden" name="sender" value="<?= htmlspecialchars($user_id) ?>">
        <input type="hidden" name="receiver" value="<?= htmlspecialchars($receiver_id) ?>">
        <textarea id="message" name="message" required></textarea>
        <div class="file-input-container">
            <label for="file" class="file-upload">
                <i class="fas fa-paperclip"></i> Choose File
            </label>
            <input type="file" id="file" name="file">
            <span id="file-name"></span>
        </div>
        <button type="submit" class="btn">Send</button>
    </form>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include '../components/footer.php'; ?>
<script src="../js/script.js"></script>
<script src="../js/chat.js"></script>
</body>
</html>

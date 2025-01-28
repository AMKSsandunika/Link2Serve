<?php
include '../components/connect.php';

if (!isset($_COOKIE['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_COOKIE['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/chat.css">
</head>
<body>

<section class="messages">
    <h1 class="heading">Your Messages</h1>
    <div class="box-container">
        <?php
        $select_requests = $conn->prepare("SELECT r.*, 
                                              (SELECT COUNT(*) FROM `chats` c WHERE c.request_id = r.id AND c.receiver = ? AND c.status = 'unread') AS unread_count 
                                           FROM `requests` r 
                                           WHERE r.sender = ? OR r.receiver = ? 
                                           ORDER BY (SELECT MAX(c.timestamp) FROM `chats` c WHERE c.request_id = r.id) DESC");
        $select_requests->execute([$user_id, $user_id, $user_id]);

        if ($select_requests->rowCount() > 0) {
            while ($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)) {
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_user->execute([$fetch_request['sender'] == $user_id ? $fetch_request['receiver'] : $fetch_request['sender']]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                $listing_name = '';
                $view_url = '';

                if (!empty($fetch_request['property_id'])) {
                    $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
                    $select_property->execute([$fetch_request['property_id']]);
                    $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);

                    if ($fetch_property) {
                        $listing_name = $fetch_property['property_name'];
                        $view_url = "view_property.php?get_id=" . $fetch_property['id'];
                    }
                } elseif (!empty($fetch_request['job_id'])) {
                    $select_job = $conn->prepare("SELECT * FROM `job` WHERE id = ?");
                    $select_job->execute([$fetch_request['job_id']]);
                    $fetch_job = $select_job->fetch(PDO::FETCH_ASSOC);

                    if ($fetch_job) {
                        $listing_name = $fetch_job['title'];
                        $view_url = "view_job.php?get_id=" . $fetch_job['id'];
                    }
                }elseif (!empty($fetch_request['courier_id'])) {
                    $select_courier = $conn->prepare("SELECT * FROM `courier` WHERE id = ?");
                    $select_courier->execute([$fetch_request['courier_id']]);
                    $fetch_courier= $select_courier->fetch(PDO::FETCH_ASSOC);

                    if ($fetch_courier) {
                        $listing_name = $fetch_courier['courier_name'];
                        $view_url = "view_courier.php?get_id=" . $fetch_courier['id'];
                    }
                }elseif (!empty($fetch_request['bike_id'])) {
                    $select_bike = $conn->prepare("SELECT * FROM `bike` WHERE id = ?");
                    $select_bike->execute([$fetch_request['bike_id']]);
                    $fetch_bike = $select_bike->fetch(PDO::FETCH_ASSOC);

                    if ($fetch_bike) {
                        $listing_name = $fetch_bike['bike_model'];
                        $view_url = "view_bike.php?get_id=" . $fetch_bike['id'];
                    }
                }

                elseif (!empty($fetch_request['course_id'])) {
                    $select_course = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
                    $select_course->execute([$fetch_request['course_id']]);
                    $fetch_course = $select_course->fetch(PDO::FETCH_ASSOC);

                    if ($fetch_course) {
                        $listing_name = $fetch_course['course_name'];
                        $view_url = "view_course.php?get_id=" . $fetch_course['id'];
                    }
                }

                if ($listing_name && $view_url) {
        ?>
        <div class="box <?= $fetch_request['unread_count'] > 0 ? 'unread' : '' ?>">
            <p>From: <span><?= htmlspecialchars($fetch_user['name']); ?></span></p>
            <p>Listing: <span><?= htmlspecialchars($listing_name); ?></span></p>
            <p>Unread messages: <span><?= htmlspecialchars($fetch_request['unread_count']); ?></span></p>
            <a href="chat.php?request_id=<?= $fetch_request['id']; ?>" class="btn">View Messages</a>
        </div>
        <?php
                }
            }
        } else {
            echo '<p class="empty">You have no messages!</p>';
        }
        ?>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>

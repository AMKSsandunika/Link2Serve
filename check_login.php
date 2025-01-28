<?php
include 'components/connect.php';

// Check if user is logged in
if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
    echo 'loggedIn';
} else {
    echo 'notLoggedIn';
}
?>

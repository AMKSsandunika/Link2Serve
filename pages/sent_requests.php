<?php  
include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){
   $delete_id = $_POST['request_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `requests` WHERE id = ? AND sender = ?");
   $verify_delete->execute([$delete_id, $user_id]);

   if($verify_delete->rowCount() > 0){
      $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ? AND sender = ?");
      $delete_request->execute([$delete_id, $user_id]);
      $success_msg[] = 'Request deleted successfully!';
   }else{
      $warning_msg[] = 'Request deleted already or you are not authorized!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sent Requests</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="requests">

   <h1 class="heading">Sent Requests</h1>

   <div class="box-container">

   <?php
      $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
      $select_requests->execute([$user_id]);
      if($select_requests->rowCount() > 0){
         while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

            $select_receiver = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_receiver->execute([$fetch_request['receiver']]);
            $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);

            if($fetch_receiver) {
                if(isset($fetch_request['property_id']) && !empty($fetch_request['property_id'])) {
                    $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
                    $select_property->execute([$fetch_request['property_id']]);
                    $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);

                    if($fetch_property) {
                        $listing_name = $fetch_property['property_name'];
                        $view_url = "../view_property.php?get_id=" . $fetch_property['id'];
                    } else {
                        $listing_name = 'Property not found';
                        $view_url = '#';
                    }
                } elseif(isset($fetch_request['job_id']) && !empty($fetch_request['job_id'])) {
                    $select_job = $conn->prepare("SELECT * FROM `job` WHERE id = ?");
                    $select_job->execute([$fetch_request['job_id']]);
                    $fetch_job = $select_job->fetch(PDO::FETCH_ASSOC);

                    if($fetch_job) {
                        $listing_name = $fetch_job['title'];
                        $view_url = "view_job.php?get_id=" . $fetch_job['id'];
                    } else {
                        $listing_name = 'Job not found';
                        $view_url = '#';
                    }
                }elseif(isset($fetch_request['course_id']) && !empty($fetch_request['course_id'])) {
                  $select_course = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
                  $select_course->execute([$fetch_request['course_id']]);
                  $fetch_course = $select_course->fetch(PDO::FETCH_ASSOC);

                  if($fetch_course) {
                      $listing_name = $fetch_course['course_name'];
                      $view_url = "view_course.php?get_id=" . $fetch_course['id'];
                  } else {
                      $listing_name = 'Course not found';
                      $view_url = '#';
                  }
              }elseif(isset($fetch_request['courier_id']) && !empty($fetch_request['courier_id'])) {
               $select_courier = $conn->prepare("SELECT * FROM `courier` WHERE id = ?");
               $select_courier->execute([$fetch_request['courier_id']]);
               $fetch_courier = $select_courier->fetch(PDO::FETCH_ASSOC);

               if($fetch_courier) {
                   $listing_name = $fetch_courier['courier_name'];
                   $view_url = "view_courier.php?get_id=" . $fetch_courier['id'];
               } else {
                   $listing_name = 'Courier not found';
                   $view_url = '#';
               }
           }
            elseif(isset($fetch_request['bike_id']) && !empty($fetch_request['bike_id'])) {
               $select_bike = $conn->prepare("SELECT * FROM `bike` WHERE id = ?");
               $select_bike->execute([$fetch_request['bike_id']]);
               $fetch_bike = $select_bike->fetch(PDO::FETCH_ASSOC);

               if($fetch_bike) {
                  $listing_name = $fetch_bike['bike_model'];
                  $view_url = "view_bike.php?get_id=" . $fetch_bike['id'];
               } else {
                  $listing_name = 'Bike not found';
                  $view_url = '#';
               }
         }
                
   ?>
   <div class="box">
      <p>Recipient Name : <span><?= htmlspecialchars($fetch_receiver['name']); ?></span></p>
      <p>Recipient Number : <a href="tel:<?= htmlspecialchars($fetch_receiver['number']); ?>"><?= htmlspecialchars($fetch_receiver['number']); ?></a></p>
      <p>Recipient Email : <a href="mailto:<?= htmlspecialchars($fetch_receiver['email']); ?>"><?= htmlspecialchars($fetch_receiver['email']); ?></a></p>
      <p>Request for : <span><?= htmlspecialchars($listing_name); ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="request_id" value="<?= htmlspecialchars($fetch_request['id']); ?>">
         <input type="submit" value="Delete Request" class="btn" onclick="return confirm('Remove this request?');" name="delete">
         <a href="<?= htmlspecialchars($view_url); ?>" class="btn">View Listing</a>
         <a href="chat.php?request_id=<?= $fetch_request['id']; ?>" class="btn">Chat</a>
      </form>
   </div>
   <?php
            }
        }
    } else {
        echo '<p class="empty">You have not sent any requests!</p>';
    }
   ?>

   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>

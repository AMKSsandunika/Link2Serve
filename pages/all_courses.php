<?php  
include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include '../components/save_send.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Course Listings</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<?php include '../pages/all_sidebar.php'; ?>

<!-- Listings Section Starts -->
<section class="listings">

   <h1 class="heading">All Course Listings  <button id="useMap"><a href="/Link2Serve/pages/course_map.php"><b>Go to Map  </b><i class="fa-solid fa-location-dot"></i></a></button></h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_courses = $conn->prepare("SELECT * FROM `course` ORDER BY date DESC");
         $select_courses->execute();
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){

                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_user->execute([$fetch_course['user_id']]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                if(!empty($fetch_course['image_02'])){
                    $image_coutn_02 = 1;
                 }

               $total_images = (1 + $image_coutn_02 );
               
               $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE course_id = ? and user_id = ?");
               $select_saved->execute([$fetch_course['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="course_id" value="<?= $fetch_course['id']; ?>">
            <?php
         // Check if the course listing belongs to the current user
               if($fetch_course['user_id'] != $user_id){
            // Check if the course is already saved by the current user
                  if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php
               }
            }
            ?>
            <!-- Assuming courses do not have images, adjust as necessary -->
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
               <img src="../uploaded_files/<?= $fetch_course['image_01']; ?>" alt="">
               
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_course['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price">Fee: LKR <span><?= $fetch_course['fees']; ?></span></div>
            <h3 class="name"><?= $fetch_course['course_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_course['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_course['university']; ?></span></p>
            
            <div class="flex">
               <p><i class="fas fa-hourglass-half"></i><span>Duration: <?= $fetch_course['duration']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_course.php?get_id=<?= $fetch_course['id']; ?>" class="btn">View Course</a>
               
               <?php if($fetch_course['user_id'] != $user_id) { ?>
               <input type="submit" value="send request" name="send" class="btn">
               <?php } ?>
            </div>
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No courses added yet! <a href="course.php" style="margin-top:1.5rem;" class="btn">Add New Course</a></p>';
      }
      ?>
      
   </div>

</section>
<!-- Listings Section Ends -->

<!-- SweetAlert Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Footer -->
<?php include '../components/footer.php'; ?>

<!-- Custom JavaScript -->
<script src="../js/script.js"></script>

<!-- Message Component -->
<?php include '../components/message.php'; ?>

</body>
</html>

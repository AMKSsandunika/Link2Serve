<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `job` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `job` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         
         $image_01 = $fetch_images['image_01'];
         unlink('../uploaded_files/'.$image_01);
         
      }
      $delete_job = $conn->prepare("DELETE FROM `job` WHERE id = ?");
      $delete_job->execute([$delete_id]);
      $success_msg[] = 'Job deleted!';
   }else{
      $warning_msg[] = 'Job not found or already deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Job Details</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- Header Section -->
<?php include '../components/admin_header.php'; ?>

<section class="view-property">

   <h1 class="heading">Job Details</h1>

   <?php
      $select_job = $conn->prepare("SELECT * FROM `job` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_job->execute([$get_id]);
      if($select_job->rowCount() > 0){
         while($fetch_job = $select_job->fetch(PDO::FETCH_ASSOC)){

         $job_id = $fetch_job['id'];

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$fetch_job['user_id']]);
         $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
   
         // Function to format address into Google Maps URL
         function format_address_for_maps($address) {
            $address = str_replace(" ", "+", $address);
            return "https://www.google.com/maps/search/?api=1&query=" . $address;
         }
   
         $google_maps_url = format_address_for_maps($fetch_job['address']);
      
   ?>
   <div class="details">
        <div class="swiper images-container2">
         <div class="swiper-wrapper">
            <img src="../uploaded_files/<?= $fetch_job['image_01']; ?>" alt="" class="swiper-slide">
            
         </div>
         <div class="swiper-pagination"></div>
        </div>
      <!-- Job Title -->
      <h3 class="name"><?= $fetch_job['title']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><a href="<?= $google_maps_url ?>" target="_blank"><?= $fetch_job['address']; ?></a></span></p>

      <!-- Job Description -->
      
      <!-- Other Job Details -->
      <div class="info">
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-university"></i><span><?= $fetch_job['university']; ?></span></p>
         <p><i class="far fa-clock"></i><span><?= $fetch_job['time']; ?></span></p>
         <p><i class="fas fa-users"></i><span>Vacancies: <?= $fetch_job['vacancy']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_job['date']; ?></span></p>
      </div>

      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Premises:</i><span><?= $fetch_job['premises']; ?></span></p>
            <p><i>Distance:</i><span><?= $fetch_job['distance']; ?> km</span></p>
            <p class="description"><i>Qualifications:</i><?= $fetch_job['qualification']; ?></p>
            <p><i>Skills:</i><span><?= $fetch_job['skill']; ?></span></p>
            <p><i>Contact :</i><span><?= $fetch_job['contact']; ?></span></p>
            <p><i>Age:</i><span><?= $fetch_job['age']; ?></span></p>
            <p><i>Salary:</i><span><?= $fetch_job['salary']; ?></span></p>
            
         </div>
         
      </div>

      <div class="flex">
         <div class="box">
            <p><i class="fas fa-<?php if($fetch_job['internship'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Internship</span></p>
            
         </div>
      </div>
      <!-- Delete Form -->
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="delete_id" value="<?= $job_id; ?>">
         <input type="submit" value="Delete Job" name="delete" class="delete-btn" onclick="return confirm('Delete this job listing?');">
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">Job not found! <a href="listings.php" class="option-btn">Go to listings</a></p>';
      }
   ?>

</section>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/message.php'; ?>

</body>
</html>

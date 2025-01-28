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

   $verify_delete = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         
         $image_01 = $fetch_images['image_01'];
         unlink('../uploaded_files/'.$image_01);
         if(!empty($image_02)){
            unlink('../uploaded_files/'.$image_02);
         }
         
      }
      $delete_job = $conn->prepare("DELETE FROM `course` WHERE id = ?");
      $delete_job->execute([$delete_id]);
      $success_msg[] = 'Course deleted!';
   }else{
      $warning_msg[] = 'Course not found or already deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Course Details</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />


   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- Header Section -->
<?php include '../components/admin_header.php'; ?>

<section class="view-property">

   <h1 class="heading">Course Details</h1>

   <?php
      $select_course = $conn->prepare("SELECT * FROM `course` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_course->execute([$get_id]);
      if($select_course->rowCount() > 0){
         while($fetch_course = $select_course->fetch(PDO::FETCH_ASSOC)){

            $course_id = $fetch_course['id'];

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_course['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    
            // Function to format address into Google Maps URL
            function format_address_for_maps($address) {
                $address = str_replace(" ", "+", $address);
                return "https://www.google.com/maps/search/?api=1&query=" . $address;
         }
   
         $google_maps_url = format_address_for_maps($fetch_course['address']);
      
   ?>
   <div class="details">
        <div class="swiper images-container">
         <div class="swiper-wrapper">
            <img src="../uploaded_files/<?= $fetch_course['image_01']; ?>" alt="" class="swiper-slide">
            <?php if(!empty($fetch_course['image_02'])){ ?>
            <img src="../uploaded_files/<?= $fetch_course['image_02']; ?>" alt="" class="swiper-slide">
            <?php } ?>
         </div>
         <div class="swiper-pagination"></div>
        </div>

      <!-- Course Title -->
      <h3 class="name"><?= $fetch_course['course_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><a href="<?= $google_maps_url ?>" target="_blank"><?= $fetch_course['address']; ?></a></span></p>

      <!-- course Description -->
      
      <!-- Other course Details -->
      <div class="info">
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-university"></i><span><?= $fetch_course['university']; ?></span></p>
         <p><i class="far fa-clock"></i><span><?= $fetch_course['duration']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_course['date']; ?></span></p>
      </div>

      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Institute:</i><span><?= $fetch_course['institute']; ?></span></p>
            <p><i>Premises:</i><span><?= $fetch_course['premises']; ?></span></p>
            <p><i>Distance:</i><span><?= $fetch_course['distance']; ?> km</span></p>
            <p><i>Pre-requisites:</i><span><?= $fetch_course['prerequisites']; ?></span></p>
            <p><i>Contact :</i><span><?= $fetch_course['contact_information']; ?></span></p>
            <p><i>Scheduling:</i><span><?= $fetch_course['scheduling']; ?></span></p>
            <p><i>Description:</i><span><?= $fetch_course['description']; ?></span></p>
            
         </div>
         
      </div>

      <div class="flex">
         <div class="box">
            <p><i class="fas fa-<?php if($fetch_course['certificate'] == 'yes'){echo 'check';}else{echo 'times';} ?>"></i><span>Provide a certificate</span></p>
            
         </div>
      </div>
      <!-- Delete Form -->
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="delete_id" value="<?= $course_id; ?>">
         <input type="submit" value="Delete Course" name="delete" class="delete-btn" onclick="return confirm('Delete this course listing?');">
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">Course not found! <a href="listings.php" class="option-btn">Go to listings</a></p>';
      }
   ?>

</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>
<script>

var swiper = new Swiper(".images-container", {
   effect: "coverflow",
   grabCursor: true,
   centeredSlides: true,
   slidesPerView: "auto",
   loop:true,
   coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 200,
      modifier: 3,
      slideShadows: true,
   },
   pagination: {
      el: ".swiper-pagination",
   },
});

</script>
</body>
</html>

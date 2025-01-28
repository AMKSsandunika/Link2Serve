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

   $verify_delete = $conn->prepare("SELECT * FROM `courier` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `courier` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         
         $image_01 = $fetch_images['image_01'];
         unlink('../uploaded_files/'.$image_01);
         
      }
      $delete_job = $conn->prepare("DELETE FROM `courier` WHERE id = ?");
      $delete_job->execute([$delete_id]);
      $success_msg[] = 'Courier deleted!';
   }else{
      $warning_msg[] = 'Courier not found or already deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Service Details</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- Header Section -->
<?php include '../components/admin_header.php'; ?>

<section class="view-property">

   <h1 class="heading">Courier Details</h1>

   <?php
      $select_courier = $conn->prepare("SELECT * FROM `courier` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_courier->execute([$get_id]);
      if($select_courier->rowCount() > 0){
         while($fetch_courier = $select_courier->fetch(PDO::FETCH_ASSOC)){

         $courier_id = $fetch_courier['id'];

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$fetch_courier['user_id']]);
         $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
   
         // Function to format address into Google Maps URL
         function format_address_for_maps($address) {
            $address = str_replace(" ", "+", $address);
            return "https://www.google.com/maps/search/?api=1&query=" . $address;
         }
   
         $google_maps_url = format_address_for_maps($fetch_courier['courier_address']);
      
   ?>
   <div class="details">
        <div class="swiper images-container2">
         <div class="swiper-wrapper">
            <img src="../uploaded_files/<?= $fetch_courier['image_01']; ?>" alt="" class="swiper-slide">
            
         </div>
         <div class="swiper-pagination"></div>
        </div>
      <!-- courier Title -->
      <h3 class="name"><?= $fetch_courier['courier_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><a href="<?= $google_maps_url ?>" target="_blank"><?= $fetch_courier['courier_address']; ?></a></span></p>

      <!-- courier Description -->
      
      <!-- Other courier Details -->
      <div class="info">
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-university"></i><span><?= $fetch_courier['university']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_courier['date']; ?></span></p>
      </div>

      <h3 class="title">Details</h3>
      <div class="flex">
         <div class="box">
            <p><i>Courier service:</i><span><?= $fetch_courier['courier_name']; ?></span></p>
            <p><i>University:</i><span><?= $fetch_courier['university']; ?></span></p>
            <p><i>Closest Premises:</i><span><?= $fetch_courier['premises']; ?></span></p>
            
         </div>
         
      
      <div class="box">
            <p><i>Tel. No:</i><span><?= $fetch_courier['phone_number']; ?></span></p>
            <p><i>Contact:</i><a href="mailto:<?= $fetch_courier['email_address']; ?>"><?= $fetch_courier['email_address']; ?></a></p>
      </div><br>
      <div class="box">
            <p><i>Description:</i><span><?= $fetch_courier['description']; ?></span></p>
         </div>
     </div>

         <div class="flex">
         
         <div class="box">
            <h2>Transport by:</h2><br>
            <p><i>Bike:</i><span><?= $fetch_courier['bike'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
            <p><i>Bus:</i><span><?= $fetch_courier['bus'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
            <p><i>Car:</i><span><?= $fetch_courier['car'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
            <p><i>Three Wheel:</i><span><?= $fetch_courier['three_weel'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
         </div>
         <div class="box">
            <h2>Work time:</h2><br>
            <p><i>Day:</i><span><?= $fetch_courier['day'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
            <p><i>Night:</i><span><?= $fetch_courier['night'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
            <p><i>Anytime:</i><span><?= $fetch_courier['anytime'] == 'yes' ? 'Available' : 'Not Available'; ?></span></p>
         </div>
      </div>
      </div>
      <!-- Delete Form -->
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="delete_id" value="<?= $courier_id; ?>">
         <input type="submit" value="Delete Courier" name="delete" class="delete-btn" onclick="return confirm('Delete this courier listing?');">
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">Couriers not found! <a href="listings.php" class="option-btn">Go to listings</a></p>';
      }
   ?>

</section>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>
<?php include '../components/message.php'; ?>

</body>
</html>

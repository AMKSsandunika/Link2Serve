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
   <title>All Bike Listings</title>

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

   <h1 class="heading">All Bike Listings  <button id="useMap"><a href="/Link2Serve/pages/bikes_map.php"><b>Go to Map  </b><i class="fa-solid fa-location-dot"></i></a></button></h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_bikes = $conn->prepare("SELECT * FROM `bike` ORDER BY date DESC");
         $select_bikes->execute();
         if($select_bikes->rowCount() > 0){
            while($fetch_bike = $select_bikes->fetch(PDO::FETCH_ASSOC)){

                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_user->execute([$fetch_bike['user_id']]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);


               $total_images = (1);
               
               $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE bike_id = ? and user_id = ?");
               $select_saved->execute([$fetch_bike['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="bike_id" value="<?= $fetch_bike['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php
               }
            ?>
            
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
               <img src="../uploaded_files/<?= $fetch_bike['image_01']; ?>" alt="">
               
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_bike['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price">Price: <span><?= $fetch_bike['price']; ?></span></div>
            <h3 class="name"><?= $fetch_bike['bike_model']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_bike['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_bike['university']; ?></span></p>
            
            <div class="flex">
               <p><i class="fas fa-hourglass-half"></i><span>Type: <?= $fetch_bike['type']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_bike.php?get_id=<?= $fetch_bike['id']; ?>" class="btn">View Bike</a>
               
               <?php if($fetch_bike['user_id'] != $user_id) { ?>
               <input type="submit" value="send request" name="send" class="btn">
               <?php } ?>
            </div>
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No bikes added yet! <a href="bike.php" style="margin-top:1.5rem;" class="btn">Add New bikes</a></p>';
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

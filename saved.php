<?php  
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

include 'components/save_send.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Saved Items</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="listings">

   <h1 class="heading">Saved listings</h1>

   <div class="box-container">
      <?php
         // Fetch saved properties
         $total_images = 0;
         $select_saved_property = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
         $select_saved_property->execute([$user_id]);
         if($select_saved_property->rowCount() > 0){
         while($fetch_saved = $select_saved_property->fetch(PDO::FETCH_ASSOC)){
            $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date DESC");
            $select_properties->execute([$fetch_saved['property_id']]);
            if($select_properties->rowCount() > 0){
               while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){

                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$fetch_property['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  if(!empty($fetch_property['image_02'])){
                     $image_coutn_02 = 1;
                  }else{
                     $image_coutn_02 = 0;
                  }
                  if(!empty($fetch_property['image_03'])){
                     $image_coutn_03 = 1;
                  }else{
                     $image_coutn_03 = 0;
                  }
                  if(!empty($fetch_property['image_04'])){
                     $image_coutn_04 = 1;
                  }else{
                     $image_coutn_04 = 0;
                  }
                  if(!empty($fetch_property['image_05'])){
                     $image_coutn_05 = 1;
                  }else{
                     $image_coutn_05 = 0;
                  }

                  $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
                  $select_saved->execute([$fetch_property['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remove from saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>   <!-- /*name changed*/ -->
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price">LKR<span><?= $fetch_property['price']; ?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_property['university']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">View property</a>
               <input type="submit" value="send request" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
                  }
               }
            }
         }

      // Fetch saved jobs
      $select_saved_job = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
      $select_saved_job->execute([$user_id]);
      if($select_saved_job->rowCount() > 0){
         while($fetch_saved = $select_saved_job->fetch(PDO::FETCH_ASSOC)){
            $select_jobs = $conn->prepare("SELECT * FROM `job` WHERE id = ? ORDER BY date DESC");
            $select_jobs->execute([$fetch_saved['job_id']]);
            if($select_jobs->rowCount() > 0){
               while($fetch_job = $select_jobs->fetch(PDO::FETCH_ASSOC)){
                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$fetch_job['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE job_id = ? and user_id = ?");
                  $select_saved->execute([$fetch_job['id'], $user_id]);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="job_id" value="<?= $fetch_job['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remove from saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <img src="uploaded_files/<?= $fetch_job['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_job['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price">LKR<span><?= $fetch_job['salary']; ?></span></div>
            <h3 class="name"><?= $fetch_job['title']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_job['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_job['university']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-briefcase"></i><span><?= $fetch_job['time']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_job.php?get_id=<?= $fetch_job['id']; ?>" class="btn">View job</a>
               <input type="submit" value="send request" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
                  }
               }
            }
         }
      // Fetch saved bikes
      $select_saved_bike = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
      $select_saved_bike->execute([$user_id]);
      if($select_saved_bike->rowCount() > 0){
         while($fetch_saved = $select_saved_bike->fetch(PDO::FETCH_ASSOC)){
            $select_bikes = $conn->prepare("SELECT * FROM `bike` WHERE id = ? ORDER BY date DESC");
            $select_bikes->execute([$fetch_saved['bike_id']]);
            if($select_bikes->rowCount() > 0){
               while($fetch_bike = $select_bikes->fetch(PDO::FETCH_ASSOC)){
                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$fetch_bike['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE bike_id = ? and user_id = ?");
                  $select_saved->execute([$fetch_bike['id'], $user_id]);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="bike_id" value="<?= $fetch_bike['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remove from saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <img src="uploaded_files/<?= $fetch_bike['image_01']; ?>" alt="">
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
            <div class="price">LKR<span><?= $fetch_bike['price']; ?></span></div>
            <h3 class="name"><?= $fetch_bike['bike_model']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_bike['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_bike['university']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-briefcase"></i><span><?= $fetch_bike['year']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_bike.php?get_id=<?= $fetch_bike['id']; ?>" class="btn">View bike</a>
               <input type="submit" value="send request" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
                  }
               }
            }
         }

      
      //Fetch saved couriers
      $select_saved_courier = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
      $select_saved_courier->execute([$user_id]);
      if($select_saved_courier->rowCount() > 0){
         while($fetch_saved = $select_saved_courier->fetch(PDO::FETCH_ASSOC)){
            $select_couriers = $conn->prepare("SELECT * FROM `courier` WHERE id = ? ORDER BY date DESC");
            $select_couriers->execute([$fetch_saved['courier_id']]);
            if($select_couriers->rowCount() > 0){
               while($fetch_courier = $select_couriers->fetch(PDO::FETCH_ASSOC)){
                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$fetch_courier['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE courier_id = ? and user_id = ?");
                  $select_saved->execute([$fetch_courier['id'], $user_id]);
      ?>
   <form action="" method="POST">
      <div class="box">
         <input type="hidden" name="courier_id" value="<?= $fetch_courier['id']; ?>">
         <?php
            if($select_saved->rowCount() > 0){
         ?>
         <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remove from saved</span></button>
         <?php
            }else{ 
         ?>
         <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
         <?php
            }
         ?>
         <div class="thumb">
            <img src="uploaded_files/<?= $fetch_courier['image_01']; ?>" alt="">
         </div>
         <div class="admin">
            <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
            <div>
               <p><?= $fetch_user['name']; ?></p>
               <span><?= $fetch_courier['date']; ?></span>
            </div>
         </div>
      </div>
      <div class="box">
         <div class="price">Tel:<span><?= $fetch_courier['phone_number']; ?></span></div>
         <h3 class="name"><?= $fetch_courier['courier_name']; ?></h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_courier['courier_address']; ?></span></p>
         <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_courier['university']; ?></span></p>
         <div class="flex">
            <p><i class="fas fa-briefcase"></i><span><?= $fetch_courier['premises']; ?></span></p>
         </div>
         <div class="flex-btn">
            <a href="view_courier.php?get_id=<?= $fetch_courier['id']; ?>" class="btn">View courier</a>
            <input type="submit" value="send request" name="send" class="btn">
         </div>
      </div>
   </form>
   <?php
               }
            }
         }
      }
    // Fetch saved courses
    $select_saved_course = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
    $select_saved_course->execute([$user_id]);
    if($select_saved_course->rowCount() > 0){
       while($fetch_saved = $select_saved_course->fetch(PDO::FETCH_ASSOC)){
          $select_courses = $conn->prepare("SELECT * FROM `course` WHERE id = ? ORDER BY date DESC");
          $select_courses->execute([$fetch_saved['course_id']]);
          if($select_courses->rowCount() > 0){
             while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_user->execute([$fetch_course['user_id']]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE course_id = ? and user_id = ?");
                $select_saved->execute([$fetch_course['id'], $user_id]);
    ?>
    <form action="" method="POST">
       <div class="box">
          <input type="hidden" name="course_id" value="<?= $fetch_course['id']; ?>">
          <?php
             if($select_saved->rowCount() > 0){
          ?>
          <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remove from saved</span></button>
          <?php
             }else{ 
          ?>
          <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
          <?php
             }
          ?>
          <div class="thumb">
             <img src="uploaded_files/<?= $fetch_course['image_01']; ?>" alt="">
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
          
          <p class="location"></i><span><?= $fetch_course['course_name']; ?></span></p>
          <p class="location"></i><span><?= $fetch_course['duration']; ?></span></p>

          <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_course['address']; ?></span></p>
          <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_course['university']; ?></span></p>
          
          <div class="flex-btn">
             <a href="view_course.php?get_id=<?= $fetch_course['id']; ?>" class="btn">View course</a>
             <input type="submit" value="send request" name="send" class="btn">
          </div>
       </div>
    </form>
    <?php
                }
             }
          }
       }
    ?>





   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'components/footer.php'; ?>
<!-- custom js file link  -->
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>
</body>
</html>

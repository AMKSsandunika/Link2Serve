<?php  
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- search filter section starts  -->
<section class="filters" style="padding-bottom: 0;">
   <form action="" method="post">
      <div id="close-filter"><i class="fas fa-times"></i></div>
      <h3>Filter your search</h3>
      <div class="flex">
         <div class="box">
            <p>Related university</p>
            <select name="university" class="input">
               <option value="">Select University</option>
               <option value="Wayamba University">Wayamba University</option>
               <option value="Universty of Sabaragamuwa">Universty of Sabaragamuwa</option>
               <option value="University of Ruhuna">University of Ruhuna</option>
               <option value="University of Colombo">University of Colombo</option>
               <option value="Eastern University">Eastern University</option>
               <option value="University of Jaffna">University of Jaffna</option>
               <option value="University of Kelaniya">University of Kelaniya</option>
               <option value="University of Moratuwa">University of Moratuwa</option>
               <option value="University of Peradeniya">University of Peradeniya</option>
               <option value="Rajarata University">Rajarata University</option>
               <option value="South Eastern University">South Eastern University</option>
               <option value="University of Sri Jayewardenepura">University of Sri Jayewardenepura</option>
               <option value="Uva Wellassa University">Uva Wellassa University</option>
               <option value="University of the Visual and Performing Arts">University of the Visual and Performing Arts</option>
               <option value="Gampaha Wickramarachchi University">Gampaha Wickramarachchi University</option>
               <option value="University of Vavuniya">University of Vavuniya</option>
               <option value="Open University">Open University</option>
            </select>
         </div>
      </div>
      <input type="submit" value="Search" name="filter_search" class="btn">
   </form>
</section>
<!-- search filter section ends -->

<div id="filter-btn" class="fas fa-filter"></div>

<?php
if(isset($_POST['filter_search'])){
   $university = filter_var($_POST['university'], FILTER_SANITIZE_STRING);
   
   // Prepare property query
   $property_query = "SELECT * FROM `property` WHERE 1";
   if($university != ''){
       $property_query .= " AND university LIKE '%$university%'";
   }
   $property_query .= " ORDER BY date DESC";

   // Prepare job query
   $job_query = "SELECT * FROM `job` WHERE 1";
   if($university != ''){
       $job_query .= " AND university LIKE '%$university%'";
   }
   $job_query .= " ORDER BY date DESC";
   
   // Prepare bike query
   $bike_query = "SELECT * FROM `bike` WHERE 1";
   if($university != ''){
       $bike_query .= " AND university LIKE '%$university%'";
   }
   $bike_query .= " ORDER BY date DESC";

   // Prepare courier query
   $courier_query = "SELECT * FROM `courier` WHERE 1";
   if($university != ''){
       $courier_query .= " AND university LIKE '%$university%'";
   }
   $courier_query .= " ORDER BY date DESC";

   // Prepare course query
   $course_query = "SELECT * FROM `course` WHERE 1";
   if($university != ''){
       $course_query .= " AND university LIKE '%$university%'";
   }
   $course_query .= " ORDER BY date DESC";

   // Execute queries
   $select_properties = $conn->prepare($property_query);
   $select_properties->execute();

   $select_jobs = $conn->prepare($job_query);
   $select_jobs->execute();
   
   $select_bikes = $conn->prepare($bike_query);
   $select_bikes->execute();

   $select_couriers = $conn->prepare($courier_query);
   $select_couriers->execute();

   $select_courses = $conn->prepare($course_query);
   $select_courses->execute();

   
} else {
   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
   $select_properties->execute();

   $select_jobs = $conn->prepare("SELECT * FROM `job` ORDER BY date DESC LIMIT 6");
   $select_jobs->execute();
   
   $select_bikes = $conn->prepare("SELECT * FROM `bike` ORDER BY date DESC LIMIT 6");
   $select_bikes->execute();

   $select_couriers = $conn->prepare("SELECT * FROM `courier` ORDER BY date DESC LIMIT 6");
   $select_couriers->execute();

   $select_courses = $conn->prepare("SELECT * FROM `course` ORDER BY date DESC LIMIT 6");
   $select_courses->execute();
}
?>

<!-- listings section starts  -->
<section class="listings">
   <?php 
      if(isset($_POST['filter_search'])){
         echo '<h1 class="heading">Search results</h1>';
      }else{
         echo '<h1 class="heading">Latest listings</h1>';
      }
   ?>

   <div class="box-container">
      <!-- Properties Listings -->
      <h2>Boarding Places</h2>
      <?php
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_property['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

               $total_images = 1;
               $total_images += !empty($fetch_property['image_02']) ? 1 : 0;
               $total_images += !empty($fetch_property['image_03']) ? 1 : 0;
               $total_images += !empty($fetch_property['image_04']) ? 1 : 0;
               $total_images += !empty($fetch_property['image_05']) ? 1 : 0;

               $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
               $select_saved->execute([$fetch_property['id'], $user_id]);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php } else { ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
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
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <?php if($fetch_property['user_id'] != $user_id) { ?>
                  <input type="submit" value="send requests" name="send" class="btn">
               <?php } ?>
            </div>

         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No property results found!</p>';
      }
      ?>

      <!-- Jobs Listings -->
      <h2>Jobs</h2>
      <?php
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
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php } else { ?>
            <button type="submit" name="save_job" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
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
               <a href="pages/view_job.php?get_id=<?= $fetch_job['id']; ?>" class="btn">View job</a>
               <?php if($fetch_job['user_id'] != $user_id) { ?>
                  <input type="submit" value="Send Request" name="send" class="btn">
               <?php } ?>
            </div>

         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No job results found!</p>';
      }
      ?>
      
      <!-- Bikes Listings -->
      <h2>Bikes</h2>
      <?php
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
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php } else { ?>
            <button type="submit" name="save_bike" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
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
               <p><i class="fas fa-bicycle"></i><span><?= $fetch_bike['type']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_bike.php?get_id=<?= $fetch_bike['id']; ?>" class="btn">View bike</a>
               <?php if($fetch_bike['user_id'] != $user_id) { ?>
                  <input type="submit" value="send request" name="send" class="btn">
               <?php } ?>
            </div>

         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No bike results found!</p>';
      }
      ?>
      <!-- Couriers Listings -->
      <h2>Couriers</h2>
      <?php
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
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php } else { ?>
            <button type="submit" name="save_courier" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
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
               <p><i class="fas fa-briefcase"></i><span><?= $fetch_courier['distance']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="pages/view_courier.php?get_id=<?= $fetch_courier['id']; ?>" class="btn">View courier</a>
               <?php if($fetch_courier['user_id'] != $user_id) { ?>
                  <input type="submit" value="Send Request" name="send" class="btn">
               <?php } ?>
            </div>

         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No service results found!</p>';
      }
      ?>

      <!-- courses Listings -->
      <h2>Courses</h2>
      <?php
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
            <?php if($select_saved->rowCount() > 0){ ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php } else { ?>
            <button type="submit" name="save_course" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
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
            <div class="fees">LKR<span><?= $fetch_course['fees']; ?></span></div>
            <h3 class="name"><?= $fetch_course['course_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_course['address']; ?></span></p>
            <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_course['university']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-briefcase"></i><span><?= $fetch_course['duration']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="pages/view_course.php?get_id=<?= $fetch_course['id']; ?>" class="btn">View course</a>
               <?php if($fetch_course['user_id'] != $user_id) { ?>
                  <input type="submit" value="Send Request" name="send" class="btn">
               <?php } ?>
            </div>

         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No course results found!</p>';
      }
      ?>
      
   </div>
</section>
<!-- listings section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'components/footer.php'; ?>
<!-- custom js file link  -->
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

<script>
document.querySelector('#filter-btn').onclick = () => {
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () => {
   document.querySelector('.filters').classList.remove('active');
}
</script>

</body>
</html>

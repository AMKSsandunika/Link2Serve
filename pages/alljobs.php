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
   <title>All Job Listings</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<?php include 'all_sidebar.php'; ?>

<!-- listings section starts  -->

<section class="listings">

   <h1 class="heading">All Job listings  <button id="useMap"><a href="/Link2Serve/pages/job_map.php"><b>Go to Map  </b><i class="fa-solid fa-location-dot"></i></a></button></h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_properties = $conn->prepare("SELECT * FROM `job` ORDER BY date DESC");
         $select_properties->execute();
         if($select_properties->rowCount() > 0){
            while($fetch_job = $select_properties->fetch(PDO::FETCH_ASSOC)){
                

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_job['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            $total_images = 1;

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE job_id = ? and user_id = ?");
            $select_saved->execute([$fetch_job['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="job_id" value="<?= $fetch_job['id']; ?>">
            <?php
         // Check if the job listing belongs to the current user
               if($fetch_job['user_id'] != $user_id){
            // Check if the job is already saved by the current user
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
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
               <img src="../uploaded_files/<?= $fetch_job['image_01']; ?>" alt="">
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
               <p><i class="fas fa-house"></i><span><?= $fetch_job['time']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_job.php?get_id=<?= $fetch_job['id']; ?>" class="btn">View job</a>
               <?php if($fetch_job['user_id'] != $user_id) { ?>
               <input type="submit" value="send request" name="send" class="btn">
               <?php } ?>
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">No properties added yet! <a href="job.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
      }
      ?>
      
   </div>

</section>

<!-- listings section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>

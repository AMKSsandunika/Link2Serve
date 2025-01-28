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
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<!-- home section starts  -->

<div class="home">

   <section class="center">

      <form action="search.php" method="post">
         <h3>Find your perfect service</h3>
         <div class="box">
            <p>Enter location <span>*</span></p>
            <input type="text" name="h_address" required maxlength="100" placeholder="enter city name" class="input">
         </div>
         <div class="flex">  
         </div>
         <input type="submit" value="search property" name="h_search" class="btn">
      </form>

   </section>

</div>

<!-- home section ends -->


<!-- listings section starts  -->

<section class="listings">

   <h1 class="heading">Latest listings</h1>

   <div class="box-container">
      <?php
         // Fetch latest properties
         $select_properties = $conn->prepare("SELECT *, 'property' AS type FROM `property` ORDER BY date DESC LIMIT 6");
         $select_properties->execute();
         $properties = $select_properties->fetchAll(PDO::FETCH_ASSOC);

         // Fetch latest jobs
         $select_jobs = $conn->prepare("SELECT *, 'job' AS type FROM `job` ORDER BY date DESC LIMIT 6");
         $select_jobs->execute();
         $jobs = $select_jobs->fetchAll(PDO::FETCH_ASSOC);

         // Combine and sort by date
         $listings = array_merge($properties, $jobs);
         usort($listings, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
         });

         if(count($listings) > 0){
            foreach($listings as $listing){
               if($listing['type'] == 'property'){
                  // Fetch user details
                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$listing['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  // Count total images
                  $total_images = 1;
                  for ($i = 2; $i <= 5; $i++) {
                     if (!empty($listing['image_0'.$i])) {
                        $total_images++;
                     }
                  }

                  // Check if property is saved
                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
                  $select_saved->execute([$listing['id'], $user_id]);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $listing['id']; ?>">
            <?php if($select_saved->rowCount() > 0){ ?>
               <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php }else{ ?>
               <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p>
               <img src="uploaded_files/<?= $listing['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $listing['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price">LKR<span><?= $listing['price']; ?></span></div>
            <h3 class="name"><?= $listing['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $listing['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $listing['type']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $listing['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
               } elseif ($listing['type'] == 'job') {
                  // Fetch user details
                  $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_user->execute([$listing['user_id']]);
                  $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                  // Check if job is saved
                  $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE job_id = ? and user_id = ?");
                  $select_saved->execute([$listing['id'], $user_id]);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="job_id" value="<?= $listing['id']; ?>">
            <?php if($select_saved->rowCount() > 0){ ?>
               <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Saved</span></button>
            <?php }else{ ?>
               <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Save</span></button>
            <?php } ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span>1</span></p>
               <img src="uploaded_files/<?= $listing['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $listing['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-briefcase"></i>LKR<span><?= $listing['salary']; ?></span></div>
            <h3 class="name"><?= $listing['title']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $listing['location']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-building"></i><span><?= $listing['time']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_job.php?get_id=<?= $listing['id']; ?>" class="btn">view job</a>
               <input type="submit" value="send application" name="apply" class="btn">
            </div>
         </div>
      </form>
      <?php
               }
            }
         } else {
            echo '<p class="empty">No listings added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
         }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="listings.php" class="inline-btn">view all</a>
   </div>

</section>

<!-- listings section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>
   let range = document.querySelector("#range");
   range.oninput = () => {
      document.querySelector('#output').innerHTML = range.value;
   }
</script>

</body>
</html>

<?php  

include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['course_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `course` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $image_01 = $fetch_images['image_01'];
        
         unlink('../uploaded_files/'.$image_01);
        
      }
    //   $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE job_id = ?");
    //   $delete_saved->execute([$delete_id]);
    //   $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE job_id = ?");
    //   $delete_requests->execute([$delete_id]);
      $delete_listing = $conn->prepare("DELETE FROM `course` WHERE id = ?");
      $delete_listing->execute([$delete_id]);
      $success_msg[] = 'listing deleted successfully!';
   }else{
      $warning_msg[] = 'listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My listings for courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<?php include '../components/sidebar.php'; ?>

<section class="my-listings">

   <h1 class="heading">My listings for Courses</h1>

   <div class="box-container">

   <?php
      $total_images = 0;
      $select_properties = $conn->prepare("SELECT * FROM `course` WHERE user_id = ? ORDER BY date DESC");
      $select_properties->execute([$user_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_courses = $select_properties->fetch(PDO::FETCH_ASSOC)){

         $course_id = $fetch_courses['id'];
        $total_images = (1);

   ?>
   <form accept="" method="POST" class="box">
      <input type="hidden" name="course_id" value="<?= $course_id; ?>">
      <div class="thumb">
         <p><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
         <img src="../uploaded_files/<?= $fetch_courses['image_01']; ?>" alt="">
      </div>
      <div class="price">Duration <span><?= $fetch_courses['duration']; ?></span></div>
      <h3 class="name"><?= $fetch_courses['course_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_courses['address']; ?></span></p>
      <p class="location"><i class="fa-regular fa-building"></i><span><?= $fetch_courses['university']; ?></span></p>
      <div class="flex-btn">
         <a href="course_update.php?get_id=<?= $course_id; ?>" class="btn">Update</a>
         <input type="submit" name="delete" value="delete" class="btn" onclick="return confirm('Delete this listing?');">
      </div>
      <a href="view_course.php?get_id=<?= $course_id; ?>" class="btn">View Course</a>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">No Courses added yet! <a href="course.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
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
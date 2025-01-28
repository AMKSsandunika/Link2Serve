<?php  

include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}

if(isset($_POST['update'])){

   $update_id = $_POST['course_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $institute = $_POST['institute'];
   $institute = filter_var($institute, FILTER_SANITIZE_STRING);
   $university = $_POST['university'];
   $university = filter_var($university, FILTER_SANITIZE_STRING);
   $premises = $_POST['premises'];
   $premises = filter_var($premises, FILTER_SANITIZE_STRING);
   $course_name = $_POST['course_name'];
   $course_name = filter_var($course_name, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $distance = $_POST['distance'];
   $distance = filter_var($distance, FILTER_SANITIZE_STRING);
   $duration = $_POST['duration'];
   $duration = filter_var($duration, FILTER_SANITIZE_STRING);
   $fees = $_POST['fees'];
   $fees = filter_var($fees, FILTER_SANITIZE_STRING);
   $prerequisites = $_POST['prerequisites'];
   $prerequisites = filter_var($prerequisites, FILTER_SANITIZE_STRING);
   $scheduling = $_POST['scheduling'];
   $scheduling = filter_var($scheduling, FILTER_SANITIZE_STRING);
   $contact_information = $_POST['contact_information'];
   $contact_information = filter_var($contact_information, FILTER_SANITIZE_STRING);
   
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);
 
   if(isset($_POST['certificate'])){
      $certificate = $_POST['certificate'];
      $certificate = filter_var($certificate, FILTER_SANITIZE_STRING);
   }else{
      $certificate = 'no';
   }
   

   $old_image_01 = $_POST['old_image_01'];
   $old_image_01 = filter_var($old_image_01, FILTER_SANITIZE_STRING);
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = '../uploaded_files/'.$rename_image_01;

   if(!empty($image_01)){
      if($image_01_size > 2000000){
         $warning_msg[] = 'image 01 size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `course` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$rename_image_01, $update_id]);
         move_uploaded_file($image_01_tmp_name, $image_01_folder);
         if($old_image_01 != ''){
            unlink('../uploaded_files/'.$old_image_01);
         }
      }
   }
   $old_image_02 = $_POST['old_image_02'];
   $old_image_02 = filter_var($old_image_02, FILTER_SANITIZE_STRING);
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = '../uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 size is too large!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `course` SET image_02 = ? WHERE id = ?");
         $update_image_02->execute([$rename_image_02, $update_id]);
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
         if($old_image_02 != ''){
            unlink('../uploaded_files/'.$old_image_02);
         }
      }
   }

   $update_listing = $conn->prepare("UPDATE `course` SET institute=? ,course_name=?, description=?, university=?, premises=?, address=?, duration=?, fees=?, prerequisites=?, scheduling=?, contact_information=?,certificate=?, image_01=?,image_02=?, date=? WHERE id = ?");   
   $update_listing->execute([$institute, $course_name, $description, $university, $premises, $address,  $duration, $fees, $prerequisites, $scheduling, $contact_information, $certificate, $rename_image_01, $rename_image_02, $date,  $update_id]);
 
   $success_msg[] = 'Listing updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Course</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <?php
      $select_course = $conn->prepare("SELECT * FROM `course` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_course->execute([$get_id]);
      if($select_course->rowCount() > 0){
         while($fetch_course = $select_course->fetch(PDO::FETCH_ASSOC)){
         $course_id = $fetch_course['id'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="course_id" value="<?= $course_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_course['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_course['image_02']; ?>">
      
      <h3>Course opportunity details</h3>
      <div class="box">
         <p>Course title<span>*</span></p>
         <input type="text" name="course_name" required maxlength="50" placeholder="Enter course name" value="<?= $fetch_course['course_name']; ?>" class="input">
      </div>
      <div class="flex">
         <div class="box">
         <p>Institute name <span>*</span></p>
         <input type="text" name="institute" required maxlength="50" placeholder="Enter Institute name" value="<?= $fetch_course['institute']; ?>" class="input">
         </div>
         
         <div class="box">
            <p>Related university<span>*</span></p>
            <select name="university" required class="input">
            <option value="<?= $fetch_course['university']; ?>" selected><?= $fetch_course['university']; ?></option>
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
               <option value="niversity of the Visual and Performing Arts">University of the Visual and Performing Arts</option>
               <option value="Gampaha Wickramarachchi University">Gampaha Wickramarachchi University</option>
               <option value="University of Vavuniya">University of Vavuniya</option>
               <option value="Open University">Open University</option>
            </select>
         </div>
         
         
         <div class="box">
            <p>Closest Premises <span>*</span></p>
            <input type="text" name="premises" maxlength="100" placeholder="University premises" class="input" value="<?= $fetch_course['premises']; ?>">
         </div>
         <div class="box">
            <p>Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter the address" class="input" value="<?= $fetch_course['address']; ?>">
         </div>
         

         <div class="box">
            <p>Distance from the university<span>*</span></p>
            <input type="text" name="distance" required maxlength="100" placeholder="Km" class="input" value="<?= $fetch_course['distance']; ?>">
         </div>

         
         <div class="box">
         <p>Duration <span>*</span></p>
         <input type="text" name="duration" required maxlength="50" placeholder="months"  class="input" value="<?= $fetch_course['duration']; ?>">
         </div>

         <div class="box">
         <p>Contact information <span>*</span></p>
         <input type="text" name="contact_information" required maxlength="50" placeholder="Enter contact informations" value="<?= $fetch_course['contact_information']; ?>" class="input">
         </div>

         <div class="box">
         <p>Pre-requisites <span>*</span></p>
         <input type="text" name="prerequisites" required maxlength="50" placeholder="Enter prerequisites" value="<?= $fetch_course['prerequisites']; ?>" class="input">
         </div>

         <div class="box">
         <p>Fees<span>*</span></p>
         <input type="text" name="fees" required maxlength="50" placeholder="Enter course fees (Rs.)" value="<?= $fetch_course['fees']; ?>" class="input">
         </div>

         <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
         </div>

         <div class="box">
            <p>Description <span>*</span></p>
            <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Write about course..." value="<?= $fetch_course['description']; ?>"></textarea>
         </div>
         <br>

         

         
      </div>
      
      <div class="checkbox">
         <div class="box">
            <p><input type="checkbox" name="certificate" value="yes" <?php if($fetch_course['certificate'] == 'yes'){echo 'checked'; } ?> />Certificate</p>
         </div>
      </div>

      <div class="box">
            <p>Scheduling <span>*</span></p>
            <select name="scheduling" required class="input">
               <option value="<?= $fetch_course['scheduling']; ?>" selected><?= $fetch_course['scheduling']; ?></option>
               <option value="weekdays">weekdays</option>
               <option value="weekends">weekends</option>
               <option value="online">online</option>
            </select>
         </div>
         <div class="box">
         <img src="../uploaded_files/<?= $fetch_course['image_01']; ?>" class="image" alt="">
         <p>update image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      <div class="flex"> 
         <div class="box">
            <?php if(!empty($fetch_course['image_02'])){ ?>
            <img src="../uploaded_files/<?= $fetch_course['image_02']; ?>" class="image" alt="">
            <input type="submit" value="delete image 02" name="delete_image_02" class="inline-btn" onclick="return confirm('delete image 02');">
            <?php } ?>
            <p>update image 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
      </div>
      
      <input type="submit" value="Update Course" class="btn" name="update">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Course not found! <a href="course.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
   }
   ?>

</section>






<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
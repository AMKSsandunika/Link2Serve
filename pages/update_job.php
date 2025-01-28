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

   $update_id = $_POST['job_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $qualification = $_POST['qualification'];
   $qualification = filter_var($qualification, FILTER_SANITIZE_STRING);
   $skill = $_POST['skill'];
   $skill = filter_var($skill, FILTER_SANITIZE_STRING);
   $university = $_POST['university'];
   $university = filter_var($university, FILTER_SANITIZE_STRING);
   $premises = $_POST['premises'];
   $premises = filter_var($premises, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
  
   $distance = $_POST['distance'];
   $distance = filter_var($distance, FILTER_SANITIZE_STRING);
   $vacancy = $_POST['vacancy'];
   $vacancy = filter_var($vacancy, FILTER_SANITIZE_STRING);
   $time = $_POST['time'];
   $time = filter_var($time, FILTER_SANITIZE_STRING);
   $age = $_POST['age'];
   $age = filter_var($age, FILTER_SANITIZE_STRING);
   $contact = $_POST['contact'];
   $contact = filter_var($contact, FILTER_SANITIZE_STRING);

   $salary = $_POST['salary'];
   $salary = filter_var($salary, FILTER_SANITIZE_STRING);
   
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);

 
    if(isset($_POST['internship'])){
      $internship = $_POST['internship'];
      $internship= filter_var($internship, FILTER_SANITIZE_STRING);
   }else{
      $internship = 'no';
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
         $update_image_01 = $conn->prepare("UPDATE `job` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$rename_image_01, $update_id]);
         move_uploaded_file($image_01_tmp_name, $image_01_folder);
         if($old_image_01 != ''){
            unlink('../uploaded_files/'.$old_image_01);
         }
      }
   }

   

   $update_listing = $conn->prepare("UPDATE `job` SET title=? ,qualification=?, skill=?, university=?, premises=?, address=?, distance=?, vacancy=?, time=?, age=?, contact=?, salary=?, internship=?, image_01=?, date=? WHERE id = ?");   
   $update_listing->execute([$title, $qualification, $skill, $university, $premises, $address,  $distance, $vacancy, $time, $age, $contact, $salary, $internship, $rename_image_01, $date,  $update_id]);

   $success_msg[] = 'Listing updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Job</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `job` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_job = $select_properties->fetch(PDO::FETCH_ASSOC)){
         $job_id = $fetch_job['id'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="job_id" value="<?= $job_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_job['image_01']; ?>">
      
      <h3>Job opportunity details</h3>
      <div class="box">
         <p>Job title<span>*</span></p>
         <input type="text" name="title" required maxlength="50" placeholder="Enter the job title" value="<?= $fetch_job['title']; ?>" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>Qualifications<span>*</span></p>
            <textarea name="qualification" maxlength="1000" class="input" required cols="30" rows="10" value="<?= $fetch_job['qualification']; ?>" placeholder="Required qualifications.." class="input"> </textarea>
         </div>
         <div class="box">
            <p>Skill<span>*</span></p>
            <textarea name="skill" maxlength="1000" class="input" required cols="30" rows="10" value="<?= $fetch_job['skill']; ?>" placeholder="Required skills.." class="input"> </textarea>
         </div>
         <div class="box">
            <p>Related university<span>*</span></p>
            <select name="university" required class="input">
            <option value="<?= $fetch_job['university']; ?>" selected><?= $fetch_job['university']; ?></option>
               <option value="Wayamba University">Wayamba University</option>
               <option value="Universty of Sabaragamuwa">Universty of Sabaragamuwa</option>
               <option value="University of Ruhuna">University of Ruhuna</option>
               <option value="University of Colombo">University of Colombo</option>
               <option value="Eastern University">Eastern University</option>
               <option value="University of Jaffna">University of Jaffna</option>
               <option value="University of Kelaniya">University of Kelaniya<</option>
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
            <input type="text" name="premises" maxlength="100" placeholder="University premises" class="input" value="<?= $fetch_job['premises']; ?>">
         </div>
         <div class="box">
            <p>Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter the address" class="input" value="<?= $fetch_job['address']; ?>">
         </div>
         

         <div class="box">
            <p>Distance from the university<span>*</span></p>
            <input type="number" name="distance" required maxlength="100" placeholder="Km" class="input" value="<?= $fetch_job['distance']; ?>">
         </div>

         
         <div class="box">
            <p>Number of vacancies <span>*</span></p>
            <input type="number" name="vacancy" required maxlength="100" placeholder="For how many students" class="input" value="<?= $fetch_job['vacancy']; ?>">
         </div>
         
         <div class="box">
            <p>Part time/ Full time <span>*</span></p>
            <select name="time" required class="input">
               <option value="<?= $fetch_job['time']; ?>" selected><?= $fetch_job['time']; ?></option>
               <option value="Part time">Part time</option>
               <option value="Full time">Full time</option>
               
            </select>
         </div>
        
         <div class="box">
            <p>Age<span>*</span></p>
            <select name="age" required class="input">
               <option value="<?= $fetch_job['age']; ?>" selected><?= $fetch_job['age']; ?></option>
              
               <option value="Above 20">Above 20</option>
               <option value="Below 30">Below 30</option>
               <option value="Below 40">Below 40</option>
            </select>
         </div>
         
        
         <div class="box">
            <p>Contact<span>*</span></p>
            <input type="text" name="contact" required min="0" max="99" maxlength="50" placeholder="Email" class="input" value="<?= $fetch_job['contact']; ?>">
         </div>
         <div class="box">
            <p>Salary<span>*</span></p>
            <input type="text" name="salary" required min="0" max="99" maxlength="20" placeholder="" class="input" value="<?= $fetch_job['salary']; ?>">
         </div>
         
         <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
            </div>
      </div>
      
      <div class="checkbox">
         <div class="box">
            
            <p><input type="checkbox" name="internship" value="yes" <?php if($fetch_job['internship'] == 'yes'){echo 'checked'; } ?> />Internship</p>
            
         </div>
         
      </div>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_job['image_01']; ?>" class="image" alt="">
         <p>update image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      
      <input type="submit" value="Update Job" class="btn" name="update">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Property not found! <a href="job.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
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
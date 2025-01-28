<?php  

include '../components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){

   $id = create_unique_id();
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
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
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
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   

   

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = '../uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 size too large!';
   }else{
      $insert_courses = $conn->prepare("INSERT INTO `course`(id, user_id,institute, university, premises, course_name, description, location, address, distance, duration, fees, prerequisites, scheduling, contact_information,date, image_01, image_02) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_courses->execute([$id, $user_id, $institute, $university, $premises, $course_name, $description, $location, $address, $distance, $duration, $fees, $prerequisites, $scheduling, $contact_information, $date, $rename_image_01, $rename_image_02]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'Course posted successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add your Courses here</h3>

      <div class="box">
         <p>Course name <span>*</span></p>
         <input type="text" name="course_name" required maxlength="50" placeholder="Enter course name" class="input">
      </div>

      <div class="box">
         <p>Institute name <span>*</span></p>
         <input type="text" name="institute" required maxlength="50" placeholder="Enter Institute name" class="input">
      </div>

      <div class="box">
            <p>Related university<span>*</span></p>
            <select name="university" required class="input">
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

         <div class="box">
            <p>Closest Premises <span>*</span></p>
            <input type="text" name="premises" maxlength="100" placeholder="University premises" class="input">
         </div>

      <div class="box">
         <p>Description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Write about course..."></textarea>
      </div>

      <div class="box">
         <p>Location <span>*</span></p>
         <input type="text" name="location" required maxlength="50" placeholder="Enter location" class="input">
      </div>

      <div class="box">
         <p>Address <span>*</span></p>
         <input type="text" name="address" required maxlength="50" placeholder="Enter address" class="input">
      </div>

      <div class="box">
         <p>Distance<span>*</span></p>
         <input type="number" name="distance" required maxlength="50" placeholder="Enter distance from university (Km)" class="input">
      </div>

      <div class="box">
         <p>Duration <span>*</span></p>
         <input type="text" name="duration" required maxlength="50" placeholder="months" class="input">
      </div>

      <div class="box">
         <p>Fees<span>*</span></p>
         <input type="text" name="fees" required maxlength="50" placeholder="Enter course fees (Rs.)" class="input">
      </div>

      <div class="box">
         <p>Pre-requisites <span>*</span></p>
         <input type="text" name="prerequisites" required maxlength="50" placeholder="Enter prerequisites" class="input">
      </div>

      <div class="box">
         <p>Date<span>*</span></p>
         <input type="date" name="date" required maxlength="50" class="input">
      </div>

      <div class="box">
            <p>Scheduling <span>*</span></p>
            <select name="scheduling" required class="input">
               <option value="weekdays">weekdays</option>
               <option value="weekends">weekends</option>
               <option value="online">online</option>
            </select>
         </div>

         <div class="box">
         <p>Contact information <span>*</span></p>
         <input type="text" name="contact_information" required maxlength="50" placeholder="Enter contact informations " class="input">
      </div>

      <div class="checkbox">
         <div class="box">
            <p><input type="checkbox" name="certificate" value="yes" />Provide a certificate</p> 
         </div>
      </div>

      
      <div class="box">
         <p>image 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>

      <div class="box">
         <p>image 02 </p>
         <input type="file" name="image_02" class="input" accept="image/*" required>
      </div>

      
      <input type="submit" value="post the course" class="btn" name="post">
   </form>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>

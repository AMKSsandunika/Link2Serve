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
      $insert_job = $conn->prepare("INSERT INTO `job`(id, user_id, title,qualification, skill, university, premises, address, distance, vacancy, time, age, contact, salary, internship, image_01, date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_job->execute([$id, $user_id, $title, $qualification, $skill, $university, $premises, $address,  $distance, $vacancy, $time, $age, $contact, $salary, $internship, $rename_image_01, $date]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'Job posted successfully!';
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include 'header.php';

?>

<section class="property-form">

<form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateDistance()">
      <h3>Job opportunity details</h3>
      <div class="box">
         <p>Job title <span>*</span></p>
         <input type="text" name="title" required maxlength="50" placeholder="Enter the title of the job" class="input">
      </div>
      <div class="flex">
         
         <div class="box">
         <p>Qualifications<span>*</span></p>
         <textarea name="qualification" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Required qualifications.."></textarea>
      </div>
      <div class="box">
         <p>Skills<span>*</span></p>
         <textarea name="skill" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Required skills.."></textarea>
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
            <p>Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter the full address" class="input">
         </div>
         
         

        
         <div class="box">
            <p>Distance from university <span>*</span></p>
            <input type="number" id="distance" name="distance" required maxlength="100" placeholder="Km" class="input">
         </div>
         
         <div class="box">
            <p>Number of vacancies <span>*</span></p>
            <input type="number" name="vacancy" required maxlength="100" placeholder=" " class="input">
         </div>
         <div class="box">
            <p>Part time/ Full time <span>*</span></p>
            <select name="time" required class="input">
               <option value="Part time">Part time</option>
               <option value="Full time">Full time</option>
            </select>
         </div>

         <div class="box">
            <p>Age<span>*</span></p>
            <select name="age" required class="input">
               <option value="Above 20">Above 20</option>
               <option value="Below 30">Below 30</option>
               <option value="Below 40">Below 40</option>
            </select>
         </div>
       
         
        
         <div class="box">
            <p>Contact<span>*</span></p>
            <input type="text" name="contact" required maxlength="50" placeholder="Email" class="input">
         </div>
         <div class="box">
            <p>Salary</p>
            <input type="text" name="salary" maxlength="20" placeholder=" " class="input">
         </div>
         
      </div>
      <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
      </div>

      <div class="checkbox">
         <div class="box">
            <!-- <p><input type="checkbox" name="lift" value="yes" />lifts</p> -->
            <p><input type="checkbox" name="internship" value="yes" />Internship</p> 
            <!-- <p><input type="checkbox" name="play_ground" value="yes" />play ground</p>  -->
            <!-- <p><input type="checkbox" name="garden" value="yes" />Garden</p>
            <p><input type="checkbox" name="water_supply" value="yes" />Water supply</p>
            <p><input type="checkbox" name="power_backup" value="yes" />Power backup</p> -->
         </div>
         <!-- <div class="box">
            <p><input type="checkbox" name="parking_area" value="yes" />parking area</p>
            <p><input type="checkbox" name="gym" value="yes" />gym</p>                                 
            <p><input type="checkbox" name="shopping_mall" value="yes" />shopping_mall</p>
            <p><input type="checkbox" name="hospital" value="yes" />hospital</p>
            <p><input type="checkbox" name="school" value="yes" />school</p>
            <p><input type="checkbox" name="market_area" value="yes" />market area</p>
         </div> -->
      </div>
      <div class="box">
         <p>Image 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>
      
      
      <input type="submit" value="post job" class="btn" name="post">
   </form>

</section>







<!----footer---->
<?php include '../components/footer.php'; ?>

<script>
function validateDistance() {
   var distance = document.getElementById('distance').value;
   
   if (distance > 3) {
      alert('Distance must be 3 km or less from the university.');
      return false; // Prevent form submission
   }

   return true; // Allow form submission
}
</script>

    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/script.js"></script>
<?php include '../components/message.php'; ?>
</body>
</html>
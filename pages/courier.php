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
   $courier_name = $_POST['courier_name'];
   $courier_name = filter_var($courier_name, FILTER_SANITIZE_STRING);
   $phone_number = $_POST['phone_number'];
   $phone_number = filter_var($phone_number, FILTER_SANITIZE_STRING);
   $email_address = $_POST['email_address'];
   $email_address = filter_var($email_address, FILTER_SANITIZE_STRING);
   $courier_address = $_POST['courier_address'];
   $courier_address = filter_var($courier_address, FILTER_SANITIZE_STRING);
   $university = $_POST['university'];
   $university = filter_var($university, FILTER_SANITIZE_STRING);
   $premises = $_POST['premises'];
   $premises = filter_var($premises, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $distance = $_POST['distance'];
   $distance = filter_var($distance, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);


   

   if(isset($_POST['bike'])){
      $bike = $_POST['bike'];
      $bike= filter_var($bike, FILTER_SANITIZE_STRING);
   }else{
      $bike = 'no';
   }

   if(isset($_POST['bus'])){
      $bus = $_POST['bus'];
      $bus = filter_var($bus, FILTER_SANITIZE_STRING);
   }else{
      $bus = 'no';
   }

   if(isset($_POST['car'])){
      $car = $_POST['car'];
      $car = filter_var($car, FILTER_SANITIZE_STRING);
   }else{
      $car = 'no';
   }

   if(isset($_POST['three_weel'])){
      $three_weel = $_POST['three_weel'];
      $three_weel = filter_var($three_weel, FILTER_SANITIZE_STRING);
   }else{
      $three_weel = 'no';
   }

   if(isset($_POST['day'])){
      $day = $_POST['day'];
      $day= filter_var($day, FILTER_SANITIZE_STRING);
   }else{
      $day = 'no';
   }

   if(isset($_POST['night'])){
      $night = $_POST['night'];
      $night = filter_var($night, FILTER_SANITIZE_STRING);
   }else{
      $night = 'no';
   }

   if(isset($_POST['anytime'])){
      $anytime = $_POST['anytime'];
      $anytime = filter_var($anytime, FILTER_SANITIZE_STRING);
   }else{
      $anytime = 'no';
   }

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = '../uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'Image size too large!';
   }else{
      $insert_courier = $conn->prepare("INSERT INTO `courier`(id, user_id, courier_name, phone_number, email_address, courier_address, university, premises, description, distance, location, bike, bus, car, three_weel, day, night, anytime, date, image_01) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_courier->execute([$id, $user_id, $courier_name, $phone_number, $email_address, $courier_address, $university, $premises, $description, $distance, $location, $bike, $bus, $car, $three_weel, $day, $night, $anytime, $date, $rename_image_01]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'Courier posted successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Post property</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
  
<?php include 'header.php'; ?>

<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Courier details</h3>
      <div class="box">
         <p>Courier name <span>*</span></p>
         <input type="text" name="courier_name" required maxlength="60" placeholder="Enter courier name" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>Phone number <span>*</span></p>
            <input type="text" name="phone_number" required min="0" max="9999999999" maxlength="10" placeholder="Enter phone number" class="input">
         </div>
         <div class="box">
            <p>Email address <span>*</span></p>
            <input type="text" name="email_address" required maxlength="50" placeholder="Enter email address" class="input">
         </div>
         <div class="box">
            <p>Courier address <span>*</span></p>
            <input type="text" name="courier_address" required maxlength="50" placeholder="Enter address" class="input">
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
            <p>Premises <span>*</span></p>
            <input type="text" name="premises" required maxlength="50" placeholder="Enter premises" class="input">
         </div>
         <div class="box">
            <p>Distance <span>*</span></p>
            <input type="number" name="distance" required maxlength="5" placeholder="Km" class="input">
         </div>
         <div class="box">
            <p>Location <span>*</span></p>
            <input type="text" name="location" required maxlength="100" placeholder="Enter location" class="input">
         </div>
      </div><br>

      <div class="box">
         <p>Courier description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Write about your courier service..."></textarea>
      </div>  
         
      <div class="checkbox">
         
         <div class="box">
            <p>Transport by <span>*</span></p>
            <p><input type="checkbox" name="bike" value="yes" />Bike</p>
            <p><input type="checkbox" name="bus" value="yes" />Bus</p>
            <p><input type="checkbox" name="car" value="yes" />Car</p>
            <p><input type="checkbox" name="three_weel" value="yes" />Three_wheel</p>
         </div>
         
         <div class="box">
            <p>Work time <span>*</span></p>
            <p><input type="checkbox" name="day" value="yes" />Day</p>
            <p><input type="checkbox" name="night" value="yes" />Night</p>
            <p><input type="checkbox" name="anytime" value="yes" />Anytime</p>
         </div>   
      </div>   
      <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
      </div>
      
      
      <div class="box">
         <p>Image 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>
      
      <input type="submit" value="post service" class="btn" name="post">
   </form>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
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

   $update_id = $_POST['courier_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
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
       $update_image_01 = $conn->prepare("UPDATE `courier` SET image_01 = ? WHERE id = ?");
       $update_image_01->execute([$rename_image_01, $update_id]);
       move_uploaded_file($image_01_tmp_name, $image_01_folder);
       if($old_image_01 != ''){
          unlink('../uploaded_files/'.$old_image_01);
       }
    }
 }

   

   $update_listing = $conn->prepare("UPDATE `courier` SET courier_name=? ,phone_number=?, email_address=?, courier_address=?, university=?, premises=?, description=?, date=?, distance=?, location=?, day=?, night=?, anytime=?, bike=?, bus=?, car=?, three_weel=?, image_01=? WHERE id = ?");   
   $update_listing->execute([$courier_name, $phone_number, $email_address, $courier_address, $university, $premises,$description, $date,  $distance, $location, $day, $night, $anytime, $bike, $bus, $car, $three_weel, $rename_image_01,  $update_id]);

   $success_msg[] = 'Listing updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Courier</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `courier` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_courier = $select_properties->fetch(PDO::FETCH_ASSOC)){
         $courier_id = $fetch_courier['id'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="courier_id" value="<?= $courier_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_courier['image_01']; ?>">
      
      <h3>courier details</h3>
      <div class="box">
         <p>Courier name<span>*</span></p>
         <input type="text" name="courier_name" required maxlength="50" placeholder="Enter the courier name" value="<?= $fetch_courier['courier_name']; ?>" class="input">
      </div>
      <div class="flex">
         <div class="box">
         <p>Phone number <span>*</span></p>
            <input type="text" name="phone_number" required min="0" max="9999999999" maxlength="10" placeholder="Enter phone number" value="<?= $fetch_courier['phone_number']; ?>" class="input">
         </div>
         <div class="box">
            <p>Email address <span>*</span></p>
            <input type="text" name="email_address" required maxlength="50" placeholder="Enter email address" value="<?= $fetch_courier['email_address']; ?>" class="input">
         </div>
         <div class="box">
            <p>Courier address <span>*</span></p>
            <input type="text" name="courier_address" required maxlength="50" placeholder="Enter address" value="<?= $fetch_courier['courier_address']; ?>" class="input">
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
            <input type="text" name="premises" required maxlength="50" placeholder="Enter premises" value="<?= $fetch_courier['premises']; ?>" class="input">
         </div>
         <div class="box">
            <p>Distance <span>*</span></p>
            <input type="number" name="distance" required maxlength="5" placeholder="Km" value="<?= $fetch_courier['distance']; ?>" class="input">
         </div>
         <div class="box">
            <p>Location <span>*</span></p>
            <input type="text" name="location" required maxlength="100" placeholder="Enter location" value="<?= $fetch_courier['location']; ?>" class="input">
         </div>
      </div><br>

      <div class="box">
         <p>Service description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="write about property..." ><?= $fetch_courier['description']; ?></textarea>
      </div>  
         
      <div class="checkbox">
         
         <div class="box">
            <p>Transport by <span>*</span></p>
            <p><input type="checkbox" name="bike" value="yes" <?php if($fetch_courier['bike']=='yes'){echo 'checked'; } ?> />Bike</p>
            <p><input type="checkbox" name="bus" value="yes" <?php if($fetch_courier['bus']=='yes'){echo 'checked'; } ?>/>Bus</p>
            <p><input type="checkbox" name="car" value="yes" <?php if($fetch_courier['car']=='yes'){echo 'checked'; } ?>/>Car</p>
            <p><input type="checkbox" name="three_weel" value="yes" <?php if($fetch_courier['three_weel']=='yes'){echo 'checked'; } ?> />Three_wheel</p>
         </div>
         
         <div class="box">
            <p>Work time <span>*</span></p>
            <p><input type="checkbox" name="day" value="yes" <?php if($fetch_courier['day']=='yes'){echo 'checked'; } ?> />Day</p>
            <p><input type="checkbox" name="night" value="yes" <?php if($fetch_courier['night']=='yes'){echo 'checked'; } ?> />Night</p>
            <p><input type="checkbox" name="anytime" value="yes" <?php if($fetch_courier['anytime']=='yes'){echo 'checked'; } ?>/>Anytime</p>
         </div>   
      </div>   
      <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
      </div>
      
      
      <div class="box">
         <img src="../uploaded_files/<?= $fetch_courier['image_01']; ?>" class="image" alt="">
         <p>update image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      <input type="submit" value="update courier" class="btn" name="update">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Service not found! <a href="courier.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
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
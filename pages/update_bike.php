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

   $update_id = $_POST['bike_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $bike_model = $_POST['bike_model'];
   $bike_model = filter_var($bike_model, FILTER_SANITIZE_STRING);
   $bike_number = $_POST['bike_number'];
   $bike_number = filter_var($bike_number, FILTER_SANITIZE_STRING);
   $year = $_POST['year'];
   $year = filter_var($year, FILTER_SANITIZE_STRING);
   
   $university = $_POST['university'];
   $university = filter_var($university, FILTER_SANITIZE_STRING);
   $premises = $_POST['premises'];
   $premises = filter_var($premises, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $distance = $_POST['distance'];
   $distance = filter_var($distance, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
    
   

 
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
         $update_image_01 = $conn->prepare("UPDATE `bike` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$rename_image_01, $update_id]);
         move_uploaded_file($image_01_tmp_name, $image_01_folder);
         if($old_image_01 != ''){
            unlink('../uploaded_files/'.$old_image_01);
         }
      }
   }

   

   $update_listing = $conn->prepare("UPDATE `bike` SET bike_model=? ,bike_number=?, year=?, university=?, premises=?, address=?, location=?, distance=?, email=?, price=?, date=?, type=?, image_01=?  WHERE id = ?");   
   $update_listing->execute([$bike_model, $bike_number, $year, $university, $premises, $address,  $location, $distance, $email, $price, $date, $type, $rename_image_01,  $update_id]);

   $success_msg[] = 'Listing updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Bike</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `bike` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_bike = $select_properties->fetch(PDO::FETCH_ASSOC)){
         $bike_id = $fetch_bike['id'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="bike_id" value="<?= $bike_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_bike['image_01']; ?>">
      
      <h3>Bike opportunity details</h3>
      <div class="box">
         <p>Bike model<span>*</span></p>
         <input type="text" name="bike_model" required maxlength="50" placeholder="Enter the bike model" value="<?= $fetch_bike['bike_model']; ?>" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>Bike number</p>
            <input type="text" name="bike_number" maxlength="20" class="input"  value="<?= $fetch_bike['bike_number']; ?>" placeholder="bike_number.." class="input"> 
         </div>
         <div class="box">
            <p>Year<span>*</span></p>
            <input type="text" name="year" maxlength="10" class="input" required value="<?= $fetch_bike['year']; ?>" placeholder="year.." class="input"> 
         </div>
         <div class="box">
            <p>University<span>*</span></p>
            <select name="university" required class="input">
            <option value="<?= $fetch_bike['university']; ?>" selected><?= $fetch_bike['university']; ?></option>
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
            <p>Premises <span>*</span></p>
            <input type="text" name="premises" maxlength="100" placeholder="premises" class="input" value="<?= $fetch_bike['premises']; ?>">
         </div>
         <div class="box">
            <p>Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter the address" class="input" value="<?= $fetch_bike['address']; ?>">
         </div>
         
         <div class="box">
            <p>Location <span>*</span></p>
            <input type="text" name="location" required maxlength="100" placeholder="location" class="input" value="<?= $fetch_bike['location']; ?>">
         </div>

         <div class="box">
            <p>Distance<span>*</span></p>
            <input type="number" name="distance" required maxlength="100" placeholder="Km" class="input" value="<?= $fetch_bike['distance']; ?>">
         </div>

         
         <div class="box">
            <p>Email <span>*</span></p>
            <input type="text" name="email" required maxlength="100" placeholder="email" class="input" value="<?= $fetch_bike['email']; ?>">
         </div>

         <div class="box">
            <p>Price <span>*</span></p>
            <input type="text" name="price" required maxlength="100" placeholder="price" class="input" value="<?= $fetch_bike['price']; ?>">
         </div>

         <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
            </div>
         
         <div class="box">
            <p>Type <span>*</span></p>
            <select name="type" required class="input">
               <option value="<?= $fetch_bike['type']; ?>" selected><?= $fetch_bike['type']; ?></option>
               <option value="used">Used</option>
               <option value="brand new">Brand new</option>
               
            </select>
         </div>
        
      </div>
      
      
      </div>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_bike['image_01']; ?>" class="image" alt="">
         <p>update image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      
      <input type="submit" value="Update bike" class="btn" name="update">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Bike not found! <a href="bike.php" style="margin-top:1.5rem;" class="btn">Add new</a></p>';
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
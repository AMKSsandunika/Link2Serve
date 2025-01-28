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


   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = '../uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'Image 01 size too large!';
   }else{
      $insert_bike = $conn->prepare("INSERT INTO `bike`(id, user_id, bike_model, bike_number, year, university, premises, address, location, distance, email, price, date, type, image_01) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_bike->execute([$id, $user_id, $bike_model, $bike_number, $year, $university, $premises, $address, $location, $distance, $email, $price, $date, $type, $rename_image_01]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'Bike posted successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bikes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Bike details</h3>
      <div class="box">
         <p>Bike model <span>*</span></p>
         <input type="text" name="bike_model" required maxlength="50" placeholder="Enter bike model" class="input">
      </div>
      
      <div class="box">
         <p>Bike number </p>
         <input type="text" name="bike_number" maxlength="50" placeholder="Enter bike number" class="input">
      </div>

      <div class="box">
         <p>Year <span>*</span></p>
         <input type="number" name="year" required maxlength="50" placeholder="Manufactured year" class="input">
      </div>

      <div class="box">
            <p>Related university<span>*</span></p>
            <select name="university" required class="input">
               <option value="Wayamba University">Wayamba University of Sri Lanka</option>
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
         <p>Closest premises <span>*</span></p>
         <input type="text" name="premises" required maxlength="50" placeholder="Enter closest premises" class="input">
      </div>

      <div class="box">
            <p>Address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Enter address" class="input">
      </div>

      <div class="box">
         <p>Location <span>*</span></p>
         <input type="text" name="location" required maxlength="50" placeholder="Enter location" class="input">
      </div>

      <div class="box">
         <p>Distance from university <span>*</span></p>
         <input type="text" name="distance" required maxlength="50" placeholder="Enter distance from university (Km)" class="input">
      </div>

      <div class="box">
         <p>Email <span>*</span></p>
         <input type="text" name="email" required maxlength="50" placeholder="Enter email" class="input">
      </div>

      <div class="box">
         <p>Price <span>*</span></p>
         <input type="text" name="price" required maxlength="50" placeholder="LKR" class="input">
      </div>

      <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required maxlength="50" placeholder="Enter date" class="input">
      </div>

      <div class="box">
            <p>Type <span>*</span></p>
            <select name="type" required class="input">
               <option value="used">Used</option>
               <option value="brand_new">Brand new</option>
            </select>
      </div>




         
      <div class="box">
         <p>Image 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>
      
      <input type="submit" value="Post the bike" class="btn" name="post">
   </form>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/footer.php'; ?>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
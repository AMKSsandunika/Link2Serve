<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){

   $id = create_unique_id();
   $property_name = $_POST['property_name'];
   $property_name = filter_var($property_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $university = $_POST['university'];
   $university = filter_var($university, FILTER_SANITIZE_STRING);
   $student = $_POST['student'];
   $student = filter_var($student, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $premises = $_POST['premises'];
   $premises = filter_var($premises, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);

   $distance = $_POST['distance'];
   $distance = filter_var($distance, FILTER_SANITIZE_STRING);
  
   $bed = $_POST['bed'];
   $bed = filter_var($bed, FILTER_SANITIZE_STRING);
   $bathroom = $_POST['bathroom'];
   $bathroom = filter_var($bathroom, FILTER_SANITIZE_STRING);
   $balcony = $_POST['balcony'];
   $balcony = filter_var($balcony, FILTER_SANITIZE_STRING);

   $total_floors = $_POST['total_floors'];
   $total_floors = filter_var($total_floors, FILTER_SANITIZE_STRING);
   $room = $_POST['room'];
   $room = filter_var($room, FILTER_SANITIZE_STRING);
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   if(isset($_POST['security_guard'])){
      $security_guard = $_POST['security_guard'];
      $security_guard = filter_var($security_guard, FILTER_SANITIZE_STRING);
   }else{
      $security_guard = 'no';
   }
   
   if(isset($_POST['garden'])){
      $garden = $_POST['garden'];
      $garden = filter_var($garden, FILTER_SANITIZE_STRING);
   }else{
      $garden = 'no';
   }
   if(isset($_POST['water_supply'])){
      $water_supply = $_POST['water_supply'];
      $water_supply = filter_var($water_supply, FILTER_SANITIZE_STRING);
   }else{
      $water_supply = 'no';
   }
   if(isset($_POST['power_backup'])){
      $power_backup = $_POST['power_backup'];
      $power_backup = filter_var($power_backup, FILTER_SANITIZE_STRING);
   }else{
      $power_backup = 'no';
   }


   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 size is too large!';
      }else{
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 03 size is too large!';
      }else{
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
      }
   }else{
      $rename_image_03 = '';
   }

   $image_04 = $_FILES['image_04']['name'];
   $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 04 size is too large!';
      }else{
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
      }
   }else{
      $rename_image_04 = '';
   }

   $image_05 = $_FILES['image_05']['name'];
   $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
   $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
   $rename_image_05 = create_unique_id().'.'.$image_05_ext;
   $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
   $image_05_size = $_FILES['image_05']['size'];
   $image_05_folder = 'uploaded_files/'.$rename_image_05;

   if(!empty($image_05)){
      if($image_05_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
      }
   }else{
      $rename_image_05 = '';
   }

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 size too large!';
   }else{
      $insert_property = $conn->prepare("INSERT INTO `property`(id, user_id, property_name, address, location,distance, price, university, premises, student, type, bed, bathroom, balcony, total_floors, room, security_guard, garden, water_supply, power_backup, image_01, image_02, image_03, image_04, image_05, description, date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_property->execute([$id, $user_id, $property_name, $address, $location, $distance, $price, $university, $premises, $student, $type, $bed, $bathroom, $balcony, $total_floors, $room, $security_guard, $garden, $water_supply, $power_backup, $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description, $date]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'property posted successfully!';
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
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Boarding place details</h3>
      <div class="box">
         <p>Owner's name <span>*</span></p>
         <input type="text" name="property_name" required maxlength="50" placeholder="Enter place owner's name" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>Boarding place price <span>*</span></p>
            <input type="number" name="price" required min="0" max="9999999999" maxlength="10" placeholder="Enter boarding price" class="input">
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
            <p>Boarding place address <span>*</span></p>
            <input type="text" id="address" name="address" required maxlength="100" placeholder="Enter boarding place full address" class="input">
            <button class="button0" onclick="getLocation()">Get Current Location</button>
         </div>

         <div class="box">
            <p>Boarding place location <span>*</span></p>
            <input type="text" name="location" required maxlength="100" placeholder="Attach the google map link" class="input">
         </div>
         <!-- <div class="box">
            <p>offer type <span>*</span></p>
            <select name="offer" required class="input">
               <option value="sale">sale</option>
               <option value="resale">resale</option>
               <option value="rent">rent</option>
            </select>
         </div> -->
         <div class="box">
            <p>Closest Premises <span>*</span></p>
            <input type="text" name="premises" maxlength="100" placeholder="University premises" class="input">
         </div>
         <div class="box">
            <p>Number of students <span>*</span></p>
            <input type="number" name="student" required maxlength="100" placeholder="For how many students" class="input">
         </div>

         <div class="box">
            <p>Distance <span>*</span></p>
            <input type="number" name="distance" required maxlength="100" placeholder="Km" class="input">
         </div></p>

         <div class="box">
            <p>Property type <span>*</span></p>
            <select name="type" required class="input">
               <option value="flat">flat</option>
               <option value="house">house</option>
               
            </select>
         </div>
       
       
         
         <div class="box">
            <p>How many beds <span>*</span></p>
            <select name="bed" required class="input">
               
               <option value="1" selected>1 bed</option>
               <option value="2">2 beds</option>
               <option value="3">3 beds</option>
               <option value="4">4 beds</option>
               <option value="5">5 beds</option>
               <option value="6">6 beds</option>
               <option value="7">7 beds</option>
               <option value="8">8 beds</option>
               <option value="9">9 beds</option>
            </select>
         </div>
         <div class="box">
            <p>How many bathrooms <span>*</span></p>
            <select name="bathroom" required class="input">
               <option value="1">1 bathroom</option>
               <option value="2">2 bathroom</option>
               <option value="3">3 bathroom</option>
               <option value="4">4 bathroom</option>
               <option value="5">5 bathroom</option>
               <option value="6">6 bathroom</option>
               <option value="7">7 bathroom</option>
               <option value="8">8 bathroom</option>
               <option value="9">9 bathroom</option>
            </select>
         </div>
         <div class="box">
            <p>How many balconys <span>*</span></p>
            <select name="balcony" required class="input">
               <option value="0">0 balcony</option>
               <option value="1">1 balcony</option>
               <option value="2">2 balcony</option>
               <option value="3">3 balcony</option>
               <option value="4">4 balcony</option>
               <option value="5">5 balcony</option>
               <option value="6">6 balcony</option>
               <option value="7">7 balcony</option>
               <option value="8">8 balcony</option>
               <option value="9">9 balcony</option>
            </select>
         </div>
     
         
         <div class="box">
            <p>Total floors <span>*</span></p>
            <input type="number" name="total_floors" required min="0" max="99" maxlength="2" placeholder="How floors available?" class="input">
         </div>
         <div class="box">
            <p>Rooms <span>*</span></p>
            <input type="number" name="room" required min="0" max="99" maxlength="2" placeholder="Number of rooms" class="input">
         </div>
         
      </div>
      <div class="box">
         <p>Date <span>*</span></p>
         <input type="date" name="date" required class="input">
      </div>
      <div class="box">
         <p>Place description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Write about property..."></textarea>
      </div>
      
      <div class="checkbox">
         <div class="box">
            <!-- <p><input type="checkbox" name="lift" value="yes" />lifts</p> -->
            <p><input type="checkbox" name="security_guard" value="yes" />Security guard</p> 
            <!-- <p><input type="checkbox" name="play_ground" value="yes" />play ground</p>  -->
            <p><input type="checkbox" name="garden" value="yes" />Garden</p>
            <p><input type="checkbox" name="water_supply" value="yes" />Water supply</p>
            <p><input type="checkbox" name="power_backup" value="yes" />Power backup</p>
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
      <div class="flex"> 
         <div class="box">
            <p>Image 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>Image 03</p>
            <input type="file" name="image_03" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>Image 04</p>
            <input type="file" name="image_04" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>Image 05</p>
            <input type="file" name="image_05" class="input" accept="image/*">
         </div>   
      </div>
      <input type="submit" value="post property" class="btn" name="post">
   </form>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&key=AIzaSyBEzqkWXa-fr9jizC5SMkhcJ-gPfhNHsoo`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'OK' && data.results.length > 0) {
                        const address = data.results[0].formatted_address;
                        document.getElementById('address').value = address;
                    } else {
                        alert("No address found. Please try again.");
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    alert("Error fetching address. Please try again.");
                });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>

<?php include 'components/message.php'; ?>

</body>
</html>
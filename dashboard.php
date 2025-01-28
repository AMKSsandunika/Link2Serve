<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
      <?php
         $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
         $select_profile->execute([$user_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3>Welcome!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update.php" class="btn">Update profile</a>
      </div>

      <div class="box">
         <h3>Filter search</h3>
         <p>Search your service</p>
         <a href="search.php" class="btn">Search now</a>
      </div>

      <div class="box">
  <?php
    // Assuming $conn is your PDO connection object and $user_id is set to the user's ID

    // Array of table names
    $tables = ['property', 'job', 'courier', 'course', 'bike'];

    // Initialize total listings count
    $total_listings = 0;

    // Loop through each table and get the count of listings
    foreach ($tables as $table) {
      $count_stmt = $conn->prepare("SELECT COUNT(*) FROM `$table` WHERE user_id = ?");
      $count_stmt->execute([$user_id]);
      $total_listings += $count_stmt->fetchColumn();
    }
  ?>
  <h3><?= $total_listings; ?></h3>
  <p>Services listed</p>
  <a href="my_listings.php" class="btn">View My listings</a>
</div>


      <div class="box">
      <?php
        $count_requests_received = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
        $count_requests_received->execute([$user_id]);
        $total_requests_received = $count_requests_received->rowCount();
      ?>
      <h3><?= $total_requests_received; ?></h3>
      <p>requests received</p>
      <a href="requests.php" class="btn">view all requests</a>
      </div>

      <div class="box">
      <?php
        $count_requests_sent = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
        $count_requests_sent->execute([$user_id]);
        $total_requests_sent = $count_requests_sent->rowCount();
      ?>
      <h3><?= $total_requests_sent; ?></h3>
      <p>requests sent</p>
      <a href="pages/sent_requests.php" class="btn">Requests sent</a> 
      </div>

      <div class="box">
      <?php
        $count_saved_properties = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
        $count_saved_properties->execute([$user_id]);
        $total_saved_properties = $count_saved_properties->rowCount();
      ?>
      <h3><?= $total_saved_properties; ?></h3>
      <p>Properties saved</p>
      <a href="saved.php" class="btn">View saved listings</a>
      </div>

   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
<?php

include '../components/connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities</title>
    <link rel="shortcut icon" href="../img/logo.png" sizes="64x64" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/community.css">

</head>
<body>
<!----header-------->
<?php include 'header.php';

?>

<h1>External Local Services</h1>
    
    <div class="explore__grid">
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="../post_property.php">Boarding places</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
       
        <div class="explore__card">
          <span><i class="ri-run-line"></i></span>
          <h4><b><a href="job.php">Job Opportunities</a></b></h4>
          <span><i class="ri-run-line"></i></span>
          <!-- <a href="#"><b>Go</b> <span class="material-symbols-outlined">double_arrow</span>
            <i class="ri-arrow-right-line"></i></a> -->
        </div>

        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="bike.php">Bike Sale</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
          <!-- <a href="#"><b>Go </b><span class="material-symbols-outlined">double_arrow</span>

                        <i class="ri-arrow-right-line"></i></a> -->
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="course.php">Courses</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <!-- <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="">Taxis</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div> -->
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="courier.php">Courier</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        
    </div><br>


<!----footer---->
<?php include '../components/footer.php'; ?>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/script.js"></script>
<?php include '../components/message.php'; ?>
</body>
</html>             
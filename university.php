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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University</title>

       <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

   
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/university.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
      // Check if user is logged in
      var userId = "<?php echo $user_id; ?>";
      if (!userId) {
         // User is not logged in, show popup
         alert("You need to login first!");
      }
   </script>
</head>
<body>
    <!----header-------->
<?php include 'components/user_header.php';

?>
    <h1>Universities in Sri Lanka</h1>
    
    <div class="explore__grid">
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Wayamba University">Wayamba University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
       
        <div class="explore__card">
          <span><i class="ri-run-line"></i></span>
          <h4><b><a href="student_search.php?university=Universty of Sabaragamuwa">Universty of Sabaragamuwa</a></b></h4>
          <span><i class="ri-run-line"></i></span>
          <!-- <a href="#"><b>Go</b> <span class="material-symbols-outlined">double_arrow</span>
            <i class="ri-arrow-right-line"></i></a> -->
        </div>

        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Ruhuna">University of Ruhuna</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
          <!-- <a href="#"><b>Go </b><span class="material-symbols-outlined">double_arrow</span>

                        <i class="ri-arrow-right-line"></i></a> -->
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Colombo">University of Colombo</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Eastern University">Eastern University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Jaffna">University of Jaffna</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Kelaniya">University of Kelaniya</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Moratuwa">University of Moratuwa</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Peradeniya">University of Peradeniya</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Rajarata University">Rajarata University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=South Eastern University">South Eastern University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Sri Jayewardenepura">University of Sri Jayewardenepura</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Uva Wellassa University">Uva Wellassa University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of the Visual and Performing Arts">University of the Visual and Performing Arts</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Gampaha Wickramarachchi University">Gampaha Wickramarachchi University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=University of Vavuniya">University of Vavuniya</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b><a href="student_search.php?university=Open University">Open University</a></b></h4>
          <span><i class="ri-boxing-fill"></i></span>
        </div>
        
      </div><br>




<!----footer---->
<?php include 'components/footer.php'; ?>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="import DoubleArrowIcon from '@mui/icons-material/DoubleArrow';"></script>
  
    


<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>
</body>
</html>
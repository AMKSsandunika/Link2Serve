<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 // Add the login check and message here:


?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" href="css/style2.css">

   <link rel="shortcut icon" href="img/logo.png" sizes="64x64" type="image/x-icon">

   <!-- custom js file link  -->
   <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/2.1.2/sweetalert.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>

   <script>
  $(document).ready(function() {
    $("#localCommunityLink").click(function(e) {
      e.preventDefault();  // Prevent default link behavior

      Swal.fire({
        title: 'Notice!',
        text: 'Please make sure to enter services around 3KM to the related university!',
        icon: 'info',
        confirmButtonColor: '#3085d6',  // Customize button color (optional)
        confirmButtonText: 'Continue'  // Change button text
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "pages/community.php";  // Redirect after confirmation
        }
      });
    });
  });
</script>
   

</head>
<body>
  <!----header-------->
<?php include 'components/user_header.php';

?>

   
<header class="section__container header__container">
      <div class="header__content">
        <span class="bg__blur"></span>
        <span class="bg__blur header__blur"></span>
        <h4>BEST CHOICE IN THE AREA</h4>
        <h1><span>DISCOVER</span> Connections </h1>
        <p>
        Effortless connection is just a click away. 
        Let's make it happen together. Unlock seamless connectivity with our services. 
        Your satisfaction is our priority.
        </p>
        <a href="#students" class="btnn"><button class="btn" onclick="return checkLoggedIn();">Get Started</button></a>
      </div>
      <div class="header__image">
        <img src="img/student1.png" alt="header" class="student" />
      </div>
    </header>

    <section class="section__container explore__container" id="students">
      <div class="explore__header">
        <h2 class="section__header">EXPLORE OUR PROGRAM</h2>
        <!-- <div class="explore__nav">
          <span><i class="ri-arrow-left-line"></i></span>
          <span><i class="ri-arrow-right-line"></i></span>
        </div> -->
      </div>
      <div class="explore__grid">
        <div class="explore__card" >
          <span><i class="ri-boxing-fill"></i></span>
          <h4><b>STUDENTS</b></h4>
          <span><i class="ri-boxing-fill"></i></span>
          <img src="img/student2.png" class="stu">
          <p>
          This convenient feature helps you to access essential amenities without hassle.
          </p>
          <a href="university.php"><b>Continue </b><span class="material-symbols-outlined">double_arrow</span>

                        <i class="ri-arrow-right-line"></i></a>
        </div>
       
        <div class="explore__card">
          <span><i class="ri-run-line"></i></span>
          <h4><b>LOCAL COMMUNITIES</b></h4>
          <span><i class="ri-run-line"></i></span>
          <img src="img/community.png" class="com">
          <p>
          This outreach opportunity enables you to engage with the student community
          </p>
          <a href="pages/community.php" id="localCommunityLink"><b>Continue</b> <span class="material-symbols-outlined">double_arrow</span>
            <i class="ri-arrow-right-line"></i></a>
        </div>
        
      </div>

      
  



    </section>

    <!------home------->
    


    
  
<!----footer---->
<?php include 'components/footer.php'; ?>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="import DoubleArrowIcon from '@mui/icons-material/DoubleArrow';"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>

<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>
<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">
      <div class="image">
         <img src="img/about-img.svg" alt="">
      </div>
      <div class="content">
         <h3>Why choose us?</h3>
         <p>BEST CHOICE IN THE AREA. DISCOVER Connections. Effortless connection is just a click away. Let's make it happen together. Unlock seamless connectivity with our services. Your satisfaction is our priority.</p>
         <a href="contact.php" class="inline-btn">Contact us</a>
      </div>
   </div>

</section>

<!-- about section ends -->
<!-----about--->
<section class="services">

   <h1 class="heading">Our services</h1>

   <div class="box-container">

      <div class="box">
      <img src="img/icon-2.png" alt="">
         <h3>Rent house</h3>
         <p>You can easily find and search for boarding places around your university through our website. 
            We offer a variety of accommodations</p>
      </div>

      <div class="box">
         
         <img src="img/bike3.png" alt="">
         <h3>Find bikes</h3>
         <p>Discover the best bike deals near campus with our student-friendly platform! Easily compare the prices for your budget.. </p>
      </div>

      <div class="box">
         <img src="img/taxi.png" alt="">
         <h3>Find Taxis</h3>
         <p>Secure your ride with peace of mind! Our platform helps students locate taxis with top-notch safety features. Find trusted drivers.</p>
      </div>

      <div class="box">
         <img src="img/course.png" alt="">
         <h3>Find Courses</h3>
         <p>Empower your academic journey with comprehensive course-finding tool! Easily explore a wide range of courses for academic needs.</p>
      </div>

      <div class="box">
         <img src="img/jobs.png" alt="">
         <h3>Find Jobs</h3>
         <p>Unlock your career potential with our job-search platform designed specifically for students! Discover a variety of part-time, internships, etc.</p>
      </div>

      <div class="box">
         <img src="img/icon-6.png" alt="">
         <h3>24/7 service</h3>
         <p>Access opportunities anytime, anywhere with our 24/7 service! Our platform is available round the clock for finding the perfect service.</p>
      </div>

   </div>

</section>

<!-- steps section starts  -->

<section class="steps">

   <h1 class="heading">3 simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>Search property</h3>
         <p>Start your search now and unlock a world of convenience at your fingertips! Explore any service you need with ease! <br>
            Let's discover more.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>Contact agents</h3>
         <p>Connect with our agents effortlessly! Reach out to us anytime for support or to learn more about our services tailored for students.</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>Enjoy the services</h3>
         <p>From convenient campus amenities to exciting events. Join us and enhance your university experience today. Don't miss out – check us out now!</p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<!-- review section starts  -->


<!-- review section ends -->










<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
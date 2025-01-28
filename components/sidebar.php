<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sidebar Navigation</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <!-- <link rel="stylesheet" href="../css/admin_style.css"> -->
</head>
<body>

<div class="side-bar">
   <nav class="navbar">
      <a href="/Link2Serve/my_listings.php" class="nav-link"><i class="fas fa-home"></i><span>Boardings</span></a>
      <a href="/Link2Serve/pages/joblisting.php" class="nav-link"><i class="fa fa-file-text" aria-hidden="true"></i><span>Jobs</span></a>
      <a href="/Link2Serve/pages/course_mylisting.php" class="nav-link"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
      <a href="/Link2Serve/pages/courier_mylisting.php" class="nav-link"><i class="fas fa-shipping-fast"></i><span>Courier Services</span></a>
      <a href="/Link2Serve/pages/bike_mylisting.php" class="nav-link"><i class="fa-solid fa-bicycle"></i><span>Bikes</span></a>
   </nav>
</div>

<script>
   document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function(event) {
         // Check if the link was already clicked
         if (this.classList.contains('clicked')) {
            event.preventDefault(); // Prevent default action if already clicked
         } else {
            this.classList.add('clicked'); // Mark link as clicked
            setTimeout(() => {
               this.classList.remove('clicked'); // Reset after 1 second
            }, 1000);
         }
      });
   });
</script>


</body>
</html>

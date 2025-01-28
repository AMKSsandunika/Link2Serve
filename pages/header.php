<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="/Link2Serve/Main.php" class="logo"><i class="fas fa-house"></i>Link<span class="t">2</span>Serve</a>

         <ul>
            <li><a href="/Link2Serve/pages/community.php">Post Service<i class="fas fa-paper-plane"></i></a></li>
            <a href="/Link2Serve/pages/messages.php" class="show-btn">
                        <i id="icon" class="fab fa-facebook-messenger"></i>
                        <span id="unread-count" class="badge"></span>
                    </a>  
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="#">My listings<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="/Link2Serve/dashboard.php">Dashboard</a></li>
                     <!-- <li><a href="../post_property.php">post property</a></li> -->
                     <li><a href="/Link2Serve/my_listings.php">My listings</a>
                     
                  </li>
                  </ul>
               </li>
               <li><a href="#">Options<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="/Link2Serve/search.php">Filter Search</a></li>
                     <li><a href="/Link2Serve/listings.php">All listings</a></li>
                  </ul>
               </li>
               <li><a href="#">Help<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="/Link2Serve/about.php">About us</a></i></li>
                     <li><a href="/Link2Serve/contact.php">Contact us</a></i></li>
                     <li><a href="/Link2Serve/contact.php#faq">FAQ</a></i></li>
                  </ul>
               </li>
            </ul>
         </div>

         <ul>
            <li><a href="/Link2Serve/saved.php">Saved <i class="far fa-heart"></i></a></li>
            <li>
               <a href="#">Account <i class="fas fa-angle-down"></i></a>
               <ul>
                  <?php if($user_id == '') { ?> <!-- Show Login/Sign Up option if user is not logged in -->
                        <li><a href="/Link2Serve/login.php">Login/Sign Up</a></li>
                  <?php } else { ?> <!-- Show other options if user is logged in -->
                        <li><a href="/Link2Serve/update.php">Update profile</a></li>
                        <li><a href="/Link2Serve/components/user_logout.php" onclick="return confirm('Logout from this website?');">Logout</a></li>
                  <?php } ?>
               </ul>
            </li>

         </ul>
      </section>
   </nav>

</header>

<!-- header section ends -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('components/get_unread_messages.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const unreadCountElement = document.getElementById('unread-count');
                if (data.unread_count > 0) {
                    unreadCountElement.textContent = data.unread_count;
                    unreadCountElement.style.display = 'inline-block';
                } else {
                    unreadCountElement.style.display = 'none';
                }
            } else {
                console.error('Error fetching unread messages:', data.message);
            }
        })
        .catch(error => console.error('Error fetching unread messages:', error));
});
</script>
<script src="/Link2Serve/js/fetch_unread_count.js"></script>


<style>
.badge {
    display: none; /* Hidden by default */
    position: absolute;
    top: -5px;
    right: -48px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 0.2em 0.5em;
    font-size: 0.5em;
    font-weight: bold;
}
#icon{
    color: white;
}
</style>
<!-- header section ends -->

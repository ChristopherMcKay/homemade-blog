<div id="burger">
    <i class="fas fa-bars"></i>
</div>

<div id="search-form" class="search">
    <form method="get" action="blogSearchProc.php">
      <input type="search" name="q" placeholder="Blog Search">
      <button><i class="fas fa-search"></i></button>
    </form>
</div>

<nav id="mobile-nav">
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="blog.php">Blog</a></li>
    <li><a href="#">Portfolio</a></li>
    <li><a href="#">Contact</a></li>
    
    <li>
      <?php
      if (isset($_SESSION['user'])) {
        echo 'Hi, ' . $_SESSION['firstName'];
        echo ' <a href="?logout=true">Logout</a>';
      }
      else {
        echo '<a href="#" onclick="return loginJoin()">Log In / Join</a>';
      }
      ?>
    </li>
    
  </ul>
</nav>
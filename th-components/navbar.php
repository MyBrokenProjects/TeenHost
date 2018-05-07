<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<nav class="navbar navbar-expand-lg navbar-dark th-bg-dark">
    <a class="navbar-brand impact th-brand" href="index.php"><span class="primary-text">Teen</span><span class="secondary-text">Host</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto th-pright">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Support
        </a>
        <div class="dropdown-menu th-dropdown" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="ts3server://ts3.teenhost.tk">24/7 TeamSpeak Support</a>
        </div>
      </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Account
        </a>
        <div class="dropdown-menu th-dropdown" aria-labelledby="navbarDropdownMenuLink">
        <?php if(!isset($_SESSION['id'])): ?>
        <a class="dropdown-item" href="login.php">Login</a>
        <a class="dropdown-item" href="register.php">Register</a>
        <?php else: ?>
        <a class="dropdown-item" href="logout.php">Logout</a> 
        <?php endif; ?>
        </div>
      </li>
        <?php if(isset($_SESSION['id'])): ?>
        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Minecraft
        </a>
        <div class="dropdown-menu th-dropdown" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="mcportal.php">Portal</a>
        </div>
        </li>
        
        <?php endif; ?>
    </ul>
  </div>
</nav>
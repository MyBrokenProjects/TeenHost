<?php 

    include('th-php/settings.php');
    include('th-php/database.php');

    if(isset($_SESSION['id'])) {
        header("Location: index.php");
        return;
    }

    if(isset($_POST['login'])) {
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LdHtFQUAAAAADjTPf7b4kGEIPAWqC4AEqzELzHK',
            'response' => $_POST["g-recaptcha-response"]
         );
          $options = array(
          'http' => array (
          'method' => 'POST',
          'content' => http_build_query($data)
          )
          );
          $context  = stream_context_create($options);
          $verify = file_get_contents($url, false, $context);
          $captcha_success=json_decode($verify);
        
          if($captcha_success->success == false) {
              header("Location: register.php?alert=Your captcha was not valid, please try again.");
              return;
          }
        
          $query = $con->prepare('SELECT * FROM users WHERE email=:email');
          $query->bindParam(':email', $email);
          $query->execute();
          
          if($query->rowCount() <= 0) {
              header("Location: register.php?alert=Your email doesn't exist, try registering an account or contacting support.");
              return;
          }
          $r = $query->fetch(PDO::FETCH_ASSOC);
          $dbpassword = $r["password"];

          if(!password_verify($password, $dbpassword)) {
              header("Location: login.php?alert=Your password was incorrect, try again or contact support to change it.");
              return;
          }
          if (session_status() == PHP_SESSION_NONE) { session_start(); }
          $_SESSION['id'] = $r["id"];
          header("Location: index.php?alert=You have logged in, head to your control panel by using the navigation bar.");
          return;
        
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include($TeenHostCP . 'styles.php'); ?>
      
    <title>Teen Host</title>
  </head>
  <body>

    <?php include($TeenHostCP . 'navbar.php'); ?>
      
    <div class="container th-landing">
    <span class="impact primary-text th-heading">LOGIN</span><br>
    <span class="impact blind-text th-h-paragraph">ENTER YOUR CREDENTIALS, AND UNLOCK YOUR SERVER OASIS</span>
    </div><br>
      
    <div class="container">
    <?php if(isset($_GET['alert'])): ?>
        <div class="alert alert-dark" role="alert">
          <?php echo($_GET['alert']); ?>
        </div>
    <?php endif; ?>
    <form method="post" action="login.php">
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <div class="form-group">
      <div class="g-recaptcha" data-sitekey="6LdHtFQUAAAAAIVBraEip9vZTwNpEG-dg-_ROAWz" data-theme="dark"></div>
    </div>
      <div class="form-group">
        <button type="submit" class="btn primary-overlay" name="login">Login</button>  
      </div>
    </form>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
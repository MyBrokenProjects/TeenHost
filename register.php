<?php 

    include('th-php/settings.php');
    include('th-php/database.php');

    if(isset($_POST['register'])) {
        
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
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
        
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              header("Location: register.php?alert=Your email was not valid, please try again.");
              return;
          }
        
          if($password != $cpassword) {
              header("Location: register.php?alert=Your passwords don't match, please try again.");
              return;
          }
        
          $query = $con->prepare('SELECT email FROM users WHERE email=:email');
          $query->bindParam(':email', $email);
          $query->execute();
          
          if($query->rowCount() > 0) {
              header("Location: register.php?alert=Your email already exists in our database, try using another.");
              return;
          }
        
        function randomKey($length) {
            $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

            for($i=0; $i < $length; $i++) {
                $key .= $pool[mt_rand(0, count($pool) - 1)];
            }
            return $key;
        }
        
          $query = $con->prepare('INSERT INTO users(ip,email,name,password,serverkey) VALUES (:ip,:email,:name,:password,:serverkey)');
          $query->bindParam(':ip',$ip);
          $query->bindParam(':email',$email);
          $query->bindParam(':name',$name);
          $query->bindParam(':password',password_hash($password, PASSWORD_BCRYPT));
          $query->bindParam(':serverkey',randomKey(32));
          if ($query->execute()) {
              header("Location: login.php?alert=Hey, " . $name . ". Your account has been created, please login!");
              return;
          } else {
              header("Location: register.php?alert=There was a problem creating your account. Try again later.");
              return;
          }
        
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
    <span class="impact primary-text th-heading">REGISTER FOR</span> &nbsp; <span class="impact secondary-text th-heading">FREE</span><br>
    <span class="impact blind-text th-h-paragraph">REMEMBER: YOUR EMAIL IS THE KEY TO LOGGING IN. USE A REAL ADDRESS.</span>
    </div><br>
      
    <div class="container">
    <?php if(isset($_GET['alert'])): ?>
        <div class="alert alert-dark" role="alert">
          <?php echo($_GET['alert']); ?>
        </div>
    <?php endif; ?>
    <form method="post" action="register.php">
      <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder="First Name" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <div class="form-group">  
        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" requied>
      </div>
      <div class="form-group">
      <div class="g-recaptcha" data-sitekey="6LdHtFQUAAAAAIVBraEip9vZTwNpEG-dg-_ROAWz" data-theme="dark"></div>
    </div>
      <div class="form-group">
        <button type="submit" class="btn primary-overlay" name="register">Register</button>  
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
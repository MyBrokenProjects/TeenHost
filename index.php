<?php 

    include('th-php/settings.php');
    header("Location: farewell.php");
    
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
    <?php if(isset($_GET['alert'])): ?>
        <div class="alert alert-dark" role="alert">
          <?php echo($_GET['alert']); ?>
        </div>
    <?php endif; ?>
    <span class="impact primary-text th-heading">SERVER HOSTING FOR TEENAGERS</span><br>
    <span class="impact secondary-text th-heading">POWERFUL AND FREE HOSTING</span><br>
    <span class="impact blind-text th-h-paragraph">ALL ACCESS GAME SERVERS BUILT FOR PERFORMACE ON BEHALF OF TEENS</span>
    </div>
      
      <br>
      <div class="container th-features">

    <div class="th-offer"></div>
    <div class="th-offer-sec">
    
        <span class="impact blind-text th-h-paragraph">WHAT WE OFFER. DON'T WAIST MONEY ON ADD-ONS.</span><br>
        <div class="container offer-item-container">
          <div class="row">
            <div class="col-sm">
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-server th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">Dedicated Machines</span><br>
                  <span class="blind-text">Our services are all run on dedicated machines and used specifically for hosting.</span>
                </div>
                </div>
              </div>
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-link th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">Free TeenHost Subddomain</span><br>
                  <span class="blind-text">We'll provide you with a free teenhost subdomain, such as myserver.teenhost.tk.</span>
                </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-hdd th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">Solid State Drives</span><br>
                  <span class="blind-text">All our machines feature lightning fast drives capable of high-speed file processing.</span>
                </div>
                </div>
              </div>
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-life-ring th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">24/7 Support</span><br>
                  <span class="blind-text">Our TeamSpeak is always open to questions, you can connect to it by using the navigation dropdown.</span>
                </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-cloud-upload-alt th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">99.9% Uptime</span><br>
                  <span class="blind-text">Thanks to reliable hardware and high speed connections you will rarely experience downtime.</span>
                </div>
                </div>
              </div>
              <div class="item">
              <div class="row">
                <div class="col i-col">
                 <i class="fas fa-desktop th-icon primary-text"></i>
                </div>
                <div class="col-9">
                  <span class="secondary-text i-text">Control Panel</span><br>
                  <span class="blind-text">Our PHP Programmers provide a control panel in which to modify your server at ease, free of charge.</span>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
    </div>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
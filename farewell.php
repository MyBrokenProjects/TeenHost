<?php 

    include('th-php/settings.php');
    
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
    <span class="impact text-warning th-heading">Farewell to TeenHost</span><br>
    <span class="impact blind-text th-h-paragraph">A small project to see the limitations of a single teenager.</span>
    </div>
      
      <br>

      <center><span class="container" style="color:white; font-size: 1.2rem;">Hello everyone. My name is Ryan, and I am the founder of TeenHost.tk - The business originally started out to see the limitations of what a single teenager striving to learn how to program could create. Obviously, it's too much to handle and with the approach of summer for someone who is still in school... well, it's way too much to handle. With a one-man team it isn't practical to keep a site like this running. All your personal data will be deleted and disposed of and will not be released by myself or anyone with access to our machines. As for your servers, our control panel will be running until May 8th and you can still access your FTP's till our final goodbye. Please download your files as the backup drives will be cleared on that date. I thank you for using my service and helping me to see if it's something I can be passionate about. If you have any other questions, our Support TeamSpeak will be open until the final closing date. <strong>Servers can no longer be started nor stopped. FTP Logins will be changed to READ only.</strong><br><br>~ Ryan, Founder and Developer of TeenHost</span></center>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
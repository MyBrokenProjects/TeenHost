<?php 
    
                function file_edit_contents($file_name, $line, $new_value){
                  $file = explode("\n", rtrim(file_get_contents($file_name)));
                  $file[$line] = $new_value;
                  $file = implode("\n", $file);
                  file_put_contents($file_name, $file);
                }

    //error_reporting(0);
    session_start();

    include('th-php/settings.php');
    include('th-php/database.php');

    if(!isset($_SESSION['id'])) {
        header("Location: index.php");
        return;
    }

    $id = $_SESSION['id'];
    $userq = $con->prepare('SELECT * FROM users WHERE id = :id');
    $userq->bindParam(':id',$id);
    $userq->execute();
    $user = $userq->fetch(PDO::FETCH_ASSOC);

    $hasserver = false;
    $active = false;

    $mcserverq = $con->prepare('SELECT * FROM mcservers WHERE userid = :userid');
    $mcserverq->bindParam(':userid',$id);
    $mcserverq->execute();
    if($mcserverq->rowCount() > 0) {
    $mcserver = $mcserverq->fetch(PDO::FETCH_ASSOC);
    $hasserver = true; 
    if($mcserver['activated']) {
        $active = true;

        class MCServerStatus {
 
    public $server;
    public $online, $motd, $online_players, $max_players;
    public $error = "Online";
 
    function __construct($url, $port = '25565') {
 
        $this->server = array(
            "url" => $url,
            "port" => $port
        );
 
        if ( $sock = @stream_socket_client('tcp://'.$url.':'.$port, $errno, $errstr, 1) ) {
 
            $this->online = true;
 
            fwrite($sock, "\xfe");
            $h = fread($sock, 2048);
            $h = str_replace("\x00", '', $h);
            $h = substr($h, 2);
            $data = explode("\xa7", $h);
            unset($h);
            fclose($sock);
 
            if (sizeof($data) == 3) {
                $this->motd = $data[0];
                $this->online_players = (int) $data[1];
                $this->max_players = (int) $data[2];
            }
            else {
                $this->error = "Cannot retrieve server info";
            }
 
        }
        else {
            $this->online = false;
            $this->error = "Offline";
        }
 
    }
 
}
        
        $server = new MCServerStatus("71.194.47.213", $mcserver['port']);
        if(isset($_POST['start'])) {
            if($server->error == "Online") {
                header("Location: mcportal.php?alert=Your server is already started.");
                return;
            }
            chdir('c:/xampp/htdocs/TeenHost/mc/'. $user['serverkey']);
           // exec('start C:/java.exe -Xmx1G -jar c:/xampp/htdocs/TeenHost/mc/'. $user['serverkey'] .'/server.jar -o true');
          //  rename('C:/java.exe','C:/' . $user['serverkey'] . ".exe");
          //  pclose(popen('start C:/' . $user['serverkey'] . '.exe -Xmx1G -jar c:/xampp/htdocs/TeenHost/mc/'. $user['serverkey'] .'/server.jar -o true', "r"));
         //   rename('C:/' . $user['serverkey'] . ".exe",'C:/java.exe');
            
            header("Location: mcportal.php?alert=Your server was started. Please allow up to 1 minute to connect.");
            return;
        }
        if(isset($_POST['stop'])) {
            if($server->error == "Offline") {
                header("Location: mcportal.php?alert=Your server is already stopped, or is busy starting up.");
                return;
            }
            chdir('c:/xampp/htdocs/TeenHost/mc/'. $user['serverkey']);
          //  pclose(popen('taskkill.exe /IM '. $user['serverkey'] .'.exe',"r"));
            header("Location: mcportal.php?alert=Your server is stopping. Please allow up to 1 minute to shutdown.");
            return;
        }
        
    }
    }

    if(!$active) {
        
        if(isset($_POST['create'])) {
            
            $sd = $_POST['subdomain'];
            $type = $_POST['type'];
            $username = $_POST['username'];
       
            $query = $con->prepare('SELECT subdomain FROM mcservers WHERE subdomain = :subdomain');
            $query->bindParam(':subdomain',$sd);
            $query->execute();
            if($query->rowCount() > 0) {
                header("Location: mcportal.php?alert=That subdomain is already in use, please try another.");
                return;
            }
            
            $port = 25565 + $id+1;
            
            $createserverq = $con->prepare('INSERT INTO mcservers(userid,subdomain,port,type,username) VALUES(:userid,:subdomain,:port,:type,:username)');
            $createserverq->bindParam(':subdomain',$sd);
            $createserverq->bindParam(':type',$type);
            $createserverq->bindParam(':port',$port);
            $createserverq->bindParam(':userid',$id);
            $createserverq->bindParam(':username',$username);
            if($createserverq->execute()) {
                $directoryuser = "TeenHost/mc/" . $user['serverkey'];
                mkdir($directoryuser, 0700);
                
                $files = scandir("TeenHost/mc/" . $type);
                $source = "TeenHost/mc/" . $type . "/";
                $destination = $directoryuser . "/";
                // Cycle through all source files
                foreach ($files as $file) {
                  if (in_array($file, array(".",".."))) continue;
                  // If we copied this successfully, mark it for deletion
                  if (copy($source.$file, $destination.$file)) {
                    $delete[] = $source.$file;
                  }
                }
                
                $mport = $destination . "server.properties";
                file_edit_contents($mport, 10, "server-port=" . $port);
                file_edit_contents($mport, 35, "motd=" . $username . "'s Minecraft Server");
                
                header("Location: mcportal.php");
                return;
            } else {
                header("Location: mcportal.php?alert=There was a problem creating your server, please try again later.");
                return;
            }
            
            
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
    
    <?php if($hasserver): ?>
    <?php if($active): ?>
    <div class="container th-landing">
    <?php if(isset($_GET['alert'])): ?>
        <div class="alert alert-dark" role="alert">
          <?php echo($_GET['alert']); ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
          Servers were recently shutdown for testing of the "Stop" button. This feature may still be unsafe.
        </div> 
    <?php endif; ?>
    <span class="impact primary-text th-heading">Minecraft</span> &nbsp; <span class="impact secondary-text th-heading">Portal</span><br>
    <span class="impact blind-text th-h-paragraph">CONTROL YOUR SERVER USING FTP AND START CONTROLS</span>
    </div><br>
    <div class="container" style="text-align:center;">
      <div class="form-group">
          <form method="post" action="mcportal.php">
        <button type="submit" class="btn primary-overlay" name="start">Start Server</button>  
          </form>
          
      </div>
      <div class="form-group">
          <form method="post" action="mcportal.php">
        <button type="submit" class="btn primary-overlay" name="stop">Stop Server</button>  
          </form>
      </div>
        <h5 class="primary-text">IP - <span class="secondary-text"><?php echo($mcserver['subdomain'] . ".teenhost.tk"); ?></span></h5>
        <h5 class="primary-text">Status - <span class="secondary-text"><?php echo($server->error); ?></span></h5>
        <h5 class="primary-text">Players - <span class="secondary-text"><?php echo($server->online_players); ?></span><span class="primary-text">/</span><span class="secondary-text"><?php echo($server->max_players); ?></span></h5>
        <h5 class="primary-text">MOTD - <span class="secondary-text"><?php echo($server->motd); ?></span></h5>
        <h5 class="secondary-text"><span class="primary-text">FTP - </span> <span class="secondary-text">Host: </span><span class="primary-text">ftp.teenhost.tk </span> Username: <span class="primary-text"><?php echo($user['email']); ?> </span> Password: <span class="primary-text"><?php echo($mcserver['ftppassword']); ?></span> Port: <span class="primary-text">21</span></h5><br>
    </div>
    <div class="container">
      
        <table class="table table-sm table-logs">
          <thead>
            <tr>
              <th scope="col">Log</th>
            </tr>
          </thead>
          <tbody>
            <?php 
        
              
function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if ($beginningPos === false || $endPos === false) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return str_replace($textToDelete, '', $string);
}   
                if(file_exists('TeenHost/mc/' . $user['serverkey'] . '/logs/latest.log')) {
                $file = file('TeenHost/mc/' . $user['serverkey'] . '/logs/latest.log');
                for ($i = max(0, count($file)-46); $i < count($file); $i++) {
                  echo('<tr class="secondary-text"><th>' .$file[$i] . '</th></tr>');
                }
                } else {
                    echo('<tr class="secondary-text"><th>No log file exists.</th></tr>');
                }
              
              ?>
          </tbody>
        </table>
      
    </div>
    <?php else: ?>
    <div class="container th-landing">
    <span class="impact primary-text th-heading">Minecraft</span> &nbsp; <span class="impact secondary-text th-heading">Portal</span><br>
    <span class="impact blind-text th-h-paragraph">PLEASE ALLOW 24 HOURS FOR YOUR SERVER TO BE SETUP BY ADMINISTRATORS</span><br>
    <span class="impact blind-text th-h-paragraph">CONTACT SUPPORT FOR IMMEDIATE SETUP</span>
    </div><br>
    <?php endif; ?>
    <?php else: ?>
    <div class="container th-landing">
    <span class="impact primary-text th-heading">Minecraft</span> &nbsp; <span class="impact secondary-text th-heading">Portal</span><br>
    <span class="impact blind-text th-h-paragraph">CREATE YOUR MINECRAFT SERVER NOW</span>
    </div><br>
      
    <div class="container">
    <?php if(isset($_GET['alert'])): ?>
        <div class="alert alert-dark" role="alert">
          <?php echo($_GET['alert']); ?>
        </div>
    <?php endif; ?>
    <form method="post" action="mcportal.php">
      <div class="form-group">
        <input type="text" class="form-control" name="subdomain" placeholder="(subdomain).teenhost.tk" required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Minecraft Username" required>
      </div>
      <div class="form-group">
        <select class="form-control" name="type" required>
          <option disabled>Server Type</option>
          <option>CraftBukkit 1GB RAM 2 GB SSD</option>
          <option>Vanilla 1GB RAM 2 GB SSD</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn primary-overlay" name="create">Create</button>  
      </div>
    </form>
    </div>
    <?php endif; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>
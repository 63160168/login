<?php
  session_start();
  
  $login_success = 0;
  $captcha_status = 0;
  if(isset($_GET['login'])) { 

    if($_SESSION['secure'] == $_GET['user_input']){
      $captcha_status = 1;
     
    } 
    else if ($_GET['user_input'] ==null){
      $captcha_status = 2;
    }
    else{
      $captcha_status = 3;
    }

    if($captcha_status==1){
      $username = $_GET['username'];
      $password = $_GET['password'];
  
  
      $dbservername = "database";
      $dbusername = "docker";
      $dbpassword = "docker";
      $dbname = "docker";
      
      // Create connection
      $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      //$sql = "SELECT username FROM users WHERE username='" . $username . "' AND password='" . $password . "'";
      //echo $sql;
      $sql = "SELECT username FROM users WHERE username=? AND password=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $username, $password);
      $stmt->execute();
      $stmt->bind_result($resultUsername);
      //echo $resultUsername;
      //$result = $conn->query($sql);
      $stmt->fetch();
      //if ($result->num_rows > 0) {
      if ($resultUsername) {
        $login_success = 1;
      } else {
        $login_success = 2;
      }
      $stmt->close();
      //$conn->close();
    }
    echo $login_success;
    echo $captcha_status;
   
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Template</title>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/login.css">
  
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="assets/images/login.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="assets/images/logo.svg" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Sign into your account</p>
              <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="form-group">
                    <label for="username" class="sr-only">Email</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="your username">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="text" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <div id="ae_captcha_api"></div>
                  <div><input type="text" placeholder = "Enter Captcha" name="user_input"/></div></br>
                  
                
                  <div  class="form-group mb-4" ><input type="submit" name="login" value ="login"/></div>
                </form>
                <?php if($login_success == 1 && $captcha_status == 1) { ?> 
                          <p style="color:green;" class="login-card-footer-text">Authentication Success</p>
                <?php } else if($login_success == 2 || $captcha_status == 3) { ?>
                          <p style="color:red;" class="login-card-footer-text">Authentication Failure</p>
                <?php } ?>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="./captcha-generator/asset/main.js"></script>
</body>
</html>


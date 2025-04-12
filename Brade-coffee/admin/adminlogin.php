<?php 
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="css/siglog.css" />
    
  </head>
  <body>
    <div class="log-box">
      <h1>Login as Admin</h1>  
      <form action="admin_login_db.php" method="post"> 
        <label>Username</label>
        <input type="text" placeholder="" name="username" required />
        <label>Password</label>
        <input type="password" placeholder="" name="password" required/>
        
        <input type="submit" value="Login" name="submit" /><br><br>
        <!-- <input type="submit" value="Submit" name="submit" /> -->
        <button class="bbtn"><a href="../index.php">Back</a></button>
    </form>
    </div>
  </body>
</html>
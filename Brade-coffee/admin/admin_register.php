<?php
include('conn.php');

if(isset($_POST['register']))
{ 
$username=$_POST['username'];

$password=$_POST['password'];

$cpassword=$_POST['cpassword'];
$hash_password= password_hash($password,PASSWORD_DEFAULT);


//selsct query 
$select_query="Select * from admin where name='$username'";
$result=mysqli_query($con,$select_query);
$row_count=mysqli_num_rows($result);
if($row_count>0){
  echo"<script>alert('This admin already exists!')</script>";
  echo"<script>window.open('admin_dashboard.php','_self')</script>";
}  else if($password!=$cpassword){
  echo"<script>alert('Passwords do not match!')</script>";
  echo"<script>window.open('admin_dashboard.php','_self')</script>";
}
else{


$sql= "insert into admin (name,password) values('$username','$hash_password')";


if(mysqli_query($con,$sql)){
  echo"<script>alert('You have successfully registered an Admin')</script>";
  echo"<script>window.open('admin_dashboard.php','_self')</script>";
}
else{
  echo "ERROR $sql.".mysqli_error($con);
}


}



}
?>


<!DOCTYPE html> 
<html lang="en">
  <head>
    <title>Registration</title>
    <link rel="stylesheet" href="css/siglog.css" />
  </head>
  <body class="bdy3">
    <div class="register-box">
      <h1 class="text-center">Register an admin</h1>
      <form action="" method="post">

        <label for="username">Username</label>
        <input type="text" id="username" placeholder="" name="username" required />

        

        <label for="password">Password</label>
        <input type="password" id="password" placeholder=""  name="password" required/>

        <label for="cpassword">Confirm Password</label>
        <input type="password" id="cpassword" placeholder="" name="cpassword" required/>
        <br>
        
        
        <input type="submit" value="Register" name="register" />
      
    </form>
    </div>
  </body>


</html>


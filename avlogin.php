<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

 <!--PHP code for form validation and then insertion into user table-->
<?php
  session_start();
   /*Cheking whether user is already logged in or not*/
   if(isset($_SESSION["loggedin"])&&$_SESSION["loggedin"]==true){
    header('location:index.php');
    exit;
   }
   require_once "dbh.inc.php";


   $username=$password="";
   $username_err=$password_err="";
    //on form submission validate
   if($_SERVER['REQUEST_METHOD']=="POST"){
     
     //username validation
     if(empty(test($_POST["username"]))){  
        $username_err="Please enter your username";
     }
     else $username=test($_POST["username"]);
     //password format and length validation
     if(empty(test($_POST["password"]))){
      $password_err="Please enter your password";
     }
     else $password=test($_POST["password"]);

     if(empty($username_err)&&empty($password_err)){
        //connecting to database to verify user
       $sql="SELECT username,password FROM users WHERE username= ?";
       if($stmt=mysqli_prepare($conn,$sql)){
          mysqli_stmt_bind_param($stmt,'s',$param_username);
          $param_username=$username;

          if(mysqli_stmt_execute($stmt)){

            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt)==1){

              mysqli_stmt_bind_result($stmt,$username,$hashed_password);
              if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password,$hashed_password)){
                   session_start();
                    //if verified user logs in and session starts
                   $_SESSION["loggedin"]=true;
                   $_SESSION["username"]=$username;
                   header('location:index.php');
                }
                 else{
                  $password_err="Password you entered is incorrect";
                 }
               } }
               else $username_err="No such username exists";
             }
             else echo"Oops! something went wrong, Try again.";
            }
          mysqli_stmt_close($stmt);  
       }
       mysqli_close($conn);//closing database connection
     }
      //to avoid user from corrupting the php inputs
    function test($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);

    return $data;
    }
?>
 <!--for modal box-->
<script type="text/javascript">
  function myfun(){
  var x= document.getElementById("topnav");
  if(x.className==="topnav"){
    x.className+="responsive";
  } else{
    x.className="topnav";
  }
  }

  var modal = document.getElementById('log');
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
 }
</script>

<style type="text/css">
 @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
 body {font-family: Arial, Helvetica, sans-serif;}

 .error{
  color:red;
 }
  #titl{
  float : left;
  font-size: 50px;
  font-family: georgia;
  color:white;
  padding: 10px;
 }
 .topnav{
  background-color: black;
  height: 80px;
  overflow:hidden;
 }
 .topnav a{
  float: right;
  display: block;
  margin: 15px 0px;
  text-decoration: none;
  font-family: helvatica;
  padding : 10px;
  font-size : 20px;
   border: none;
  opacity: 0.9;
 }
 .topnav a:hover{
  background-color: purple;
  color : white;
  opacity: 1;
 }
 .active{
  backgroun-color: purple;
  color: white;
 }
 .topnav .icon{
  display: none;
 }
 @media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
 }

 @media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }}
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
 h2{
  font-family: times-new-roman;
  font-size: 40px;
  }
  
 hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
 }
  button{
    width: 100%;
    opacity : 0.8;
    background-color: green;
    color : white;
    margin: 8px 0px;
    padding :14px 20px;
    border : 20px;
    pointer : cursor;
  }
  #login{
    width: auto;
    opacity:0.7;
    background-color: green;
    color: white;
    margin:20px;
    pointer: cursor;
  }
  #login:hover{
    opacity: 1;
  }
  button :hover{
    opacity: 1;
  }
  .cancelbtn{
    background-color: red;
    }
 .cancelbtn, .signup {
  float: left;
  width: 50%;
 }
 .container {
    padding: 16px;
 }

 #logo input[type=text],#logo input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
 }

 .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
   
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 10px;
 }
 .modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto;
    
    border: 1px solid #888;
    width: 70%; /* Could be more or less, depending on screen size */
 }
 .cancel {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
 }
 span .psw{
  float: right;
  padding-top: 16px;
 }
 .close {
    position: absolute;
    right: 25px;
    top: 10px;
    color: #000;
    font-size: 35px;
    font-weight: bold;
 }

 .close:hover,
 .close:focus {
    color: red;
    cursor: pointer;
 }
 .animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
 }

 @-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
 }

 @keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
 }
 @media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
 }
</style>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
 <!--Navigation bar-->
<div class="container-fluid">
 <div id="topnav" class="topnav">
  <label id="titl" class="logo">AllAsk</label>
  <div class="topnav">
  <a href="#appear" style="background-color:green;color:white" onclick="document.getElementById('log').style.display='block'">LOGIN</a>
    <a href="avsignup.php" id="signup" style="background-color:blue;color:white">SIGN UP</a>
  <a href="#" onclick="myfun()" class="icon"><i class="fa fa-bars"></i></a>
  </div>
 </div>
</div>
<!--div where modal login form will appear-->
<div id="appear" class="container">
  <center>
 <button  id="login" style="background-color:green;color:white;width:auto" onclick="document.getElementById('log').style.display='block'">LOGIN</button>
 <hr>
 <center>or</center>
 <br>
 <button  style="background-color:red;color:white;width:auto"><span class='fa fa-google'> Sign in with Google</span></button>
 </center>
</div>
 <!--modal login form fields-->
<div id="log" class="modal">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="modal-content animate container" id="logo">
    <span onclick="document.getElementById('log').style.display='none'" class="close" title='Close Modal'>&times;</span>
     <h2><center>Log In</center></h2>
     <hr>
     <div>
     <label><b>Username</b></label>
     <input type="text" placeholder="Enter username" name="username" value="<?php echo $username;?>">
     <span class="error"><?php echo $username_err;?></span>
     </div>
     <div>
     <label><b>Password</b></label>
     <input type="password" placeholder="Enter password" name="password">
     <span class="error"><?php echo $password_err;?></span>
     </div>
       <button type="submit"  value="login">Login</button>
       <hr>
       <div class="container" >
         <button type="button" onclick="document.getElementById('log').style.display='none'" class="cancel">Cancel</button>
         <span class="psw">Forget <a href="#">Password?</a></span>
       </div>
   </form>
</div>

<hr style="width:90%;border-color:black;margin-bottom:0px;margin-top:5px;">
<center>   
<footer style="font-family: times new roman">Designed & Developed By Backlog_69</footer>
</center>
</body>
</html>

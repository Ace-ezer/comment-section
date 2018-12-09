<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
 <!--responsive Navbar-->
<script type="text/javascript">
  function myfun(){
  var x= document.getElementById("topnav");
  if(x.className==="topnav"){
    x.className+="responsive";
  } else{
    x.className="topnav";
  }
 }
</script>
<!--form verification and insertion of user into database-->
<?php
 require_once "dbh.inc.php";

 $username= $email= $password= $repass= "";
 $namerr= $emailerr= $passworderr= $repasserr= "";
 if($_SERVER["REQUEST_METHOD"]=="POST"){
   //username verification i.e. non-empty, correct format and unique
   if(empty($_POST["username"]))
          { 
            $namerr="required field";}
      else
           { 
            if (!preg_match("/^[a-zA-Z_0-9]*$/",test($_POST["username"]))) { 
              $namerr = "Only letters and underscore allowed";
             }
             else{
              $sql= "SELECT id FROM users WHERE username = ?"; //checking if username already exists

              if($stmt = mysqli_prepare($conn,$sql)){
                mysqli_stmt_bind_param($stmt,"s",$param_username);
                $param_username=test($_POST["username"]);

                if(mysqli_stmt_execute($stmt)){
                  mysqli_stmt_store_result($stmt);
                  if(mysqli_stmt_num_rows($stmt)==1){
                    $namerr="Username already taken";  
                  }
                  else{
                     $username=test($_POST["username"]);
                  }
                }
                else echo "Oops! something went wrong. Try Again!";
              }
              mysqli_stmt_close($stmt);
             }
      } 
        //email format verification
      if (empty($_POST["email"])) {
         
          $emailerr = "Email is required";
               } else {
                       if (!filter_var(test($_POST["email"]), FILTER_VALIDATE_EMAIL)) { 
                                   $emailerr = "Invalid email format";
                                                                   }
                       else $email = test($_POST["email"]);                                            
                      }
       //password format verification
      if (empty($_POST["psw"])) { 
         $passworderr = "Password is required";
                    } else 
                    {
                       if (!preg_match("/^[a-zA-Z0-9@]*$/",test($_POST["psw"]))) { 
                      $passworderr = "Password can contain only letters,numbers(0-9) and @ allowed";}
                      elseif (strlen(test($_POST["psw"]))<8) { 
                          $passworderr="Length should be atleast 8 characters";
                       }
                       else $password = test($_POST["psw"]);
                              }
      //repeat password verification
      if (empty($_POST["repsw"])) { 
                $repasserr = "Re-enter Password again";
              } else {
                 if (!preg_match("/^[a-zA-Z0-9@]*$/",test($_POST["repsw"]))) { 
                  $repasserr = "Password can contain only letters,numbers(0-9) and @ allowed";
                    } else{
                
               if(test($_POST["psw"])!=test($_POST["repsw"])){ 
              $repasserr= "Passwords doesn't match. check and Re-enter again.";
                       }
                else $repass = test($_POST["repsw"]);        }
                   }
       //error checking and if none found then insertion into database
      if(empty($namerr)&&empty($emailerr)&&empty($passworderr)&&empty($repasserr)&&$_POST["check"]){
         $sql= "INSERT INTO users(username,email,password) VALUES (?,?,?)";
          if($stmt = mysqli_prepare($conn,$sql)){
            mysqli_stmt_bind_param($stmt,"sss",$param_username,$param_email,$param_password);

            $param_username=$username;
            $param_email= $email;
            $param_password= password_hash($password,PASSWORD_DEFAULT); //hashing password

            if(mysqli_stmt_execute($stmt)){
              header("location:avlogin.php");} //redirecting to login page
             else echo "Oops! something went wrong.";
          }
          mysqli_stmt_close($stmt);
      }             
    mysqli_close($conn); //closing database connection
 }
 //to prevent user from corrupting inserted information into the fields
 function test($data){
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);

  return $data;
 }
?>


<style type="text/css">
 @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
 body {font-family: Arial, Helvetica, sans-serif;}

 .error{
  color:red;
 }
 h2{
  font-family: times-new-roman;
  font-size: 40px;
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
 #fom input[type=text],#fom input[type=password], select, textarea{
  width: 100%;
  padding: 12px 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  resize: vertical;
 }
 #fom input[type=text]:focus, #fom input[type=password]:focus {
    background-color: #ddd;
    outline: none;
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
    border : none;
    pointer : cursor;
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
  .clearfix::after {
    content: "";
    clear: both;
    display: table;
 }
 @media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
 } 

 #log input[type=text],#log input[type=password] {
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
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
 }
 .modal-content {
    background-color: #fefefe;
    margin: 15%; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
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
    top: 0;
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
  <title>Sign Up</title>
</head>
<body>
 <!--Navigation bar-->
<div class="container-fluid">
 <div id="topnav" class="topnav">
  <label id="titl" class="logo">AllAsk</label>
  <div class="topnav">
  <a href="avlogin.php" id="login" style="background-color:green;color:white" onclick="document.getElementById('log').style.display='block'">LOGIN</a>
    <a href="#fom" id="signup" style="background-color:blue;color:white">SIGN UP</a>
  <a href="#" onclick="myfun()" class="icon"><i class="fa fa-bars"></i></a>
  </div>
 </div>
</div> 
 <!--sign up form-->
<form style="border:1px solid #ccc" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"> 
 <div id="fom" class="container">
  <h2><center>SIGN UP FORM</center></h2>
  <p>Please fill out the form to create an account.</p><hr>

    <label><b>Username:</b></label><span class="error"><input type="text" placeholder="Enter your full username"  name="username" value="<?php echo $username; ?>">*<?php echo $namerr;?></span><br> <!--form fields with php error display just in case-->
    
    <label><b>Email:</b></label><input type="text" placeholder="Enter valid email" name="email" value="<?php echo $email; ?>"><span class="error">*<?php echo $emailerr;?></span><br>

    <label><b>Password:</b></label><input  type="password" placeholder="create password" name="psw" value="<?php echo $password;?>"><span class="error">*<?php echo $passworderr;?></span><br>

    <label><b>Re-enter password:</b></label><input type="password" placeholder="Repeat password" name="repsw" value="<?php echo $repass;?>"><span class="error">*<?php echo $repasserr;?></span><br>

   <label><input type="checkbox" name="check"> By clicking on signup button you are agreeing to our <a href="#">Terms & Conditions.</a></label>
      <div class="clearfix">
        <button type="button" class="cancelbtn">Cancel</button>
        <button type="submit" class="signup" name="submit" value="submit">Sign up</button></div>
   </div>
</form> 
   <hr style="width:90%;border-color:black;margin-bottom:0px;margin-top:5px; ">     
   <center>   
   <footer style="font-family: times new roman">Designed & Developed By Backlog_69</footer>
   </center>
</body>
</html>   
           
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

<?php
 session_start();

 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: avlogin.php");
    exit;
 }
 date_default_timezone_set('Europe/Copenhagen');
  include 'dbh.inc.php';
  include 'comment.inc.php';
?>

 <!--responsive navbar-->
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

<link rel="stylesheet" type="text/css" href="signupCSS.html">

<style type="text/css">
  body{
    	background-color: #ddd;
           }
	textarea {
          width: 500px;
          height: 50px;
          background-color: #fff;
          resize: none;
	        } 
	button{
           width: 80px;
           height: 25px;
           background-color: #282828;
           border:none;
           color: #fff;
           cursor: pointer;
           margin-bottom: 60px;
	      }
	.comment-box{
		width: 815px;
		padding:20px;
		margin-bottom: 4px;
		background: white;
		border-radius:4px;
    position: relative;
	}
	.comment-box p{
	 font-family: arial;
	 font-size: 14px;
	 line-height: 16px;
	 color: #282828;
	 font-weight:100;
	}     
    .edit-form{
      position:absolute;
      top:0px;
      right:0px;
    } 
    .edit-form button{
         width: 40px;
         height: 20px;
         color: #282828;
         background-color: #fff;
         opacity: 0.7;
    }
    .edit-form button:hover{
        opacity:1;
    }        
    .delete-form{
         position:absolute;
          top: 0px;
          left:750px;    
    }
    .delete-form button{
         width: 40px;
         height: 20px;
         color: #282828;
         background-color: #fff;
         opacity: 0.7;
    }
    .delete-form button:hover{
        opacity:1;
    }
</style>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   <!--Nav bar-->
  <div class='container-fluid'>
   <div id='topnav' class='topnav'>
  <label id='titl' class='logo'>AllAsk</label>
  <div class='topnav'>
  <a href='logout.php'>Log Out</a>
  <a href='myindex.php'>Profile</a>
  <a href='index.php'>Home</a>
  <a href='#' onclick='myfun()' class='icon'><i class='fa fa-bars'></i></a>
  </div>
  </div><br>

<?php
 //information of user and comment to be editted
  $cid=$_POST['cid'];
  $uid=$_SESSION['username'];
  $date=$_POST['date'];
  $message=$_POST['message'];
  
 //profile picture and username section 
 $id=$_SESSION['username'];
 $sql="SELECT * FROM users WHERE username='$id'";
 $result=mysqli_query($conn,$sql);
 if($row=$result->fetch_assoc()){
          echo "<div  class='usercontainer row'>";
          if ($row['status']==0) {
            echo "<div class='col-md-75'><img src='uploads/profile".$id.".jpg' alt='avatar' class='avatar'>";
          }
          else {
          echo "<div class='col-md-75'><img src='uploads/profiledefault.jpg'>";
           }
          echo "</div><div class='col-md-25'><p>".$id."</p></div>";
          echo "</div>";  
  }
  
 //edit comment text area to edit and submit the comment
 echo "<div class='ask'>Edit Question?</div>";
 echo " <form method='POST' action='".editcomments($conn,$uid)."'>
  <input type='hidden' name='cid' value='".$cid."'>
	<input type='hidden' name='uid' value='".$uid."'>
	<input type='hidden' name='date' value='".$date."'>
	<textarea name='message'>".$message."</textarea><br>
	<button type='submit' name='editSubmit'>Edit</button>
       </form>" ; 
?>

 <hr>
   <center>   
   <footer class='foot'>Designed & Developed By Backlog_69</footer>
   </center>
</body>
</html>
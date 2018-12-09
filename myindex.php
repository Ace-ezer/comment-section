 <!--Profile Page-->
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
<link rel="stylesheet" type="text/css" href="roughcss.html">

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
 <!--Navigation bar-->
 <div class='container-fluid'>
 <div id='topnav' class='topnav'>
  <label id='titl' class='logo'>AllAsk</label>
  <div class='topnav'>
   <a href='logout.php'>Log Out</a>
  <a href='#ask'>Profile</a>
  <a href='index.php'>Home</a>
  <a href='#' id='searchBar'>
  <form method='POST' action='searchResults.php'>
  <input type='text' name='search' placeholder='search..'>
  <button type='submit' name='searchSubmit'>search</button></form></a>
  <a href='#' onclick='myfun()' class='icon'><i class='fa fa-bars'></i></a>
  </div>
 </div><br>

<?php

  //user profile pic and username section
 $id=$_SESSION['username'];
 $sql="SELECT * FROM users WHERE username='$id'";
 $result=mysqli_query($conn,$sql);
 if($row=$result->fetch_assoc()){
          echo "<div class='usercontainer'>";
          echo "<div  class='row'>";
          if ($row['status']==0) {
            echo "<div class='col-md-50'><img src='uploads/profile".$id.".jpg' alt='avatar' class='avatar'>";
          }
          else {
          echo "<div class='col-md-50'><img src='uploads/profiledefault.jpg'>";
           }
          echo "</div><div class='col-md-25'><p class='para'>".$id."</p></div>
                  <div class='col-md-25'><h3>Profile</h3></div>";
          echo "</div> </div>";  
 }
  //section to upload or delete your profile image
 echo " <div class='row'>
   <div class='col-md-50'>
   <form method='POST' action='upload.php' enctype='multipart/form-data'>
   <input type='file' name='file'>
   <button type='submit' name='imgsubmit'>Upload</button>
  </form> </div>
   <div class='col-md-50'>
  <form method='POST' action='deleteimage.php'>
   <button type='submit' name='delsubmit'>Delete</button>
  </form>
   </div>
  </div>";
  //asking new question text area
 echo "<div id='ask'>Ask A Question?</div>";  
 echo " <div id='comment'>
  <form method='POST' action='".setcomments($conn,$_SESSION['username'])."'>
	<input type='hidden' name='uid' value=''>
	<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
	<textarea name='message'></textarea><br>
	<button type='submit' name='commentSubmit'>Post</button>
       </form>
       </div>" ; 
    echo "<div id='ask'>Asked Questions..</div><hr style='margin-left:0px;'>";   
    getmycomments($conn,$_SESSION['username']);//showing already asked questions by user and their replies 
    echo"<hr style='margin-left:0px;'>";
    echo "<div id='ask'>Answered Questions..</div><hr style='margin-left:0px;'>";
    getanscomments($conn,$_SESSION['username']); //showing questions whose answers were given by the user
?>
    <hr>
   <center>   
   <footer class='foot'>Designed & Developed By Backlog_69</footer>
   </center>

</body>
</html>
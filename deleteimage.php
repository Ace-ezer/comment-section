<?php
//deleting an image 
session_start();
include_once 'dbh.inc.php';

$id=$_SESSION['username'];

$filename="uploads/profile".$id."*"; //file name in the root folder 
$fileinfo=glob($filename);//file info in array format

$fileext=explode(".", $fileinfo[0]);
$fileActualExt=$fileext[1];

$file="uploads/profile".$id.".".$fileActualExt; //file path to be deleted

 $sql="UPDATE users SET status=1 WHERE username='$id'"; // setting upload status to 1 i.e. no image for current profile
 $result=mysqli_query($conn,$sql);
 
 header('location:myindex.php?imagedeleted');
?>
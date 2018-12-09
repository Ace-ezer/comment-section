 <!--to upload a profile pic of type jpg,jpeg,png or gif-->
<?php
  session_start();
  include_once 'dbh.inc.php';
  $id=$_SESSION['username'];
  
    //on clicking upload button on profile page
 if(isset($_POST['imgsubmit'])){

     $file=$_FILES['file'];//file details in an array

     $filename=$file['name'];
     $filetmpname=$file['tmp_name'];
     $size=$file['size'];
     $error=$file['error'];
     $type=$file['type'];

     $fileExt=explode('.', $filename);
     $fileActualExt=strtolower(end($fileExt));

     $allowed= array('jpg','jpeg','png','gif');
      //checking whether the file is of pre-determined format
     if(in_array($fileActualExt, $allowed)){
     	if($error==0){
                 if($size<1000000){
                 	$filenamenew="profile".$id.".".$fileActualExt;
                 	$fileDestination="uploads/".$filenamenew;
                 	move_uploaded_file($filetmpname, $fileDestination);
                 	$sql="UPDATE users SET status=0 WHERE username='$id'";
                 	$result=mysqli_query($conn,$sql);
                 	header('location:myindex.php?uploadsuccess');
                 }
                 	else echo 'File is too big';
     	}
     	else echo 'There was an error uploading your file!';
     }
     else echo 'you cannot upload this type of file!';

 }

?>
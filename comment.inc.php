<!--Containes all the functions to edit delete and display comments,replies and search results-->
<?php
 
 //inserting questions into comments table
function setcomments($conn,$uid){
 	if(isset($_POST['commentSubmit'])){	
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="INSERT INTO comments(username,date,message) VALUES ('$uid','$date','$message')";
    $result= mysqli_query($conn,$sql);
     }
}

//display all the questions onto home page
function getcomments($conn,$user){
 	$sql="SELECT * FROM comments ORDER BY cid DESC";
 	$result=mysqli_query($conn,$sql);
 	while($row=$result->fetch_assoc()){
 		$id=$row['username'];
     $sql2="SELECT * FROM users WHERE username='$id'";
 	   $result2=mysqli_query($conn,$sql2);
     if ($row2=$result2->fetch_assoc()) {
        echo "<div class='comment-box'><p>";  
        echo  "<h5>".$row2['username']."</h5>";
        echo "<span id='date'>".$row['date']."</span><br>";   
        echo "<h6>".nl2br($row['message'])."</h6>";
        echo "</p>";
 	     if( $user==$row2['username']){
 	      echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>";
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <input type='hidden' name='uid' value='".$row['username']."'>
               <input type='hidden' name='date' value='".$row['date']."'>
               <input type='hidden' name='message' value='".$row['message']."'>
               <button>Edit</button>
               </form>";       
           } else{ echo "<form class='delete-form answer' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                }
        showreply($conn,$row['cid']);                        
 	      echo "</div>";
        }
 	}
}
//display all of the questions onto profile page
function getmycomments($conn,$user){
  $sql="SELECT * FROM comments WHERE username='$user' ORDER BY cid DESC";
  $result=mysqli_query($conn,$sql);
  while($row=$result->fetch_assoc()){
    $id=$row['username'];
     $sql2="SELECT * FROM users WHERE username='$id'";
     $result2=mysqli_query($conn,$sql2);
     if ($row2=$result2->fetch_assoc()) {
      echo "<div class='comment-box'><p>";  
        echo "<span><h5>".$row2['username']."</h5>";
        echo "<span id='date'>".$row['date']."</span></span><br>";   
      echo "<h6>".nl2br($row['message'])."</h6>";
      echo "</p>";
       if( $user==$row2['username']){
        echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>"; //delete button
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <input type='hidden' name='uid' value='".$row['username']."'>
               <input type='hidden' name='date' value='".$row['date']."'>
               <input type='hidden' name='message' value='".$row['message']."'>
               <button>Edit</button>
               </form>"; //edit button   
           } else{ echo "<form class='delete-form' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                } //reply button
        showreply($conn,$row['cid']); //to display all the replies on the question                       
        echo "</div>";
        }
  }
}
//displays all the comments on which you have answered
function getanscomments($conn,$user){
  $sql="SELECT * FROM reply WHERE username='$user' ORDER BY cid DESC";
  $result=mysqli_query($conn,$sql);
  while($row=$result->fetch_assoc()){
    $cid=$row['cid'];
  $sql2="SELECT * FROM comments WHERE cid='$cid'";
    $result2=mysqli_query($conn,$sql2);
    if($row2=$result2->fetch_assoc()){
      echo "<div class='comment-box'><p>";  
        echo "<span><h5>".$row2['username']."</h5>";
        echo "<span id='date'>".$row2['date']."</span></span><br>";   
      echo "<h6>".nl2br($row2['message'])."</h6>";
      echo "</p>";
       if( $user==$row2['username']){
        echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>";
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <input type='hidden' name='uid' value='".$row['username']."'>
               <input type='hidden' name='date' value='".$row['date']."'>
               <input type='hidden' name='message' value='".$row['message']."'>
               <button>Edit</button>
               </form>";       
           } else{ echo "<form class='delete-form' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                }
        showreply($conn,$row2['cid']);                        
        echo "</div>";
    }
  }
}
//display all the replies on a particular comment
function showreply($conn,$cid){
    $sql="SELECT * FROM reply where cid='$cid' ORDER BY cid DESC";
    $result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result)>0){
     echo "<a onclick='myFunction(".$cid.")' style='background-color:white;color:lightblue;cursor: pointer'>Answers..</a>";
     echo "<div id='mmm".$cid."' style='display:none;'>";
    while($row=$result->fetch_assoc()){
        echo "<div class='rep'><p>";  
        echo "<h5>".$row['username']."</h5>";
        echo "<span id='date'>".$row['date']."</span><br>";   
        echo "<i style='font-family:times new roman;font-weight: 50%;'>".nl2br($row['rmessage'])."</i>";
        echo "</p>";
        $sql2="SELECT * FROM comments where cid='$cid'";
        $result2=mysqli_query($conn,$sql2);
        if($row2=$result2->fetch_assoc()){
         if($row2['username']==$_SESSION['username']||$row['username']==$_SESSION['username'])
           {
           if($row['username']==$_SESSION['username'])$class='delete-form';
           else $class='edit-form answer';
        echo "<form class='".$class."' method='POST' action='".deletereply($conn)."'>
               <input type='hidden' name='rid' value='".$row['rid']."'>
               <button type='submit' name='replyDelete' style='background-color:lightblue'>Delete</button>
               </form>";
          if($row['username']==$_SESSION['username'])      
         echo "<form class='edit-form' method='POST' action='editreply.php'>
               <input type='hidden' name='rid' value='".$row['rid']."'>
               <input type='hidden' name='uid' value='".$row['username']."'>
               <input type='hidden' name='date' value='".$row['date']."'>
               <input type='hidden' name='rmessage' value='".$row['rmessage']."'>
               <button style='background-color:lightblue'>Edit</button>
               </form>";} 
                }      
        echo "</div>";
    }   echo "</div>"; 
     }
}

//inserts reply on a particular comment into the reply table
function replycomments($conn,$user){
    if(isset($_POST['replySubmit'])){  
    $cid=$_POST['cid'];  
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="INSERT INTO reply(cid,username,date,rmessage) VALUES('$cid','$user','$date','$message')";
    $result= mysqli_query($conn,$sql);
    header('location:index.php');
   exit();
     }
}
//allows to edit an existing comment
function editcomments($conn,$user){
    if(isset($_POST['editSubmit'])){  
    $cid=$_POST['cid'];  
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="UPDATE comments SET message='$message' WHERE cid='$cid'";
    $result= mysqli_query($conn,$sql);
    header('location:index.php');
    exit();
    } 
}
//allows to edit an existing reply
function editreply($conn){
    if(isset($_POST['editreply'])){  
    $rid=$_POST['rid'];  
    $date=$_POST['date'];
    $rmessage=$_POST['rmessage'];

    $sql="UPDATE reply SET rmessage='$rmessage' WHERE rid='$rid'";
    $result= mysqli_query($conn,$sql);
    header('location:index.php');
    exit();
   } 
}
//deletes a comment from the table
function deleteComments($conn,$user){
 	if(isset($_POST['commentDelete'])){
        $cid=$_POST['cid'];
        $sql ="DELETE FROM comments WHERE cid='$cid'";
        $result=$conn->query($sql);
        $sql2="DELETE FROM reply WHERE cid='$cid'";
        $result2=$conn->query($sql2);
        echo "<script> location.replace('index.php'); </script>";
        exit();
        
 	}
}
//deletes a reply from the table
function deletereply($conn){
  if(isset($_POST['replyDelete'])){
        $rid=$_POST['rid'];
        $sql ="DELETE FROM reply WHERE rid='$rid'";
        $result=$conn->query($sql);
        echo "<script> location.replace('index.php'); </script>";
        exit();
  }
}
//searching a comment by question or answer written on it or by username
function getsearch($conn){
   $user=$_SESSION['username'];
   $search=test($_POST['search']);
   if(strlen($search)>0){
    $sql="SELECT * FROM comments WHERE (message LIKE '%".$search."%')";
    $result=mysqli_query($conn,$sql);

    $sql5="SELECT * FROM reply WHERE (rmessage LIKE '%".$search."%')";
    $result5=mysqli_query($conn,$sql5);

    $sql4="SELECT * FROM users WHERE (username LIKE '%".$search."%')";
    $result4=mysqli_query($conn,$sql4);

    if(mysqli_num_rows($result)==0&&mysqli_num_rows($result5)==0&&mysqli_num_rows($result4)==0) echo "No Results Found!";
    else{
   while($row=$result->fetch_assoc()){

    $id=$row['username'];
    $sql2="SELECT * FROM users WHERE username='$id'";
    $result2=mysqli_query($conn,$sql2);
     if ($row2=$result2->fetch_assoc()) {
        echo "<div class='comment-box'><p>";  
        echo  "<h5>".$row2['username']."</h5>";
        echo "<span id='date'>".$row['date']."</span><br>";   
        echo "<h6>".nl2br($row['message'])."</h6>";
        echo "</p>";
       if( $user==$row2['username']){
        echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>";
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <input type='hidden' name='uid' value='".$row['username']."'>
               <input type='hidden' name='date' value='".$row['date']."'>
               <input type='hidden' name='message' value='".$row['message']."'>
               <button>Edit</button>
               </form>";       
           } else{ echo "<form class='delete-form answer' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                }
        showreply($conn,$row['cid']);                        
        echo "</div>";
        }
   }  
   while($row5=$result5->fetch_assoc()){
        $cid=$row5['cid'];
        $sql3="SELECT * FROM comments WHERE cid='$cid'";
        $result3=mysqli_query($conn,$sql3);

        if ($row3=$result3->fetch_assoc()) {
        echo "<div class='comment-box'><p>";  
        echo  "<h5>".$row3['username']."</h5>";
        echo "<span id='date'>".$row3['date']."</span><br>";   
        echo "<h6>".nl2br($row3['message'])."</h6>";
        echo "</p>";
        if( $user==$row3['username']){
        echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>";
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <input type='hidden' name='uid' value='".$row3['username']."'>
               <input type='hidden' name='date' value='".$row3['date']."'>
               <input type='hidden' name='message' value='".$row3['message']."'>
               <button>Edit</button>
               </form>";       
           } else{ echo "<form class='delete-form answer' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                }
        showreply($conn,$row3['cid']);                        
        echo "</div>";
        }
    } 
     
     while($row4=$result4->fetch_assoc()){
       $id=$row4['username'];
        $sql3="SELECT * FROM comments WHERE username='$id'";
        $result3=mysqli_query($conn,$sql3);

        if ($row3=$result3->fetch_assoc()) {
        echo "<div class='comment-box'><p>";  
        echo  "<h5>".$row3['username']."</h5>";
        echo "<span id='date'>".$row3['date']."</span><br>";   
        echo "<h6>".nl2br($row3['message'])."</h6>";
        echo "</p>";
        if( $user==$row3['username']){
        echo "<form class='delete-form' method='POST' action='".deleteComments($conn,$user)."'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <button type='submit' name='commentDelete'>Delete</button>
               </form>";
        echo "<form class='edit-form' method='POST' action='editcomment.php'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <input type='hidden' name='uid' value='".$row3['username']."'>
               <input type='hidden' name='date' value='".$row3['date']."'>
               <input type='hidden' name='message' value='".$row3['message']."'>
               <button>Edit</button>
               </form>";       
           } else{ echo "<form class='delete-form answer' method='POST' action='replycomment.php'>
               <input type='hidden' name='cid' value='".$row3['cid']."'>
               <button type='submit' name='replybutton'>Answer</button>
               </form>";
                }
        showreply($conn,$row3['cid']);                        
        echo "</div>";
        }
      }

    } 
   }
}
//avoid user from corrupting data input
function test($data){
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);

  return $data;
}

?>
<!--to hide or show replies on click-->
<script type="text/javascript">
  function myFunction(cid) {
    var x = document.getElementById("mmm"+cid);
     if(x.style.display === "none" ) {
        x.style.display ="block" ;
    } else {
        x.style.display = "none";
    }
   } 
</script>
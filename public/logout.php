<?php  
 require 'assets/info.php';
  
  // Unsets the session value and redirect to Login page
   if(isset($_SESSION['UserID']))
   {
	   unset($_SESSION['UserID']); 
   }
   header('Location : index.php');	   
  
?>
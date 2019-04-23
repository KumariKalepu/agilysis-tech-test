<?php 
  require 'assets/info.php';
  
  //********* Form input validation begin *************//
    
   $eMailError = '';
   $passwordError = '';
   $EmailAddress  = '';
   $firstname    ='';
   $firstnameError = '';
   $surname      ='';
   $surnameError ='';
   $confPasswordError  ='';
   
   if(isset($_POST['submit']))
   {
       $isError = false;	// if validation fails, isError sets to true
       $isValiedForm = false;	
       $EmailAddress = trim($_POST['EmailAddress']);  
	   $firstname    = trim($_POST['firstname']);
	   $surname      = trim($_POST['surname']);
	   
	   if(empty($surname))
	   {
		  $surnameError = 'Required';
		  $isError = true;				   
	   }
	   if(empty($firstname))
	   {
		  $firstnameError = 'Required';
		  $isError = true;				   
	   }
       if(empty($EmailAddress))
       {
           $eMailError = 'Please enter Valid eMail id';
           $isError = true;			
       }
	   elseif(!filter_var($EmailAddress, FILTER_VALIDATE_EMAIL))
	   {
		   $eMailError = 'Invalid email format';
           $isError = true;		
		   
	   }
       if(empty(trim($_POST['password'])))
       {
           $passwordError = 'Please enter Password';
           $isError = true;			
       } 
       elseif(!isValidPassword(trim($_POST['password'])))
	   {
		   $passwordError = 'Password Must be atleast 6 charcters';
           $isError = true;			   
	   }
	   if(empty(trim($_POST['confPassword'])))
       {
           $confPasswordError = 'Enter Password';
           $isError = true;			
       } 
       elseif(!isValidPassword(trim($_POST['confPassword'])))
	   {
		   $confPasswordError = 'Password Must be atleast 6 charcters';
           $isError = true;			   
	   }
	   if(trim($_POST['password'])!=trim($_POST['confPassword']))
	   {
		   $confPasswordError = 'Passwords do not match';
           $isError = true;			   
	   }
	   //********* Form input validation ends *************//
	   
	 if(!$isError)  // Validation successful, connect to database
	 {
		 $dbObj = new Database();		   
         $connection = $dbObj->getConnection();
		 if(!$connection->connect_errno)
		 {
			 $userObj = new User();
			 $userObj->userID    = $EmailAddress;
			 $userObj->password  = $_POST['password'];
			 $userObj->fName     = $firstname;
			 $userObj->sName     = $surname;
			 
			//Insert/Set User Registration details into Database and check for error code    
			//if successful, store UserId in Session and redirect page to dashbord			
			if(!$dbObj->setUserDetails($connection,$userObj)) 
			{
				$_SESSION['UserID'] = $EmailAddress;	
				
				header('Location : home/index.php?value=21'); // sending default value of 21 to the fibonacci API (dashboard page)	
			}
			else // user details insert not successful
			{
				$eMailError = "Try Diffrent UserID";
			}		
		 }		  
	     $connection->close();	  
	 }	   
   }
   
   // Password validation is same for both password field and confirm password field
   function isValidPassword($password)
   {
	   if(strlen($password)>=6) 
		   return true;
	   else
		   return false;
   }

?>
<!doctype html>
<html lang="en">
   <head>
   <   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>MyWebApp - Register</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="css/register.css" />
   </head>
   <body>
      <div class="sidenav">
            <div class="reg-main-text">
               <h2>Application<br> Registration Page</h2>
               <p>Register to access your dashboard.</p>
            </div>
         </div>
         <div class="main">
            <div class="col-md-6 col-sm-12">
               <div class="reg-form">
                  <form action="?" method="post">
                     <div class="form-group">
                        <label for="firstname">First name</label>
                        <input type="text" id="firstname" class="form-control" placeholder="First name" name="firstname" value='<?php echo htmlentities($firstname)?>'>
						<small class="text-danger" ><?php echo $firstnameError ?></small>
                     </div>
                     <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" id="surname" class="form-control" placeholder="Surname" name = "surname" value='<?php echo htmlentities($surname)?>'>
						<small class="text-danger" ><?php echo $surnameError ?></small>
                     </div>
                     <div class="form-group">
                        <label for="emailAddress">Email Address</label>
                        <input type="text" id="emailAddress" class="form-control" placeholder="Email Address" name="EmailAddress" value='<?php echo htmlentities($EmailAddress)?>'>
						<small class="text-danger" ><?php echo $eMailError ?></small>
                     </div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off" name="password" >
						<small class="text-danger" ><?php echo $passwordError ?></small>
                     </div>
                     <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" autocomplete="off" name="confPassword">
						<small class="text-danger" ><?php echo $confPasswordError ?></small>
                     </div>
                     <a href="index.php" class="btn btn-secondary">Cancel</a>
                     <button  name="submit" type="submit" class="btn btn-black">Register</button>
                  </form>
               </div>
            </div>
         </div>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="js/register.js"></script>
   </body>
</html>
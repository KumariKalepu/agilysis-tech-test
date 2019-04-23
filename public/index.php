<?php
   
   require 'assets/info.php';
   
   $eMailError = '';
   $passwordError = '';
   $EmailAddress  = '';
   if(isset($_POST['submit']))
   {
       $isError = false;	// if validation fails, isError sets to true
       $isValiedForm = false;	
       $EmailAddress = trim($_POST['EmailAddress']);   
	   
	   //********* Form input validation begin *************//
       if(empty($EmailAddress))
       {
           $eMailError = 'Enter Valied eMail id';
           $isError = true;			
       }
	   elseif(!filter_var($EmailAddress, FILTER_VALIDATE_EMAIL))
	   {
		   $eMailError = 'Invalid email format';
           $isError = true;		
	   }
       if(empty($_POST['password']))
       {
           $passwordError = 'Enter Password';
           $isError = true;			
       }  
	   //********* Form input validation ends *************//
	   
       if(!$isError) // Validation successful, connect to database
	   {
		   $dbObj = new Database();		   
		   $connection = $dbObj->getConnection();		   
		   if(!$connection->connect_errno)
		  {
			try
			{
				 $userObj = $dbObj->getUserDetails($connection,$EmailAddress);	           
				 if(($userObj->userID == $EmailAddress) and ($userObj->password == $_POST['password']) and (!is_null($userObj)))
				 {
					$_SESSION['UserID'] = $EmailAddress;
					header('Location : home/index.php?value=21'); // sending default value of 21 to the fibonacci API(dashboard page)
				 }
				 else
				 {
					$passwordError = "Invalid Username or Password";
				 }
			}
			catch(Exception $e)
			{
				$passwordError = "User doesnot exist";
			}
		  }	              
		  $connection->close();
	   }		  
		   
   }
  
   
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>MyWebApp - Login</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="css/index.css">
   </head>
   <body>
         <div class="sidenav">
               <div class="login-main-text">
                  <h2>Application<br> Login Page</h2>
                  <p>Login or register from here to access your dashboard.</p>
               </div>
            </div>
            <div class="main">
               <div class="col-md-6 col-sm-12">
                  <div class="login-form">
                     <form action="?" method="post">
                        <div class="form-group">
                           <label for="EmailAddress">Email Address</label>
                           <input name="EmailAddress" type="text" id="EmailAddress" class="form-control" placeholder="Email Address" value='<?php echo htmlentities($EmailAddress)?>' >
						   <small class="text-danger" ><?php echo $eMailError ?></small>
                        </div>
                        <div class="form-group">
                           <label>Password</label>
                           <input name="password" type="password" id="Password" class="form-control" placeholder="Password" autocomplete="off" >
						   <small class="text-danger" ><?php echo $passwordError ?></small>
                        </div>
                        <button name="submit" type="submit" class="btn btn-black">Login</button>
                        <a href="register.php" class="btn btn-secondary">Register</a>
                     </form>
                  </div>
               </div>
            </div>			
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="js/index.js"></script>
   </body>
</html>
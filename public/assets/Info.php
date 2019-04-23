<?php
// common functions and libraries

session_start();

// Class specification for user details
class User
{
	public $userID;
	public $password;
    public $fName;
    public $sName;	
}

// This Class provides functions for all database related activities
class Database
{
  // Class specification for Database details
   private $dbUserName = "user-KK";
   private $dbPassword = "kalepu";
   private $dbServer   = "agilysis-mysql.c0opgefmbbwm.eu-west-1.rds.amazonaws.com:3306"; 
   private $dbName     = "agilysisKK";
      
	
   public function getConnection()
   {
         return new mysqli($this->dbServer, $this->dbUserName, $this->dbPassword, $this->dbName);    
   }
   
   // This function retrieves UserID and password to supplied UserID and connection object
   public function getUserDetails($connection,$userID) 
   {
	   $userObj  = new User();
	   $query = "select userId,pword from user where userID= ?"	;
       $statementObj = $connection->prepare($query);
	   	      
		   $statementObj->bind_param("s", $userID);
		   $statementObj->execute();
		   $statementObj->bind_result($retuserID,$retpassword);
		   $statementObj->store_result();
		   
		   if ($statementObj->num_rows() > 0) 
		   {
			   while ($statementObj->fetch()) 
			   {
					$userObj->userID = $retuserID;
					$userObj->password=$retpassword;   
			   }
		   } 
	   
	   return $userObj;  
	   
    } 

  // This function inserts user details from supplied user object specified database connection and returns error code (0 if success else >0)
  public function setUserDetails($connection,$userObj) 
   {	   
	   $query = "insert into user (userId,pword,sname,fname) values  (?,?,?,?)";
       $statementObj = $connection->prepare($query);   	   
	   $statementObj->bind_param("ssss", $userID,$password,$sName,$fName);
	   
	   $userID  =$userObj->userID;
	   $password=$userObj->password;
	   $fName   =$userObj->fName;
	   $sName   =$userObj->sName;
	   
       $statementObj->execute();	   
	   
	   $errStat=$statementObj->errno;	 
	  
	   $statementObj->close();	 
	   
	   return $errStat;
    }      	
}

?>
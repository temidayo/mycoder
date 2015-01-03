<?php
class User extends DataObjectParent{
	var $username;
	var $pass;
	var $firstName;
	var $otherNames;
	var $email;
	var $phone;
	var $address;
	var $city;
	var $state;
	var $country;
	var $signupDate;
	
	function User(){
		parent::DataObjectParent(); // run the parent class's constructor
		$this->primaryKey = 'userid';
		$this->tableName = 'user';
		$this->className = 'User';
		$this->error=0;
		//echo("Inside User class -> table: $this->tableName ");
				
	}//function User()

function isValid($string)
{
	$valid_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMLOPQRSTUVWXYZ0123456789._";
	$first3_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMLOPQRSTUVWXYZ";
	
	$dotcount = 0;
	if (!isset($string))//check is string is not empty
		return false;
	if (strlen($string) < 5 || strlen($string) > 25 )//check is string is more than 5 chars.
		return false;
	//check first 3
	$first3 = substr($string,0,3);//start from location 0 and return first 3 chars
	for($i= 0; $i < strlen($first3); $i++)
	{
	   $char = substr($string,$i,1);
	   //check validity of xter
	   if (strpos($first3_chars,$char) === false)
	   {
	   //if it is not in defined $first3_chars it is invalid
	   return false;
	   }
	}//for
	
	//check validity of eash character
	for($i= 0; $i < strlen($string); $i++)
	{
	   $char = substr($string,$i,1);
	   if ($char==".")
	   {
	   		$dotcount += 1;
		    if ($dotcount > 1)
				return false;
		}			
	   	   //count underscores
	    if ($char=="_")
	   {
	   		$us_count += 1; //underscore count
		    if ($us_count > 1)
				return false;
		}
	   
	   //check validity of xter
	   if (strpos($valid_chars,$char) === false)
	   {
	   //if it is not in defined $valid_chars it is invalid
	   return false;
	   }
	}//for
//if all test is satisfied then
return true;		
}//function isValid($string)


	function setUsername($username){
		if ($this->isValid($username)){ 
		 //echo "$username is valid";
		 $this->username = strtolower($username);
		 return true;	
		//echo " this->username = $this->username";
		}//if isValid($username)
		else{
			$this->error += 1;
			$this->error_msg .="<br />Username is invalid.";							
			return false;
		}
	}//function setUsername()
	
	function setEmail($email){
		if (!preg_match('/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i',$email)){
			$this->error += 1;
			$this->error_msg .="<br />Email address is invalid.";
			return false;
		}
		else{
			$this->email = $email;
			$this->data['email'] = $email;
			$this->changedFields[] = 'email';
			return true;
		}
	} //function setEmail($email)

	function setPass($password,$cpassword){
		if (empty($password)){
			$this->error += 1;
			$this->error_msg .="<br />Field with (*) are required.";	
			return false;
		}
		
		if (strcmp($password,$cpassword) == 0){
			$this->pass = $password;
			$this->data['pass'] = $password;
			$this->changedFields[] = 'pass';
			return true;
		}
		else{	
		 
		 	$this->error += 1;
			$this->error_msg .="<br />Password and confirm password do not match.";	
			return false;
		}
	}//function setPassword()
	
	function setFirstName($firstName){
		$this->firstName = ucfirst(strtolower($firstName));
		$this->data['firstName'] = ucfirst(strtolower($firstName));
		$this->changedFields[] = 'firstName';
	}//	function setFirstName($firstName)
	
	
	function setOtherNames($otherNames){
		$this->otherNames = ucfirst(strtolower($otherNames));
		$this->data['otherNames'] = ucfirst(strtolower($otherNames));
		$this->changedFields[] = 'otherNames';
	}//	function setFirstName($firstName)
	
	function setPhone($phone){
		$this->phone = ucfirst(strtolower($phone));
		$this->data['phone'] = ucfirst(strtolower($phone));
		$this->changedFields[] = 'phone';
	}//	function setPhone($phone)
	
	function setAddress($address){
		$this->address = ucfirst(strtolower($address));
		$this->data['address'] = ucwords(strtolower($address));
		$this->changedFields[] = 'address';
	}//	function setAddress($address)
	
	function setCity($city){
		$this->city = ucfirst(strtolower($city));
		$this->data['city'] = ucwords(strtolower($city));
		$this->changedFields[] = 'city';
	}//setCity($city)
	
	function setState($state){
		$this->state = ucfirst(strtolower($state));
		$this->data['address'] = ucfirst(strtolower($address));
		$this->changedFields[] = 'address';
	}
	
	function setCountry($country){
		$this->country = ucfirst(strtolower($country));
		$this->data['country'] = ucfirst(strtolower($country));
		$this->changedFields[] = 'address';
	}
	
// ...

}//class User
?>
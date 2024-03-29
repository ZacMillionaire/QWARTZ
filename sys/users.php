<?php

class Users extends System {


	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();

	} // End Class Constructor

	/*
		Handles program flow for logging in a user.

		Pre:
			- $postData contains a username and password
			- a valid cookie has not been set on this machine
		Post:
			- returns true on successful login and cookie generation
			- returns error in all other cases.
	 */
	public function LogInUser($postData) {

		// Trim whitespace, we don't worry about sanitization, PDO
		// will be covering that
		$username = trim($postData["username"]);
		$password = trim($postData["password"]);

		// Lazy check to see if we got a username and password.
		// Validation should be client side for this, but server side
		// validation is just as important
		if(!$username){
			return array("error" => "No username given");
		}
		if(!$password){
			return array("error" => "No password given");
		}

		// Again, we shouldn't reach this point, but just incase a user is
		// trying to be clever, stop them from logging in again from
		// the same machine
		if(self::CheckIsLoggedIn()){
			return array("error" => "You are already logged in");
		}

		if(self::UsernameExists($username)) {
			if(self::ValidatePassword($username, $password)) {
				if(!self::GenerateUserCookie($username)) {
					return array("error" => "System Error: A rogue wizard has entered the system");
				} // End if(GenerateUserCookie)
			} else {
				return array("error" => "Incorrect username or password");
			} // End if(ValidatePassword)
		} else {
			return array("error" => "Incorrect username or password");
		} // End if(UsernameExists)

		return true;

	} // End LogInUser


	/*
		Checks to see if a loginHash cookie exists, then checks if the hash contained
		is a valid login.
		If the cookie does not exist, or the loginHash stored in the database
		does not match the one stored in the client cookie, the login script will continue.

		Pre:
			- a cookie with a loginHash value exists
	 */
	public function CheckIsLoggedIn() {

		if(isset($_COOKIE["loginHash"])){	
			return self::CheckValidCookie($_COOKIE["loginHash"]);
		}

		return false;

	} // End CheckIsLoggedIn

	/*
	

	 */
	public function LogUserOut() {

		if(isset($_COOKIE["loginHash"]) && self::CheckValidCookie($_COOKIE["loginHash"])) {

			$sql = "DELETE FROM `users_loggedin` WHERE `cookieHash` = :hash";
			$params = array(
				"hash" => $_COOKIE["loginHash"]
			);

			$result = $this->DatabaseSystem->dbQuery($sql,$params);

		} else {

			echo "user is not logged in at all";

		}

	} // End LogUserOut


	/*
		Checks to see if the given login hash matches a value in the database.

		Pre:
			- a cookie exists with loginHash, regardless of value
			- the cookie belongs to our domain
	 */
	private function CheckValidCookie($cookieHash) {

		$sql = "SELECT `cookieHash` FROM `users_loggedin` WHERE `cookieHash` = :hash";
		$params = array("hash"=>$cookieHash);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		if($result){
			return true;
		}

		return false;

	} // End CheckValidCookie


	/*
		Searches the database for a given username. Returns false if the username, and by extention
		the user, does not exist.

		Pre:
			- $username is not null or empty
	 */
	private function UsernameExists($username){

		$sql = "SELECT `username` FROM `users` WHERE `username` = :username";
		$params = array(
			"username" => $username
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		if($result) {
			return true;
		}
		return false;

	} // End UsernameExists


	/*
		Validates the password given against the one stored with a user.

		Pre:
			- the username is valid
			- the password is not null or empty
	 */
	private function ValidatePassword($username, $password) {

		// Get the stored hash values for the password and passwordSalt associated 
		// with a given username
		$query = "SELECT `password`,`passwordSalt` FROM `users` WHERE `username` = :username";
		$params = array(
			"username" => trim($username)
		);

		$result = $this->DatabaseSystem->dbQuery($query,$params);
		$result = $result[0]; // PDO at it's finest

		// Hash the password we received from POST
		$inputPasswordHash = hash("sha512", $password);
		// Has the above password with the hashed salt string concatenated at the end
		$passwordHashed = hash("sha512",$inputPasswordHash.$result["passwordSalt"]);

		if($passwordHashed === $result["password"]) {
			return true;
		} else {
			return false;
		} // End if(password matched database)

	} // End ValidatePassword


	/*
		Generates a loginHash for the user based off their username, inserts it into the database,
		then creates a clientside cookie.

		Pre:
			- login process was successful
		Post:
			- Users machine now has a cookie containing an identifying hash string

	 */
	private function GenerateUserCookie($username) {

		$cookieHash = hash("sha512",time().$username);

		$sql = "REPLACE INTO `users_loggedin`
				(
					`userID`,
					`cookieHash`,
					`login_timestamp`
				) VALUES (
					(
						SELECT `userID`
						FROM `users`
						WHERE `username` = :username
					),
					:cookieHash,
					NOW()
				);";

		$params = array(
			"username" => $username,
			"cookieHash" => $cookieHash
		);

		if($this->DatabaseSystem->dbInsert($sql,$params)) {

			// 1 week from right now. (curr_time + (day in seconds * days))
			$timeToExpire = time() + (86400 * 7);

			setcookie(
				"loginHash",
				$cookieHash,$timeToExpire,
				$this->SystemSettings["dir"],
				$this->SystemSettings["host"]
			);

			return true;

		} else {

			return false;

		} // End if(successful query)

	} // End GenerateUserCookie


	/*
	
		Gets the corresponding userID given the cookieHash from a cookie

		Pre:
			- User is logged in

	 */
	public function GetUserIDFromHash($cookieHash) {

		$sql = "SELECT `userID` FROM `users_loggedin` WHERE `cookieHash` = :hash";
		$params = array(
			"hash" => $cookieHash
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		if($result){
			return $result[0]["userID"];	
		}

	} // End GetUserIDFromHash


	/*
		Gets the profile data given an ID

		Pre:
			- the ID is a valid userID
	 */
	public function GetUserProfile($userID) {

		$sql = "SELECT * FROM `profiles` WHERE `userID` = :userID";
		$params = array(
			"userID" => $userID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		if($result){

			// profile picture is nullable, so if it is, set the value to the default
			$result[0]["profilePicture"] = ($result[0]["profilePicture"] == null) ? "default_profile.png" : $result[0]["profilePicture"];

			return $result[0];		
		}

	} // End GetUserProfile


	/*
		Returns a list of user information for all currently logged in users

		Pre:
			- the users are all presumably sitting idle, completely oblivious to the fact they are logged in
	 */
	public function GetLoggedInUserList() {

		$sql = "SELECT `userID` FROM `users_loggedin`";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$loggedInUsers = array();

		$i = 0;
		foreach ($result as $key => $value) {
			$loggedInUsers[$i] = self::GetUserProfile($value["userID"]);
			$i++;
		}
		
		return $loggedInUsers;


		/*
		if($result){

			// profile picture is nullable, so if it is, set the value to the default
			$result[0]["profilePicture"] = ($result[0]["profilePicture"] == null) ? "default_profile.png" : $result[0]["profilePicture"];

			return $result[0];		
		}
		*/

	} // end GetLoggedInUserList

} // End Class Users

?>
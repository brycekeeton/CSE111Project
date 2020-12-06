<?php

	// authenticate a user / $permissions can be 'Admin' (things only admins can do), 'Any' (anyone can do it)
	function authenticateUser($username, $password, $permissions, $path){
		$location = $path;
		$db = new SQLite3($location);
		$sql = "SELECT * FROM Users WHERE (u_username = '" . $username . "' and u_password = '" . $password . "') or (u_type = 'Admin');";
		$result = $db->query($sql);
		
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			if(isset($row['u_username']) && ($username == $row['u_username'])){
				if($password != $row['u_password']){
					echo("You messed up your password<br>");
					return false;
				}
				if(($permissions != 'Admin') || $row['u_type'] == 'Admin'){
					//echo("You can do this<br>");
					//echo($row['u_username'] . "<br>");
					return true;
				}
				else{
					echo("This is an admin-only function<br>");
					return false;
				}
			}
		}
		
		echo("Sorry you're not a User yet. Try signing up first, kid.<br>");
		unset($db);
		return false;
	}
	
	
	// strip data so that malicious code cannot be input
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


?>
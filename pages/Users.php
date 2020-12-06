<?php
	include "helper.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		
		switch($_POST['queryType']){
			case "Add User":
				addinUsers($_POST['username'], $_POST['password']);
				break;
			case "View Users":
				viewUsers();
				break;
			case "Delete User":
				deleteUser($_POST['usernameToDelete'], $_POST['usernameOfDeleter'], $_POST['passwordOfDeleter']);
				break;
		}
	}
	
	/*------------------------------------------USER DATA----------------------------------------------*/

	function addinUsers($username, $password){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Users VALUES('" . $username . "', '" . $password . "', 'Member');";
		$result = $db->query($sql);
		echo("Added " . $username . " to the database! Thanks for joining!");
		unset($db);
	}
	
	function viewUsers(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT u_username FROM Users;";
		$result = $db->query($sql);
		
		echo("<div>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteUser($username, $usernameTwo, $password){
		
		// check to see if user can do this
		$location = '../data.sqlite';
		
		$authenticate = authenticateUser($usernameTwo, $password, 'Any', $location);
		if($authenticate == true){
			if(($username == $usernameTwo || (authenticateUser($usernameTwo, $password, 'Admin', $location)))){
				//echo("valid deletion<br>");
				$db = new SQLite3($location);
				
				$sql = "DELETE FROM Users WHERE u_username = '" . $username . "';";
				$result = $db->query($sql);
				echo("Deleted user from database, sorry to see you go :( <br>");
				
				unset($db);
			}
			else{
				echo("c'mon kid did you really think you would be able to delete someone else's account?<br>");
			}
		}
	}


?>

<html>
	<head>
		<title>Users Page</title>
		
		<style>
			div {
				height: 200px;
				width: 500px;
				overflow-y: auto;
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<hr>
		<form method="post"><b>View Users:</b> <input type="submit" name="queryType" value="View Users"></form>
		<b>Sign Up:</b>
		<form method = "post">
			Username: <input type="text" name="username"> <br>
			Password: <input type="password" name="password"> <br>
			<input type="submit" name="queryType" value="Add User">
		</form>
		<b>Kill Someone:</b>
		<form method = "post">
			Their Username: <input type="text" name="usernameToDelete"> <br>
			Your Username: <input type="text" name="usernameOfDeleter"> <br>
			Your Password: <input type="password" name="passwordOfDeleter"> <br>
			<input type="submit" name="queryType" value="Delete User">
		</form>
		
		[<a href="../index.php">Home Page</a>]
	</body>
</html>





















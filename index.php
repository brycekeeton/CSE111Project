<?php
	$location = 'data.sqlite';
	
	//open database
	
	
	// parse user request
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$json_string = json_encode($_POST);
		
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		
		switch($_POST['queryType']){
			case "Add Game":
				$release = $_POST['gameYear'] . "-" . $_POST['gameMonth'] . "-" . $_POST['gameDay'];
				addGameToDatabase($_POST['gameName'], $_POST['gameDeveloper'], $_POST['gamePlatform'], $_POST['gameGenre'], $release);
				break;
			case "View Games":
				viewGamesInDatabase();
				break;
			case "Delete Game":
				deleteGameFromDatabase($_POST['gameID']);
				break;
		}
	}
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// sqlite queries
	function addGameToDatabase($name, $developer, $platform, $genre, $release){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO vgData SELECT theMax + 1, '" . $name . "', '" . $developer . "', '" . $platform . "', '" . $genre . "', 'Rating', '" . $release . "' FROM (SELECT max(g_gameID) as theMax FROM vgData);";
		$result = $db->query($sql);
		echo("Added " . $name . " to the database!");
		unset($db);
	}
	
	function viewGamesInDatabase(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT g_gameID, g_name FROM vgData;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['g_gameID'] . ": " . $row['g_name'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteGameFromDatabase($gameID){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM vgData WHERE g_gameID = " . $gameID . ";";
		$result = $db->query($sql);
		echo("Deleted game from database <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/

	function addinUsers($username, $password){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Users '" . $username . "', '" . $password . "'";
		$result = $db->query($sql);
		echo("Added " . $username . " to the database! Thanks for joining!");
		unset($db);
	}
	
	function viewUsers(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT u_username FROM Users;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteUser($username){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Users WHERE u_username = " . $username . ";";
		$result = $db->query($sql);
		echo("Deleted user from database, sorry to see you go :( <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/
	
	function addinReviews($gameID, $rating, $comments){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Review '" . $gameID . "', '" . $rating . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your review to the database!");
		unset($db);
	}
	
	function viewReviews(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT r_reviewID, r_gameID, r_rating, r_date, r_comments FROM Review;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteReview($reviewID){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Review WHERE r_reviewID = " . $reviewID . ";";
		$result = $db->query($sql);
		echo("Deleted review from database <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/

	function addinRecommendation($gameID, $status, $comments){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Recommendation '" . $gameID . "', '" . $status . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your recommendation to the database!");
		unset($db);
	}
	
	function viewRecommended(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT u_username FROM Users;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteRecommendation($recID){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Recommendation WHERE rc_recID = " . $recID . ";";
		$result = $db->query($sql);
		echo("Deleted user from database <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/

	function addinGameplay($gameID, $username, $comments){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Gameplay '" . $gameID . "', '" . $username . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your gameplay to the database!");
		unset($db);
	}
	
	function viewGameplay(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT u_username FROM Users;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteGameplay($gameplayID){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Gameplay WHERE gp_id = " . $gameplayID . ";";
		$result = $db->query($sql);
		echo("Deleted gameplay from database <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/
	
	function addinPhotos($gameID, $username, $comments){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Pictures '" . $gameID . "', '" . $username . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your picture to the database!");
		unset($db);
	}
	
	function viewPhotos(){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT u_username FROM Users;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['u_username'] . "<br>");
		}
		echo("</div>");
	}
	
	function deletePhoto($imageID){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Pictures WHERE p_imageID = " . $imageID . ";";
		$result = $db->query($sql);
		echo("Deleted user from database<br>");
		unset($db);
	}
	
	// display all users
	/*$db = new SQLite3($location);
	$sql = "SELECT * FROM Users";
	$result = $db->query($sql);
	echo '<br><br>';
	while ($row = $result->fetchArray(SQLITE3_ASSOC)){
	  echo $row['u_username'] . ': ' . $row['u_type'] . '<br/>';
	}
	echo '<br><br>';*/
	
	
	// close database
	unset($db);
?>

<html>
	<head>
		<title>Carlos and Bryce's Game Rating Site</title>
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
		<form method="post"><b>View Games:</b> <input type="submit" name="queryType" value="View Games"></form>
		<b>Add a Game:</b>
		<form method = "post">
			Name: <input type="text" name="gameName"> <br>
			Developer: <input type="text" name="gameDeveloper"> <br>
			Platform (comma separated list): <input type="text" name="gamePlatform"> <br>
			Genre (comma separated list): <input type="text" name="gameGenre"> <br>
			Release Date: Year <input type="text" name="gameYear"> Month <input type="text" name="gameMonth"> Day <input type="text" name="gameDay">
			<input type="submit" name="queryType" value="Add Game">
		</form>
		<b>Delete Game</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID">
			<input type="submit" name="queryType" value="Delete Game">
		</form>
		<hr>
		<form method="post"><b>View Users:</b> <input type="submit" name="queryType" value="View Users"></form>
		<b>Add User:</b>
		<form method = "post">
			Username: <input type="text" name="username"> <br>
			Password: <input type="password" name="password"> <br>
			<input type="submit" name="queryType" value="Add User">
		</form>
		<b>Delete User</b>
		<form method = "post">
			Username: <input type="text" name="username">
			<input type="submit" name="queryType" value="Delete User">
		</form>
		<hr>
		<form method="post"><b>See Other Reviews:</b> <input type="submit" name="queryType" value="See Reviews"></form>
		<b>Add A Review!:</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"> <br>
			<label for="rating">Rating:</label>
			<select id="rating">
  			<option value="1">1</option>
 			<option value="2">2</option>
 			<option value="3">3</option>
 			<option value="4">4</option>
			<option value="5">5</option>
			</select> <br>
			Comments: <input type="text" name="comments">
			<input type="submit" name="queryType" value="Add Review">
		</form>
		<b>Delete Your Review</b>
		<form method = "post">
			Review ID: <input type="text" name="Review">
			<input type="submit" name="queryType" value="Delete Review">
		</form>
		<hr>
		<form method="post"><b>See Recommendations:</b> <input type="submit" name="queryType" value="See Recommendations"></form>
		<b>Add A Recommendation!:</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"> <br>
			<label for="status">Status of Game Reviewing?:</label>
			<select id="status">
  			<option value="1">Unplayed</option>
 			<option value="2">In Progress</option>
 			<option value="3">Finished</option>
			</select> <br>
			Comments: <input type="text" name="comments">
			<input type="submit" name="queryType" value="Add Recommendation">
		</form>
		<b>Delete Your Recommendation</b>
		<form method = "post">
			Recommendation ID: <input type="text" name="recommendation">
			<input type="submit" name="queryType" value="Delete recommendation">
		</form>
		<hr>
		<form method="post"><b>See Cool Gameplay!</b> <input type="submit" name="queryType" value="See Gameplay"></form>
		<b>Add Your Gameplay!:</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"> <br>
			Your Username: <input type="text" name="username"> <br>
			Comments: <input type="text" name="comments">
			<input type="submit" name="queryType" value="Add Gameplay">
		</form>
		<b>Delete Your Gameplay</b>
		<form method = "post">
			Gameplay ID: <input type="text" name="gameplay">
			<input type="submit" name="queryType" value="Delete Gameplay">
		</form>
		<hr>
		<form method="post"><b>Check Out Photos:</b> <input type="submit" name="queryType" value="See Pictures"></form>
		<b>Add A Photo:</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"> <br>
			Your Username: <input type="text" name="username"> <br>
			Comments: <input type="text" name="comments"> <br>
			<input type="submit" name="queryType" value="Add Photo">
		</form>
		<b></b>
		<form method = "post">
			Picture ID: <input type="text" name="photo">
			<input type="submit" name="queryType" value="Delete Photo">
		</form>
	</body>
</html>

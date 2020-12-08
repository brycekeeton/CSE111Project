<?php
	include "helper.php";
	$location = '../data.sqlite';
	
	// parse user request
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		
		switch($_POST['queryType']){
			case "Add Game":
				//$release = $_POST['gameYear'] . "-" . $_POST['gameMonth'] . "-" . $_POST['gameDay'];
				addGameToDatabase($_POST['gameName'], $_POST['gameDeveloper'], $_POST['gamePlatform'], $_POST['gameGenre'], $_POST['gameDate']);
				break;
			case "View Games":
				viewGamesInDatabase();
				break;
			case "Search":
				searchForGame($_POST['gameName']);
				break;
			case "Delete Game":
				deleteGameFromDatabase($_POST['gameID'], $_POST['username'], $_POST['password']);
				break;
			case "Add Review":
				addinReviews($_POST['gameName'], $_POST['rating'], $_POST['comments'], $_POST['username'], $_POST['password']);
				break;
			case "Delete Review":
				deleteReview($_POST['Review'], $_POST['username'], $_POST['password']);
				break;
			case "Add Gameplay":
				addinGameplay($_POST['gameID'], $_POST['username'], $_POST['comments']);
				break;
			case "See Gameplay":
				viewGameplay();
				break;
			case "Delete Gameplay":
				deleteGameplay($_POST['gameplay']);
				break;
			case "Add Photo":
				addinPhotos($_POST['gameID'], $_POST['username'], $_POST['comments']);
				break;
			case "See Pictures":
				viewPhotos();
				break;
			case "Delete Photo":
				deletePhoto($_POST['photo']);
				break;
			case "See Reviews":
				viewReviews();
				break;
		}
	}
	
	// sqlite queries
	function addGameToDatabase($name, $developer, $platform, $genre, $release){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO vgData SELECT theMax + 1, '" . $name . "', '" . $developer . "', '" . $platform . "', '" . $genre . "', 'Rating', '" . $release . "' FROM (SELECT max(g_gameID) as theMax FROM vgData);";
		$result = $db->query($sql);
		echo("Added " . $name . " to the database!");
		unset($db);
	}
	
	function viewGamesInDatabase(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT g_gameID, g_name FROM vgData;";
		$result = $db->query($sql);
		
		echo("<div>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['g_gameID'] . ": " . $row['g_name'] . "<br>");
		}
		echo("</div>");
	}
	
	function searchForGame($name){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT * FROM vgData WHERE g_name = '".$name."' GROUP BY g_name;";
		$sqlRating = "SELECT avg(r_rating) as avrating FROM vgData, Review WHERE r_gameID = g_gameID and g_name = '".$name."' GROUP BY g_name;";
		$sqlReviews = "SELECT r_reviewID, r_date, r_rating, r_comments FROM Review, vgData WHERE r_gameID = g_gameID and g_name = '".$name."' ORDER BY r_date desc;";
		$sqlAuthors = "SELECT r_reviewID, ur_username FROM Review, vgData, User_Review WHERE r_reviewID = ur_reviewID and r_gameID = g_gameID and g_name = '".$name."';";
		
		$result = $db->query($sql);
		$ratingResult = $db->query($sqlRating);
		$reviewsResult = $db->query($sqlReviews);
		$authorResult = $db->query($sqlAuthors);
		
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo("<br>" . $row['g_gameID'] . ": <b>" . $row['g_name'] . "</b><br><u>Average Rating:</u> ");
			while($rowR = $ratingResult->fetchArray(SQLITE3_ASSOC)){ echo($rowR['avrating']); 
			}
			echo("<br><u>Release Date:</u> " . $row['g_releasedate'] . " <u>Developer:</u> " . $row['g_developer'] . "<br><u>Platform:</u> " . $row['g_platform'] . "<br><u>Genre:</u> " . $row['g_genre'] . "<br>");
		}
		
		echo("<br>Reviews:<div>");
		while($row = $reviewsResult->fetchArray(SQLITE3_ASSOC)){
			echo("<u>" . $row['r_reviewID'] . ": ");
			while($rowA = $authorResult->fetchArray(SQLITE3_ASSOC)){
				if($rowA['r_reviewID'] == $row['r_reviewID']){
					echo($rowA['ur_username'] . "|");
				}
			}
			echo(": " . $row['r_date'] . "/ Score: <b>" . $row['r_rating'] . "</b></u><br>" . $row['r_comments'] . "<br><br>");
		}
		echo("</div>");
		
	}
	
	function deleteGameFromDatabase($gameID, $username, $password){
		$location = '../data.sqlite';
		
		if((authenticateUser($username, $password, 'Admin', '../data.sqlite')) == true){
			$db = new SQLite3($location);
			$sql = "DELETE FROM vgData WHERE g_gameID = " . $gameID . ";";
			$result = $db->query($sql);
			echo("Deleted game from database <br>");
			unset($db);
		}
	}
	
	/*------------------------------------------REVIEWS----------------------------------------------*/
	
	function addinReviews($gameName, $rating, $comments, $username, $password){
		$location = '../data.sqlite';
		
		if((authenticateUser($username, $password, 'Any', '../data.sqlite')) == true){
			$db = new SQLite3($location);
			
			$sql = "INSERT INTO Review SELECT theMax+1, gid, " . $rating . ", substr(DATETIME('now'), 0, 11), '" . $comments . "' FROM (SELECT max(r_reviewID) as theMax FROM Review), (SELECT g_gameID as gid FROM vgData WHERE g_name = '" . $gameName . "');";
			$sqlUserAdd = "INSERT INTO User_Review SELECT '" . $username . "', theMax FROM (SELECT max(r_reviewID) as theMax FROM Review);";
			
			$result = $db->query($sql);
			$resultAdd = $db->query($sqlUserAdd);
			
			echo("Added your review to the database!");
			unset($db);
		}
	}
	
	function deleteReview($reviewID, $username, $password){
		$location = '../data.sqlite';
		
		$db = new SQLite3($location);
		$sql = "SELECT ur_username FROM User_Review, Review WHERE ur_reviewID = r_reviewID and r_reviewID = '" . $reviewID . "';";
		$resultU = $db->query($sql);
		
		while($row = $resultU->fetchArray(SQLITE3_ASSOC)){
			if((authenticateUser($username, $password, 'Any', $location))){
				if(($username == $row['ur_username'] || (authenticateUser($username, $password, 'Admin', $location)))){
					
					$sql = "DELETE FROM Review WHERE r_reviewID = " . $reviewID . ";";
					$result = $db->query($sql);
					echo("Deleted review from database <br>");
				}
			}
		}
		unset($db);
		
	}

	function viewReviews(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT ur_username, r_reviewID, r_gameID, r_rating, r_date, r_comments FROM User_Review, Review WHERE ur_reviewID = r_reviewID ORDER BY r_reviewID;";
		$result = $db->query($sql);
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['ur_username'] . ": ReviewID :". $row['r_reviewID'] ." Rating :" . $row['r_rating'] . " | " . $row['r_date'] . "<br> Comments: ". $row['r_comments'] ."<br>");
		}
		echo("</div>");
	}
	
	
	/*------------------------------------------DIVIDER----------------------------------------------*/

	function addinGameplay($gameID, $username, $comments){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Gameplay '" . $gameID . "', '" . $username . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your gameplay to the database!");
		unset($db);
	}
	//'" . $name . "'
// "INSERT INTO vgData SELECT theMax + 1, '" . $name . "', '" . $developer . "', '" . $platform . "', '" . $genre . "', 'Rating', '" . $release . "' FROM (SELECT max(g_gameID) as theMax FROM vgData);";
	
	function viewGameplay(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT * FROM Gameplay;";
		$result = $db->query($sql);
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo("Game ID: " . $row['gp_gameID'] . " | " .  $row['gp_id'] . " | " . $row['gp_username'] . " | " . $row['gp_comments'] ."<br>");
		}
		echo("</div>");
	}
	
	function deleteGameplay($gameplayID){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Gameplay WHERE gp_id = " . $gameplayID . ";";
		$result = $db->query($sql);
		echo("Deleted gameplay from database <br>");
		unset($db);
	}

	/*------------------------------------------DIVIDER----------------------------------------------*/
	
	function addinPhotos($gameID, $username, $comments){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Pictures '" . $gameID . "', '" . $username . "', '" . $comments . "'";
		$result = $db->query($sql);
		echo("Added your picture to the database!");
		unset($db);
	}
	
	function viewPhotos(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT * FROM Pictures;";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo("Picture ID: " . $row['p_gameID'] . " | " . $row['p_imageID'] . " | " . $row['p_username'] . " | " . $row['p_comments'] . "<br>");
		}
		echo("</div>");
	}
	
	function deletePhoto($imageID){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Pictures WHERE p_imageID = " . $imageID . ";";
		$result = $db->query($sql);
		echo("Deleted picture from database<br>");
		unset($db);
	}
	
		/*------------------------------------------DIVIDER----------------------------------------------*/
		
?>

<html>
	<head>
		<title>Games Page</title>
		<style>
			div {
				height: 200px;
				width: 500px;
				overflow-y: auto;
				border: 1px solid black;
			}
			td {
				 vertical-align: top;
			}
		</style>
	</head>
	<body>
		<hr>
		<form method="post"><b>View Games:</b> <input type="submit" name="queryType" value="View Games"></form>
		<form method="post"><b>Search For Game:</b> <input type="text" name="gameName"> <input type="submit" name="queryType" value="Search"></form>
		
		<table width=800px><tr><td>
		<b>Add a Game:</b>
		<form method = "post">
			Name: <input type="text" name="gameName"> <br>
			Developer: <input type="text" name="gameDeveloper"> <br>
			Platform (comma separated list): <input type="text" name="gamePlatform"> <br>
			Genre (comma separated list): <input type="text" name="gameGenre"> <br>
			Release Date (YYYY-MM-DD): <input type="text" name="gameDate"> <br>
			<input type="submit" name="queryType" value="Add Game">
		</form></td><td>
		<b>Delete Game</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"><br>
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<input type="submit" name="queryType" value="Delete Game">
		</form></td></tr></table>
		<hr>
		<form method="post"><b>See Other Reviews:</b> <input type="submit" name="queryType" value="See Reviews"></form>
		<table width=975px><tr><td>
		<b>Add A Review!:</b>
		<form method = "post">
			Game Name: <input type="text" name="gameName"> <br>
			<label for="rating">Rating:</label>
			<select id="rating" name="rating">
  			<option value="1">1</option>
 			<option value="2">2</option>
 			<option value="3">3</option>
 			<option value="4">4</option>
			<option value="5">5</option>
			</select> <br>
			Comments: <br><textarea name="comments"></textarea><br>
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<input type="submit" name="queryType" value="Add Review">
		</form></td><td>
		<b>Delete Your Review</b>
		<form method = "post">
			Review ID: <input type="text" name="Review"><br>
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<input type="submit" name="queryType" value="Delete Review">
		</form></td></tr></table>
		<hr>
		<table width=975px><tr><td>
		<b>Contribute to a friends Review!:</b>
		<form method = "post">
			Friend's Review ID: <input type = text name = "reviewID"> <br>
			Game ID: <input type="text" name="gameID"> <br>
			<label for="rating">Rating:</label>
			<select id="rating" name="rating">
  			<option value="1">1</option>
 			<option value="2">2</option>
 			<option value="3">3</option>
 			<option value="4">4</option>
			<option value="5">5</option>
			</select> <br>
			Comments: <br><textarea name="comments"></textarea><br>
			Username: <input type="text" name="username"><br>
			<input type="submit" name="queryType" value="Contribute to Review">
		</form></td><td></table>
		
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
		[<a href="../index.php">Home Page</a>]
		
	</body>

</html>

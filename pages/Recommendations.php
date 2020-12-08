<?php
	include "helper.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		
		switch($_POST['queryType']){
			case "Add Recommendation":
				addinRecommendation($_POST['gameID'], $_POST['status'], $_POST['comments']);
				break;
			case "See Recommendations":
				viewRecommended($_POST['recset'], $_POST['username'], $_POST['password']);
				break;
			case "Delete Recommendation":
				deleteRecommendation($_POST['recID'], $_POST['username'], $_POST['password']);
				break;
			case "Update Recommendations":
				updateRecommendation($_POST['recset'], $_POST['gameName'], $_POST['status'], $_POST['comments'], $_POST['username'], $_POST['password']);
				break;
			case "Query Recommendation":
				queryRecommendation($_POST['genre'], $_POST['platform'], $_POST['rating'], $_POST['username'], $_POST['password']);
				break;
			case "Send Recommendation":
				sendRecommendation($_POST['gameName'], $_POST['theirUsername'], $_POST['username'], $_POST['password']);
				break;
		}
	}


	function addinRecommendation($gameID, $status, $comments){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "INSERT INTO Recommendation SELECT theMax + 1, '" . $gameID . "', '" . $status . "', '" . $comments . "' FROM (SELECT MAX(rc_recID) AS theMax FROM Recommendation);";
		$result = $db->query($sql);
		echo("Added your recommendation to the database!");
		unset($db);
	}
	
	function viewRecommended($recset, $username, $password){
		$location = '../data.sqlite';
		
		if(authenticateUser($username, $password, 'Any', $location) == true){
			$db = new SQLite3($location);
			if($recset != ""){
				$sql = "SELECT rc_recID, g_name, rc_status, rc_comments FROM Recommendation, Recommend_User, vgData WHERE g_gameID = rc_gameID and rc_recID = ru_recID and ru_username = '" . $username . "' and rc_recID = " . $recset . ";";
			}
			else{
				$sql = "SELECT rc_recID, g_name, rc_status, rc_comments FROM Recommendation, Recommend_User, vgData WHERE g_gameID = rc_gameID and rc_recID = ru_recID and ru_username = '" . $username . "';";
			}
			$result = $db->query($sql);
			
			echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				echo($row['rc_recID'] . ": " . $row['g_name'] . " - " . $row['rc_status'] . ": " . $row['rc_comments'] . "<br>");
			}
			echo("</div>");
		}
	}
	
	function queryRecommendation($genre, $platform, $rating, $username, $password){
		$location = '../data.sqlite';
		
		if(authenticateUser($username, $password, 'Any', $location) == true){
			$db = new SQLite3($location);
			if($genre == 'Any'){
				$genre = '';
			}
			if($platform == 'Any'){
				$platform = '';
			}
			
			if($rating == 'Any'){
				$sql = "INSERT INTO Recommendation (rc_recID, rc_gameID, rc_status, rc_comments) SELECT distinct maxID.theMax + 1, g_gameID, 'Unplayed', '' FROM vgData, Review, (SELECT max(rc_recID) as theMax FROM Recommendation) maxID WHERE g_gameID = r_gameID and g_genre like '%" . $genre . "%' and g_platform like '%" . $platform . "%';";
				$sqlUser = "INSERT INTO Recommend_User (ru_username, ru_recID) SELECT '" . $username . "', maxID.theMax FROM (SELECT max(rc_recID) as theMax FROM Recommendation) maxID;";
				
				$result = $db->query($sql);
				$resultUser = $db->query($sqlUser);
				echo("Added new recommendations to your recommendation list ; )<br>");
			}
			else if($rating == 'Highest'){
				$sql = "INSERT INTO Recommendation (rc_recID, rc_gameID, rc_status, rc_comments) SELECT distinct maxID.theMax + 1, g_gameID, 'Unplayed', '' FROM vgData, Review, (SELECT max(rc_recID) as theMax FROM Recommendation) maxID WHERE g_gameID = r_gameID and g_genre like '%" . $genre . "%' and g_platform like '%" . $platform . "%' ORDER BY r_rating desc LIMIT 3;";
				$sqlUser = "INSERT INTO Recommend_User (ru_username, ru_recID) SELECT '" . $username . "', maxID.theMax FROM (SELECT max(rc_recID) as theMax FROM Recommendation) maxID;";
				
				$result = $db->query($sql);
				$resultUser = $db->query($sqlUser);
				echo("Added new recommendations to your recommendation list ; )<br>");
			}
			else if($rating == 'Lowest'){
				$sql = "INSERT INTO Recommendation (rc_recID, rc_gameID, rc_status, rc_comments) SELECT distinct maxID.theMax + 1, g_gameID, 'Unplayed', '' FROM vgData, Review, (SELECT max(rc_recID) as theMax FROM Recommendation) maxID WHERE g_gameID = r_gameID and g_genre like '%" . $genre . "%' and g_platform like '%" . $platform . "%' ORDER BY r_rating asc LIMIT 3;";
				$sqlUser = "INSERT INTO Recommend_User (ru_username, ru_recID) SELECT '" . $username . "', maxID.theMax FROM (SELECT max(rc_recID) as theMax FROM Recommendation) maxID;";
				
				$result = $db->query($sql);
				$resultUser = $db->query($sqlUser);
				echo("Added new recommendations to your recommendation list ; )<br>");
			}
		}
	}
	
	function deleteRecommendation($recID, $username, $password){
		$location = '../data.sqlite';
		
		if(authenticateUser($username, $password, 'Any', $location) == true){
			$db = new SQLite3($location);
			$sql = "DELETE FROM Recommendation WHERE rc_recID = " . $recID . ";";
			$sqlUser = "DELETE FROM Recommend_User WHERE ru_recID = " . $recID . ";";
			$result = $db->query($sql);
			$resultUser = $db->query($sqlUser);
			echo("Deleted recommendation from database<br>");
			unset($db);
		}
	}
	
	function updateRecommendation($recID, $gameName, $status, $comment, $username, $password){
		$location = '../data.sqlite';
		
		if(authenticateUser($username, $password, 'Any', $location) == true){
			$db = new SQLite3($location);
			$sqlVerify = "SELECT distinct ru_username FROM Recommend_User WHERE ru_recID = " . $recID . ";";
			$resultVerify = $db->query($sqlVerify);
			while($row = $resultVerify->fetchArray(SQLITE3_ASSOC)){
				if($row['ru_username'] == $username){
					$sql = "UPDATE Recommendation SET rc_status = '" . $status . "', rc_comments = '" . $comment . "' WHERE rc_recID = " . $recID . " and rc_gameID = (SELECT g_gameID FROM vgData WHERE g_name = '" . $gameName . "');";
					$result = $db->query($sql);
					echo("Updated Recommendation Entry <br>");
				}
			}
			unset($db);
		}
	}
	
	function sendRecommendation($gameName, $theirUsername, $username, $password){
		$location = '../data.sqlite';
		
		if(authenticateUser($username, $password, 'Any', $location) == true){
			$db = new SQLite3($location);
			$sql = "INSERT INTO Recommendation SELECT maxID + 1, g_gameID, 'Unplayed', 'Recommended by " . $username . "' FROM vgData, (SELECT max(rc_recID) as maxID FROM Recommendation) WHERE g_name = '" . $gameName . "';";
			$sqlUser = "INSERT INTO Recommend_User SELECT '" . $theirUsername . "', maxID FROM (SELECT max(rc_recID) as maxID FROM Recommendation);";
			
			$result = $db->query($sql);
			$resultUser = $db->query($sqlUser);
			echo("Sent the rec to " . $theirUsername . "!<br>");
			unset($db);
		}
	}
?>

<html>
	<head>
		<title>Recommendation Page</title>
		<style>
			div {
				height: 200px;
				width: 1000px;
				overflow-y: auto;
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<hr>
		<table width=1200px><tr><td>
		<form method="post"><b>See Your Recommendations: <br>(leave recommendation set empty if you want to see everything)</b> <br>
		Recommendation Set: <input type="text" name="recset"> <br>
		Username: <input type="text" name="username"> <br>
		Password: <input type="password" name="password"> <br>
		<input type="submit" name="queryType" value="See Recommendations">
		</form></td><td>
		<form method="post"><b>Update Your Recommendations:</b> <br>
		Recommendation Set: <input type="text" name="recset"> <br>
		Game Name: <input type="text" name="gameName"> <br>
		<label for="status">Status of Game Reviewing?:</label>
			<select id="status" name="status">
  			<option value="Unplayed">Unplayed</option>
 			<option value="In Progress">In Progress</option>
 			<option value="Finished">Finished</option>
			</select> <br>
		Comments: <input type="text" name="comments"><br>
		Username: <input type="text" name="username"> <br>
		Password: <input type="password" name="password"> <br>
		<input type="submit" name="queryType" value="Update Recommendations">
		</form></td><td>
		<b>Delete Your Recommendation</b>
		<form method = "post">
			Recommendation Set: <input type="text" name="recID"><br>
			Username: <input type="text" name="username"> <br>
			Password: <input type="password" name="password"> <br>
			<input type="submit" name="queryType" value="Delete Recommendation">
		</form></td></tr></table>
		
		<hr>
		<table width=800px><tr><td>
		<b>Query for New Recommendations:</b>
		<form method = "post">
			<label for="status">Genre:</label>
			<select id="genre" name="genre">
  			<option value="Any">Any</option>
 			<option value="RPG">RPG</option>
 			<option value="Adventure">Adventure</option>
 			<option value="Action">Action</option>
 			<option value="FPS">FPS</option>
 			<option value="Survival">Survival</option>
 			<option value="Platformer">Platformer</option>
 			<option value="Fighting">Fighting</option>
			</select> <br>
			Platform:
			<select id="platform" name="platform">
  			<option value="Any">Any</option>
 			<option value="PC">PC</option>
 			<option value="Playstation">Playstation</option>
 			<option value="Xbox">Xbox</option>
 			<option value="Switch">Switch</option>
 			<option value="Mac">Mac</option>
			</select> <br>
			Rating:
			<select id="rating" name="rating">
  			<option value="Any">Any</option>
 			<option value="Highest">3 Highest</option>
 			<option value="Lowest">3 Lowest</option>
			</select> <br>
			Username: <input type="text" name="username"> <br>
			Password: <input type="password" name="password"> <br>
			<input type="submit" name="queryType" value="Query Recommendation">
		</form></td>
		
		<td>
		<b>Send Someone a Recommendation!:</b>
		<form method = "post">
			Game Name: <input type="text" name="gameName"> <br>
			Their Username: <input type="text" name="theirUsername"> <br>
			Your Username: <input type="text" name="username"> <br>
			Your Password: <input type="password" name="password"> <br>
			<input type="submit" name="queryType" value="Send Recommendation">
		</form></td></tr></table>
		
	
		[<a href="../index.php">Home Page</a>]
	</body>
</html>
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
	</body>

</html>


































<?php
	$location = '../data.sqlite';
	$username=$_POST['username'];
	$comments=$_POST['comments'];
	$gameName=$_POST['gameName'];
	$filePath='';
	
	if($_POST['queryType'] == "Add Photo"){
		$db = new SQLite3($location);
		$sql = "INSERT INTO Pictures SELECT g_gameID, theMax+1, '" . $username . "', '" . $comments . "' FROM vgData, (SELECT max(p_imageID) as theMax FROM Pictures) WHERE g_name = '" . $gameName . "';";
		$result = $db->query($sql);
		$sql = "SELECT max(p_imageID) as theMax FROM Pictures;";
		$result = $db->query($sql);
		
		$location = '../images/';
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			$filePath = $location . $row['theMax'] . ".jpg";
		}
		
		if( $_FILES['file']['name'] != "" ) {
			$path=$_FILES['file']['name'];
			move_uploaded_file( $_FILES['file']['tmp_name'], $filePath) or die( "Could not copy file!");
		}
		else {
			die("No file specified!");
		}
		unset($db);
	}
	else if($_POST['queryType'] == "Add Gameplay"){
		$db = new SQLite3($location);
		$sql = "INSERT INTO Gameplay SELECT g_gameID, theMax+1, '" . $username . "', '" . $comments . "' FROM vgData, (SELECT max(gp_id) as theMax FROM Gameplay) WHERE g_name = '" . $gameName . "';";
		$result = $db->query($sql);
		$sql = "SELECT max(gp_id) as theMax FROM Gameplay;";
		$result = $db->query($sql);
		
		$location = '../gameplay/';
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			$filePath = $location . $row['theMax'] . ".gif";
		}
		echo($filePath . "<br>");
		
		if( $_FILES['file']['name'] != "" ) {
			$path=$_FILES['file']['name'];
			move_uploaded_file( $_FILES['file']['tmp_name'], $filePath) or die( "Could not copy file!");
		}
		else {
			die("No file specified!");
		}
		unset($db);
	}
?>
















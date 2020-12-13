<?php
	include "pages/helper.php";
	$location = 'data.sqlite';
	
	//open database
	
	// display all users
	/*$db = new SQLite3($location);
	$sql = "SELECT * FROM Users";
	$result = $db->query($sql);
	echo '<br><br>';
	while ($row = $result->fetchArray(SQLITE3_ASSOC)){
	  echo $row['u_username'] . ': ' . $row['u_type'] . '<br/>';
	}
	echo '<br><br>';*/
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		 if($_POST['queryType'] == "Search Query")
		 	rdmQuery($_POST['rdmQuery']);
		else;

	}

	function rdmQuery($rdmQuery){
		$location = 'data.sqlite';
		$db = new SQLite3($location);
		$sql = $rdmQuery;
		$result = $db->query($sql);
		echo("<div>");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			echo(implode(" | ",$row) . "<br>");
		}
		echo("</div>");
		
		unset($db);
	}
 
	// close database
?>

<html>
	<head>
		<title>Carlos' and Bryce's Game Rating Site</title>
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
		Carlos' and Bryce's Freaking Sweet Game Rating Site!<br>
		<hr>
		<table><tr><td>
		<b>Sign Up, View Users, or Delete Your Account:</b></td><td> [<a href="pages/Users.php">User Page</a>]<br></td></tr>
		<tr><td><b>View Games, Edit the Database, or View and Write Reviews:</b></td><td> [<a href="pages/Games.php">Games Page</a>]
		<tr><td><b>Generate and View Recommendations:</b></td><td> [<a href="pages/Recommendations.php">Recommendation Page</a>]
		<br></td></tr></table><br>
		
		Have a query in mind already? Input it here! 
		<form method="post">
			<textarea name="rdmQuery"></textarea> <br>
			<input type="submit" name="queryType" value= "Search Query">
		</form>
		
	</body>

</html>
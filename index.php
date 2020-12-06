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
	
	
	// close database
?>

<html>
	<head>
		<title>Carlos' and Bryce's Game Rating Site</title>
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
		Carlos' and Bryce's Freaking Sweet Game Rating Site!<br>
		<hr>
		<table><tr><td>
		<b>Sign Up, View Users, or Delete Your Account:</b></td><td> [<a href="pages/Users.php">User Page</a>]<br></td></tr>
		<tr><td><b>View Games, Edit the Database, or View and Write Reviews:</b></td><td> [<a href="pages/Games.php">Games Page</a>]
		<tr><td><b>Generate and View Recommendations:</b></td><td> [<a href="pages/Recommendations.php">Recommendation Page</a>]
		<br></td></tr></table>
		
		
	</body>

</html>


































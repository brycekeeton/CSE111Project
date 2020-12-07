<?php
	include "helper.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo('<u>Query: <b>' . $_POST['queryType'] . '</b></u><br>');
		
		switch($_POST['queryType']){
			case "Add Recommendation":
				addinRecommendation($_POST['gameID'], $_POST['status'], $_POST['comments']);
				break;
			case "See Recommendations":
				viewRecommended();
				break;
			case "Delete Recommendation":
				deleteRecommendation($_POST['recommendation']);
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
	
	function viewRecommended(){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "SELECT rc_recID, rc_gameID, rc_status, rc_comments FROM Recommendation";
		$result = $db->query($sql);
		
		echo("<div width=500 height=200 style='overflow-y=\'auto\''>");
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			echo($row['rc_recID'] . ": ". $row['rc_status'] . ": " . $row['rc_comments'] . "<br>");
		}
		echo("</div>");
	}
	
	function deleteRecommendation($recID){
		$location = '../data.sqlite';
		$db = new SQLite3($location);
		$sql = "DELETE FROM Recommendation WHERE rc_recID = " . $recID . ";";
		$result = $db->query($sql);
		echo("Deleted recommendation from database <br>");
		unset($db);
	}

?>

<html>
	<head>
		<title>Recommendation Page</title>
	</head>
	<body>
		<hr>
		<form method="post"><b>See Recommendations:</b> <input type="submit" name="queryType" value="See Recommendations"></form>
		<b>Add A Recommendation!:</b>
		<form method = "post">
			Game ID: <input type="text" name="gameID"> <br>
			<label for="status">Status of Game Reviewing?:</label>
			<select id="status" name="status">
  			<option value="Unplayed">Unplayed</option>
 			<option value="In Progress">In Progress</option>
 			<option value="Finished">Finished</option>
			</select> <br>
			Comments: <input type="text" name="comments">
			<input type="submit" name="queryType" value="Add Recommendation">
		</form>
		<b>Delete Your Recommendation</b>
		<form method = "post">
			Recommendation ID: <input type="text" name="recID">
			<input type="submit" name="queryType" value="Delete recommendation">
		</form>
	
	
	
		[<a href="../index.php">Home Page</a>]
	</body>
</html>
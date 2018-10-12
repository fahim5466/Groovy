<?php
/* Displays user information and some useful messages */
session_start();
$song_id = $_GET['song'];
$id = $_SESSION['id'];
$sql =  "DELETE FROM songs WHERE songs.song_id = '$song_id' and id='$id'" ;
$mysqli = new mysqli("localhost", "root", "", "accounts");
$mysqli->query($sql);
header('location: modify_list.php');
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>My Groovy List</title>
    <?php include 'css/css.html'; ?>
</head>

<br>
<br>
<br><br><br><br><br>
<body style="color: #0E36AC; ">
	
</body>
</html>
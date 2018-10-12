<?php
/* Displays user information and some useful messages */
require 'db.php';
/*header("Location: modify_list.php"); */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: modify_list.php");
}
else {
    // Makes it easier to read
    $id = $_SESSION['id'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
}
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Groovy-Add Song</title>
    <?php include 'css/css.html'; ?>
	
	<script LANGUAGE="JavaScript">
        function testResults() {
			<a href="add_song.php"></a>;
        }
    </script>
	
</head>
<br><br><br><br><br><br>
<body style="color: #BECCED">

<?php 
if(isset($_POST['song']) && !empty($_POST['song']))
{
	$song = $_POST['song'];
	$country = $_POST['country'];
	$period = $_POST['period'];
	$language = $_POST['language'];
	$artist = $_POST['artist'];
	$genre = $_POST['genre'];

	$temp = $mysqli->query("SELECT * from songs WHERE song='$song' AND id='$id'");
	if($temp->num_rows ==0)
	{
		$mysqli->query("INSERT INTO songs (id,song,genre,country,period,language,artist) values ('$id','$song','$genre','$country','$period','$language','$artist')");
	}
}

?>

<div class="form">
<form action="add_song.php" method="post">
    <div class="field-wrap"><label>Song<span class="req">*</span> </label><input type="text" required autocomplete="off" name="song"></div>
    <div>
        Genre<br><br>
        <select name="genre">
            <option value="rock">Rock</option>
            <option value="pop">Pop</option>
            <option value="country">Country</option>
        </select>
    </div><br><br>
    <div class="field-wrap"><label>Country </label><input type="text" name="country"> </div>
    <div class="field-wrap"><label>Period</label> <input type="text" name="period"> </div>
    <div class="field-wrap"><label>Language</label> <input type="text" name="language"> </div>
    <div class="field-wrap"><label>Artist</label> <input type="text" name="artist"> </div>
    <input type="submit" value="Submit" onclick = "javascript:testresults()">
</form>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>

</html>
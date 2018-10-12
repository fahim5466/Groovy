<?php
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: add_song.php");
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
    <title>My Groovy List</title>
    <?php include 'css/css.html'; ?>
</head>

<br>
<br>
<br><br><br><br><br>
<body style="color: #0E36AC; ">


    <form action="add_song.php">
        <button type="submit" class="button button-block">Add song</button>
    </form>
<br><br><br><div class="">
    <?php
	
	$mysqli = new mysqli("localhost", "root", "", "accounts");

    $result = $mysqli->query("SELECT * FROM songs WHERE id='$id'");
	
	$number_of_songs = 1;
	#echo $result->num_rows;

    if($result->num_rows >0 ) {
		

        while ($row = mysqli_fetch_assoc($result)) {
			$link = "delete.php?song=". $row['song_id'];
			echo '<center>'.'<div style="color:#ffffff; background-color: #AAA5A5; margin: 0px 500px; ">'.'<br>'.'<h3>'
			.$number_of_songs.".   ".$row["song"]."  - ".$row["genre"].'</h3>'.
			'<form action="'.$link.'" method="post">
        <button type="submit" class="button button-delete">Remove</button> </form>'.'</div>'.'</br>'.'<center>';
			echo '<br><br>';
			$number_of_songs++;
        }

    }
	
	else {
			echo '<strong><center><h1>You have not added any song yet!!!</h1></center></strong>' ;
	}

    ?>


</div>

</body>
</html>

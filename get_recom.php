<?php
/* Displays user information and some useful messages */
require 'db.php';
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
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
    <title>Groovy</title>
    <?php include 'css/css.html'; ?>
</head>

<body>

<?php


function same_taste($user,$person)
{
    if($user==$person){return false;}
    global $mysqli;
    $user_tot = $mysqli->query("SELECT * FROM songs WHERE id='$user'")->num_rows;
    $person_tot = $mysqli->query("SELECT * FROM songs WHERE id='$person'")->num_rows;
    $common = ($mysqli->query("
                SELECT song FROM songs
                WHERE id='$user'
                AND song IN (SELECT song FROM songs WHERE id='$person')
               "))->num_rows;

    //echo $user_tot." ".$person_tot." ".$common;

    if($common!=$user_tot && $common/$user_tot >= .5 || $common/$person_tot >= .5)
    {
        if($mysqli->query("SELECT * FROM friends WHERE user_id='$user' AND friend_id='$person'")->num_rows==0)
        {
            $mysqli->query("INSERT INTO friends(user_id,friend_id) VALUES('$user','$person')");
        }
        //echo "friend<br>";
        return true;
    }
    else
    {
        if($mysqli->query("SELECT * FROM friends WHERE user_id='$user' AND friend_id='$person'")->num_rows>0)
        {
            $mysqli->query("DELETE FROM friends WHERE user_id='$user' AND friend_id='$person'");
        }
    }

    return false;

}

//put new friends

//randomly select one song from user's list
$offset_result = $mysqli->query( " SELECT FLOOR(RAND() * COUNT(*)) AS offset FROM songs WHERE id='$id' ");
$offset_row = mysqli_fetch_assoc( $offset_result );
$offset = $offset_row['offset'];
$sel_song_result = $mysqli->query( " SELECT * FROM songs WHERE id='$id' LIMIT $offset, 1 " );
$sel_song_row=mysqli_fetch_assoc($sel_song_result);
$sel_song=$sel_song_row['song'];

//echo "Randomly selected song is $sel_song<br>";

//see what other users have that song in their list
$poten = $mysqli->query(
        "SELECT id FROM songs WHERE song = '$sel_song'"
);

//see if those users can be considered friends
while($temp = mysqli_fetch_assoc($poten))
{
    $person = $temp['id'];
    //echo "Checking to see if $person can be considered friend<br>";
    same_taste($id,$person);
}

//Before recommending check if all friends are still friends

$friends = $mysqli->query(
        "SELECT friend_id FROM friends WHERE user_id='$id'"
);

while($temp = mysqli_fetch_assoc($friends))
{
    $friend = $temp['friend_id'];
    if(!same_taste($id,$friend))
    {
        //echo "$id and $friend are not friends anymore<br>";
    }
    else
    {
        //echo "$id and $friend are still friends<br>";
    }
}


//From all songs that can be recommended select a random one
$recom_result = $mysqli->query( " 
  SELECT * FROM songs WHERE id IN
    (SELECT friend_id FROM friends WHERE user_id = '$id')
  AND song NOT IN (SELECT song FROM songs WHERE id = '$id')
  AND song NOT IN (SELECT song FROM ignored_songs WHERE id='$id') 
  ");

$recom_array = array();

while($temp = mysqli_fetch_assoc($recom_result))
{
    $okay=true;
    $pg=null;
    if(isset($_POST['preferred_genre']))
    {
        $pg = $_POST['preferred_genre'];
    }

    $pc=null;
    if(isset($_POST['preferred_country']))
    {
        $pc = $_POST['preferred_country'];
    }

    $pp=null;
    if(isset($_POST['preferred_period']))
    {
        $pp = $_POST['preferred_period'];
    }

    $pl=null;
    if(isset($_POST['preferred_language']))
    {
        $pl = $_POST['preferred_language'];
    }

    $pa=null;
    if(isset($_POST['preferred_artist'])) {
        $pa = $_POST['preferred_artist'];
    }

    $song = $temp['song'];

    //echo "Checking $song<br>";

    $genre = $temp['genre'];
    if(isset($pg) && !empty($pg))
    {
        if($pg!="none" && $genre != $pg){$okay=false;}
    }

    $country = $temp['country'];
    if(isset($pc) && !empty($pc))
    {
        if ($country != $pc) {
            $okay = false;
        }
    }

    $period = $temp['period'];
    if(isset($pp) && !empty($pp))
    {
        if($period != $pp){$okay=false;}
    }

    $language = $temp['language'];
    if(isset($pl) && !empty($pl))
    {
        if($language != $pl){$okay=false;}
    }

    $artist = $temp['artist'];
    if(isset($pa) && !empty($pa))
    {
        if($artist != $pa){$okay=false;}
    }

    if($okay)
    {
        array_push($recom_array,$song);
        //echo "pushing $song<br>";
    }
}


foreach($recom_array as $value)
{
    //echo "$value<br>";
}


$recom_song = $recom_array[array_rand($recom_array)];

//display recommendation
if(isset($recom_song))
{

}
else
{
    $_SESSION['message'] = "Oops! Looks like we aren't able find any recommendations for you right now! >_<<br>
                            Try adding more songs or selecting less options! ^_^";
    //header("location: error.php");
}

?>


<div>
    <button class="button button-block"><?php echo $recom_song ?></h1></button>
</div>

<div class="form">

    <form action="get_recom.php" method="post" autocomplete="off">

        <div class="field-wrap">
            <label>
                Genre
            </label>
            <br><br>
            <select align="center" name="preferred_genre">
                <option value="none">None</option>
                <option value="pop">Pop</option>
                <option value="rock">Rock</option>
                <option value="country">Country</option>
            </select>
        </div>

        <div class="field-wrap">
            <label>
                Country
            </label>
            <input autocomplete="off" name="preferred_country"/>
        </div>

        <div class="field-wrap">
            <label>
                Period
            </label>
            <input autocomplete="off" name="preferred_period"/>
        </div>

        <div class="field-wrap">
            <label>
                Language
            </label>
            <input autocomplete="off" name="preferred_language"/>
        </div>

        <div class="field-wrap">
            <label>
                Artist
            </label>
            <input autocomplete="off" name="preferred_artist"/>
        </div>

        <button class="button button-block" />Apply</button>

    </form>

</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>

</html>

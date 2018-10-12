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

<div class="form">
    <form action="get_recom.php" method="post">
        <div class="field-wrap"><label>Song<span class="req">*</span> </label><input type="text" required autocomplete="off" name="song"></div>
        <div>
            Genre<br><br>
            <select name="preferred_genre">
                <option value="none">None</option>
                <option value="rock">Rock</option>
                <option value="pop">Pop</option>
                <option value="country">Country</option>
            </select>
        </div><br><br>
        <div class="field-wrap"><label>Country </label><input type="text" name="preferred_country"> </div>
        <div class="field-wrap"><label>Period</label> <input type="text" name="preferred_period"> </div>
        <div class="field-wrap"><label>Language</label> <input type="text" name="preferred_language"> </div>
        <div class="field-wrap"><label>Artist</label> <input type="text" name="preferred_artist"> </div>
        <input type="submit" value="Submit" onclick = "javascript:testresults()">
    </form>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>

</html>

<?php

// Connecting to Database
try {
    $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);
} catch(Exception $e) {
    echo $e->getMessage();
}

// Variables
$home_name = "";
// Receive form data
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $home_name = $_POST['home_name'];
    $add_home = $db->prepare('INSERT INTO home(name) VALUES (:home_name)');
    $add_home->execute(['home_name' => $home_name]);
}

// Insert info to DB


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add A Home</title>
    </head>
    <body>
        <form method="POST" action="index.php">
            <input name="home_name" type="text" placeholder="Home Name" value="<?php echo $home_name;?>" />
            <button type="submit">
                Save
            </button>
        </form>
    </body>
</html>
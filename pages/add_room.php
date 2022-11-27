<?php
    try {
        $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);


    } catch(Exception $e) {
        echo $e->getMessage();
    }

    $room_name = "";

    $home_id = $_GET['home_id'];

    $homes = $db->prepare('SELECT * FROM home WHERE id = :home_id');
    $homes->execute(['home_id' => $home_id]);
    $home = $homes->fetch(PDO::FETCH_ASSOC);
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $room_name = $_POST["room_name"];
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta>
            <link rel="stylesheet" href="styles.css">
        </meta>
        <title>
            Add A Room
        </title>
    </head>
    <body>
        <h1>Add A Room for <?php echo $home['name']; ?></h1>
        <form method="POST" action="<?php echo "room.php?home_id={$home_id}" ?>">
            <input type="text" placeholder="Room Name" name="room_name" value="<?php echo $room_name; ?>"/>
            <button type="submit">Save</button>
        </form>
    </body>
</html>
<?php
    try {
        $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    $home_id = $_GET["home_id"];
    $room_name = "";

    // Post data into database
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $room_name = $_POST['room_name'];
        $add_room = $db->prepare('INSERT INTO room (home_id, name) VALUES (:home_id, :room_name)');
        $add_room->execute(['home_id' => $home_id, 'room_name' => $room_name]);
    }


    // Get name of home
    $read_home = $db->prepare('SELECT * FROM home WHERE id = :id');
    $read_home->execute(['id' => $home_id]);
    $home = $read_home->fetch(PDO::FETCH_ASSOC);

    // Get list of rooms
    $read_rooms = $db->prepare('SELECT * FROM room WHERE home_id = :home_id');
    $read_rooms->execute(['home_id' => $home_id]);
    $rooms = $read_rooms->fetchAll(PDO::FETCH_ASSOC);
    $rooms = array_reverse($rooms, true);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $home["name"]; ?>
        </title>
    </head>
    <body>
        <h1><?php echo $home["name"]; ?></h1>
        <h2>Rooms</h2>
        <?php
        foreach($rooms as $room) {
            echo "<a href='item.php?home_id={$home_id}&room_id={$room['id']}'><p>{$room['name']}</p></a>\n";
        }
        ?>
        <h3>Add room</h3>
        <form method="POST" action="">
            <input type="text" name="room_name" placeholder="Room Name" value="" />
            <button type="submit">Save</button>        
        </form>
        <a href="index.php">Back To Homes</a>
    </body>
</html>
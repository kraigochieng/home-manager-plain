<?php
try {
    $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);
} catch(Exception $e) {
    echo $e->getMessage();
}
    

        //from URL
        $home_id = $_GET['home_id'];
        $room_id = $_GET['room_id'];

    // Queries
    $read_home_name = $db->prepare('SELECT * FROM home WHERE id = :id');
    $read_home_name->execute(['id' => $home_id]);
    $home = $read_home_name->fetch(PDO::FETCH_ASSOC);

    $read_room_name = $db->prepare('SELECT * FROM room WHERE id = :id');
    $read_room_name->execute(['id' => $room_id]);
    $room = $read_room_name->fetch(PDO::FETCH_ASSOC);

    $read_items = $db->prepare('SELECT * FROM item WHERE room_id = :room_id');
    $read_items->execute(['room_id' => $room_id]);
    $items = $read_items->fetchAll(PDO::FETCH_ASSOC);
    $items = array_reverse($items, TRUE);
?>

<html>
    <head>
    <meta>
            <link rel="stylesheet" type="text/css" href="styles.css"></link>
        </meta>
        <title><?php echo $home['name'] . " | " . $room['name']; ?></title>
    </head>
    <body>
        <a href="<?php echo "room.php?home_id={$home_id}"?>">Back to Rooms</a>
        <br>
        <a href="<?php echo "add_item.php?home_id={$home_id}&room_id={$room_id}"?>"><button>Add Item</button></a>
        <h1><?php echo $home['name'] ?></h1>
        <h2><?php echo $room['name'] ?></h2>
        
            <?php
            if(count($items) === 0) {
                echo "<p>No items yet.</p>";
            } else {
                echo "<h3>Items</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>";
            foreach($items as $item) {
                echo "<tr><td>{$item['name']}</td><td>{$item['unit_price']}</td><td>{$item['quantity']}</td><td>". $item['unit_price'] * $item['quantity'] ."</td></tr>";
            }
            echo "</table>";
            }
            
        ?>
    </body>
</html>
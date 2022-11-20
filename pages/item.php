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


    // handling Form
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $add_item = $db->prepare('INSERT INTO item (room_id, name, unit_price, quantity) VALUES (:room_id, :name, :unit_price, :quantity)');
        $add_item->execute([
            'room_id' => $room_id,
            'name' => $_POST['item_name'],
            'unit_price' => $_POST['unit_price'],
            'quantity' => $_POST['quantity']]);
    }

    $read_items = $db->prepare('SELECT * FROM item WHERE room_id = :room_id');
    $read_items->execute(['room_id' => $room_id]);
    $items = $read_items->fetchAll(PDO::FETCH_ASSOC);
    $items = array_reverse($items, TRUE);
?>

<html>
    <head>
        <title><?php echo $home['name'] . " | " . $room['name']; ?></title>
    </head>
    <body>
        <h1><?php echo $home['name'] ?></h1>
        <h2><?php echo $room['name'] ?></h2>
        <h3>Items</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <?php
            foreach($items as $item) {
                echo "<tr><td>{$item['name']}</td><td>{$item['unit_price']}</td><td>{$item['quantity']}</td><td>". $item['unit_price'] * $item['quantity'] ."</td></tr>";
            }
        ?>
        </table>
        
        <form method="POST">
            <input type="text" name="item_name" placeholder="Item Name"/>
            <br>
            <input type="number" name="unit_price" placeholder="Unit Price"/>
            <br>
            <input type="number" name="quantity" placeholder="Quantity"/>
            <br>
            <button type="submit">Save</button>
        </form>
        <a href="<?php echo "room.php?home_id={$home_id}"?>">Back to Rooms</a>
    </body>
</html>
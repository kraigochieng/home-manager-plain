<?php
    try {
        $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $home_id = $_GET['home_id'];
    $room_id = $_GET['room_id'];

    $read_home_name = $db->prepare('SELECT * FROM home WHERE id = :id');
    $read_home_name->execute(['id' => $home_id]);
    $home = $read_home_name->fetch(PDO::FETCH_ASSOC);

    $read_room_name = $db->prepare('SELECT * FROM room WHERE id = :id');
    $read_room_name->execute(['id' => $room_id]);
    $room = $read_room_name->fetch(PDO::FETCH_ASSOC);

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $add_item = $db->prepare('INSERT INTO item (room_id, name, unit_price, quantity) VALUES (:room_id, :name, :unit_price, :quantity)');
        $add_item->execute([
            'room_id' => $room_id,
            'name' => $_POST['item_name'],
            'unit_price' => $_POST['unit_price'],
            'quantity' => $_POST['quantity']]);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Add An Item
        </title>
    </head>
    <body>
        <h1>
            Add An Item for <?php echo $home['name']?> for <?php echo $room['name']?>
    </h1>
        <form method="POST" action="<?php echo "item.php?home_id={$home_id}&room_id={$room_id}" ?>">
            <input type="text" name="item_name" placeholder="Item Name"/>
            <br>
            <input type="number" name="unit_price" placeholder="Unit Price"/>
            <br>
            <input type="number" name="quantity" placeholder="Quantity"/>
            <br>
            <button type="submit">Save</button>
        </form>
    </body>
</html>
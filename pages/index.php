<?php
    try {
        $hostname = "localhost"; $dbname = "home_manager"; $dsn = "mysql:host=$hostname;dbname=$dbname"; $username = "root"; $password = ""; $db = new PDO($dsn, $username, $password);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $read_homes = $db->prepare('SELECT * FROM home');
    $read_homes->execute([]);
    $homes = $read_homes->fetchAll(PDO::FETCH_ASSOC);
    $homes = array_reverse($homes, true);

    // User values
    $home_name = "";
    $validation_message = "";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $home_name = $_POST["home_name"];
        $add_home = $db->prepare('INSERT INTO home (name) VALUES (:home_name)');
        $add_home->execute(['home_name' => $home_name ]);
        $validation_message = $home_name. " saved successfully.";
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Home Page
        </title>
    </head>
    <body>
        <h1>Homes</h1>
        <?php 
            foreach($homes as $home) {
                echo "<a href='room.php?home_id={$home["id"]}'><p>{$home["name"]}</p></a>\n";
            }
        ?>
        <h2>Add Home</h2>
        <form method="POST" action="">
            <input name="home_name" type="text" placeholder="Home Name" value="<?php echo $home_name;?>" />
            <button type="submit">
                Save
            </button>
        </form>
        <p><?php echo $validation_message; ?></p>
    </body>
</html>
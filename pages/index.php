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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta>
            <link rel="stylesheet" type="text/css" href="styles.css"></link>
        </meta>
        <title>
            Home Page
        </title>
    </head>
    <body>
        <a href="add_home.php"><button>Add A Home</button></a>
        <h1>Homes</h1>
        <?php
            if(count($homes) === 0) {
                echo "<p>No homes yet.</p>";
            } else {
                foreach($homes as $home) {
                    echo "<a href='room.php?home_id={$home["id"]}'><p>{$home["name"]}</p></a>\n";
                }
            }
        ?>
    </body>
</html>
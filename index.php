<?php session_start();
require_once("conn.php");


    try {
        $sql=$conn->prepare("SELECT Locatie FROM locaties ORDER BY Locatie ASC");
        $sql->execute();
        $dbloc = $sql->fetchAll();
            } catch(PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }

            try {
                $sql=$conn->prepare("SELECT Naam FROM producten ORDER BY Naam ASC");
                $sql->execute();
                $dbprod = $sql->fetchAll();
                    } catch(PDOException $e) {
                        $conn->rollBack();
                        echo $e->getMessage();
                    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>ToolsForEver</title>
</head>
<body>
    <!-- main container -->
    <div id="Container">

        <!-- ToolsForever Interface -->
        <div id="Tfe">
            <!-- header(logo, name, worker name) -->
            <div id="Header">
                <div id="Logo">
                <img src="logo.png" class="Logo">
                </div>

                <div id="Name">
                <a class="Name"><b>ToolsForEver Voorraad</b></a>
                </div>

                <div id="WorkerName">
                <a class="Medewerker">medewerker: <?php echo '<a href="management.php">'.$_SESSION["username"].'</a>';?></a>
                </div>
                
            </div>
        
            <!-- request(locatie/product info + verzend/uitlog knop) -->
            <div id="Request">
                    <fieldset>
                        <legend>Kies een locatie en een product</legend>
                        <!-- Request form for location and for requested item -->
                        <form method="post" action="Request.php" id="Reqform">
                            <select name="Locatie" id="locatie">
                                <?php
                                if(count($dbloc)==0) {
                                    echo "<option value=\"\">-----</option>";
                                } else{
                                    foreach($dbloc as $key){
                                        echo '<option value="'.$key[0].'">'.$key[0].'</option>';
                                    } 
                                }
                                ?>

                            </select>
                            <select name="Item">
                            <?php
                                if(count($dbprod)==0) {
                                    echo "<option value=\"\">-----</option>";
                                } else{
                                    echo '<option value="all">alles</option>';
                                    foreach($dbprod as $key){
                                        echo '<option value="'.$key[0].'">'.$key[0].'</option>';
                                    } 
                                }
                                ?>
                            </select>
                        </fieldset>
                        </form>
                        <button type="submit" form="<?php if (isset($_SESSION["loggedin"])) {echo"Reqform";}?>" value="Submit">Verzenden</button>
                        <?php
                            if(!isset($_SESSION["loggedin"])) {
                            echo '<a href="logging.php?type=login"><button>Inloggen</button></a>';
                            } else {
                            echo '<a href="logging.php?type=logout"><button>Uitloggen</button></a>';
                            }
                            ?>

                        <br/>
                        <caption>Locatie: <?php echo $_SESSION["locatie"]; ?></caption>
                </form>
            </div>
            <!-- Info from the request -->
            <div id="RequestInfo">

                <table id="RequestedTable">
                <tr>
                    <th><b>Product</b></th>
                    <th><b>Type</b></th>
                    <th><b>Fabriek</b></th>
                    <th><b>In Voorraad</b></th>
                    <th><b>Inkoopprijs</b></th>
                    <th><b>Verkoopprijs</b></th>
                </tr>
                <?php 
                    if (isset($_SESSION["sqlq"])){
                        $dbitem = $_SESSION["sqlq"];

                        foreach ($dbitem as $key) {
                            echo "
                            <tr>
                                <th>".$key[0]."</th>
                                <th>".$key[1]."</th>
                                <th>".$key[2]."</th>
                                <th>".$key[3]."</th>
                                <th>".'€'.$key[4]."</th>
                                <th>".'€'.$key[5]."</th>               
                            </tr>";
                        }
                                
                    }

                ?>
                </table>

            </div>
        </div>

    </div>
</body>
</html>
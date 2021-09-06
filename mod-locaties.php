<?php session_start(); require_once("conn.php");error_reporting(0);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>management</title>
    <link as="style" rel="stylesheet" href="main.css">
</head>
<body>

<div>
    <div id="modcontainer">
        <a href="index.php"><img src="logo.png" style="width: 250px;"></a><br/>

        <?php
            if ($_GET["type"]==""){
                echo "
                <a href='mod-locaties.php?type=new'><button>Nieuwe locatie</button></a>
                <a href='mod-locaties.php?type=change'><button>Locatie aanpassen</button></a><br/>
                 ";
            }elseif($_GET["type"] == "new"){
//                ADD NEW LOCATION
                echo '
                <form action="lochandle.php" method="post">
                <label for="locatie">Locatie:</label><br/>
                <input type="text" id="locatie" name="locatie" value="'.$_POST["retloc"].'"><br/>
                <label for="adres">Adres:</label><br/>
                <input type="text" id="adres" name="adres" value="'.$_POST["retadr"].'"><br/>
                <label for="postcode">Postcode:</label><br/>
                <input type="text" id="postcode" name="postcode" value="'.$_POST["retpos"].'"><br/>                
                <button name="submit" value="newloc">Submit</button>
                </form>
                ';

            }elseif($_GET["type"] == "change"){
//                CHANGE EXISTING LOCATION
                echo "<div style='float: left; padding-left: 250px; padding-top: 75px';>";
                echo '<form method="post" action="lochandle.php" id="changeform">
                <select name="itemid">
';
                try {
                    $sql=$conn->prepare("SELECT LocatieID,Locatie FROM locaties ORDER BY Locatie ASC");
                    $sql->execute();
                    $locinf = $sql->fetchAll();
                } catch(PDOException $e) {
                    $conn->rollBack();
                    echo $e->getMessage();
                }

                if(count($locinf)==0) {
                    echo "<option value=\"\">-----</option>";
                } else{
                    foreach($locinf as $key){
                        echo '<option value="'.$key[0].'">'.$key[1].'</option>';
                    }
                }

                echo "</select>";
                echo "<br/><button type='submit' name='submit' form='changeform' value='requestlocinfo'>Request info</button>";
                echo "</div>";
                echo '
                <div style="float: right; padding-right: 250px; padding-top: 75px">
                <form action="lochandle.php" method="post">
                <label for="locatie">Locatie:</label><br/>
                <input type="text" id="locatie" name="locatie" value="'.$_SESSION["locinfo"]["0"].'"><br/>
                <label for="adres">Adres:</label><br/>
                <input type="text" id="adres" name="adres" value="'.$_SESSION["locinfo"]["1"].'"><br/>
                <label for="postcode">Postcode:</label><br/>
                <input type="text" id="postcode" name="postcode" value="'.$_SESSION["locinfo"]["2"].'"><br/>                
                <input type="hidden" name="id" value="'.$_SESSION["locinfo"]["3"].'">
                <button name="submit" value="reploc">Submit</button>
                <br/>
                <br/>
                <br/>
                <button name="submit" value="deleteloc">verwijder locatie</button>
                </form>
                </div>
                ';



            }

            if ($_GET["locmod"]=="1"){
                echo "Locatie is toegevoegd.";
            }elseif($_GET["locmod"]=="2"){
                echo "Locatie is aangepast.";
            }elseif($_GET["locmod"]=="3"){
                echo "Locatie verwijdert.";
            }

        ?>
    </div>
</div>




</body>
</html>
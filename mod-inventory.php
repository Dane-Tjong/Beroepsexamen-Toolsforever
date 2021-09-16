<?php session_start(); require_once("conn.php");error_reporting(0);
?>

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
        <a href="management.php"><img src="logo.png" style="width: 250px;"></a><br/>

        <?php



//Select action 1
        if ($_GET["type"]==""){
            echo "
                <a href='mod-inventory.php?type=new'><button>Nieuw inventaris item</button></a>
                <a href='mod-inventory.php?type=change'><button>Inventaris aanpassen</button></a><br/>
                 ";
        }elseif($_GET["type"] == "new") {
//                Select action 2 for type=new
            echo "<div style='padding-top: 75px';>";
            echo '<form method="post" action="invhandle.php" id="changeform">
                <select name="locid">';
            try {
                $sql = $conn->prepare("SELECT LocatieID,Locatie FROM locaties ORDER BY Locatie ASC");
                $sql->execute();
                $locinf = $sql->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }

            if (count($locinf) == 0) {
                echo "<option value=\"\">-----</option>";
            } else {
                foreach ($locinf as $key) {
                    echo '<option value="' . $key[0] . '">' . $key[1] . '</option>';
                }
            }

            echo "</select>";
            echo "<br/><button type='submit' name='submit' form='changeform' value='sendlocinf'>Select location</button>";
            echo "</div>";
        }elseif($_GET["type"] == "change") {
//            SELECT ACTION FOR 2 type=change

            echo "<div style='padding-top: 75px';>";
            echo '<form method="post" action="invhandle.php" id="changeform">
                <select name="locid">';
            try {
                $sql = $conn->prepare("SELECT LocatieID,Locatie FROM locaties ORDER BY Locatie ASC");
                $sql->execute();
                $locinf = $sql->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }

            if (count($locinf) == 0) {
                echo "<option value=\"\">-----</option>";
            } else {
                foreach ($locinf as $key) {
                    echo '<option value="' . $key[0] . '">' . $key[1] . '</option>';
                }
            }
            echo "</select><br/>";
            echo "<br/><button type='submit' name='submit' form='changeform' value='selectloc'>selecteer locatie</button>";
            echo "</div>";

        }elseif ($_GET["type"]=="change2"){

            if ($_SESSION["locdata"] != "" && $_SESSION["finlocdata"] != ""){
            echo "<div style='padding-top: 75px';>";
            echo '<form method="post" action="invhandle.php" id="changeform">';
            echo '<select name="prodid">';
            try {
                $sql = $conn->prepare("SELECT vr.ProductID, pr.Naam FROM voorraden as vr
                                                INNER JOIN producten as pr
                                                ON pr.ProductID = vr.ProductID
                                                WHERE vr.LocatieID = :lid
                                                ORDER BY pr.Naam  ASC");
                $sql->bindParam(":lid", $_SESSION["locid"], PDO::PARAM_INT, 10);
                $sql->execute();
                $prodinf = $sql->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }

            if (count($prodinf) == 0) {
                echo "<option value=\"\">-----</option>";
            } else {
                foreach($prodinf as $key) {
                    echo '<option value="' . $key[0] . '">' . $key[1] . '</option>';
                }
            }
            echo "</select></form>";
            if (count($prodinf) == 0) {
                echo "<br/><a href='mod-inventory.php?type=change'><button>terug naar locatie selectie</button></a>";
            }else{
                echo "<br/><button type='submit' name='submit' form='changeform' value='selectprod'>selecteer product</button>";
            }
//            echo "<br/><button type='submit' name='submit' form='changeform' value='selectprod'>selecteer product</button>";
            echo "</div>";
            }else{
                header("Location: mod-inventory.php?type=change");

            }












        }elseif($_GET["type"]=="change3"){

            if ($_SESSION["locdata"] != "" && $_SESSION["proddata"] != "" && $_SESSION["prodamnt"] != ""){
            echo "<div style='padding-top: 75px';>";
            echo '<form method="post" action="invhandle.php" id="changeform">';
            echo '
                <form action="invhandle.php" method="post">
                <label for="naam">Locatie:</label><br/>
                <input type="text" id="locatie" name="naam" value="'.$_SESSION["locdata"][0].'" READONLY><br/>
                <input type="hidden" name="locid4" value='.$_SESSION["locdata"][1].' READONLY>
                <label for="type">Product:</label><br/>
                <input type="text" id="product" name="product" value="'.$_SESSION["proddata"][0].'"READONLY><br/>
                <input type="hidden" name="prodid4" value='.$_SESSION["proddata"][1].' READONLY>
                <label for="type">Huidig aantal:</label><br/>
                <input type="number" id="currentammount" name="currentammount" value="'.$_SESSION["prodamnt"][0][0].'" READONLY><br/> 
                <label for="type">modifier:</label><br/>
                <input type="number" id="ammount" name="ammount" value=""><br/>                
                <br/>
                <button type="submit" name="submit" style="color: green" value="modinvsend">Aanpassen</button><br/><br/>
                <button type="submit" name="submit" style="color: darkred" value="delinv">Verwijderen</button>
                </form>
                ';

        }else{
                header("Location: mod-inventory.php?type=change2");
            }
        }
//                <select name="editor">
//                    <option value="add">add</option>
//                    <option value="redact">redact</option>
//                </select>









//            echo '<select name="prodid">';
//            try {
//                $sql = $conn->prepare("SELECT vr.ProductID, pr.Naam FROM voorraden as vr
//                                                INNER JOIN producten as pr
//                                                ON pr.ProductID = vr.ProductID
//                                                ORDER BY pr.Naam ASC");
//                $sql->execute();
//                $prodinf = $sql->fetchAll();
//            } catch (PDOException $e) {
//                $conn->rollBack();
//                echo $e->getMessage();
//            }
//
//            if (count($prodinf) == 0) {
//                echo "<option value=\"\">-----</option>";
//            } else {
//                foreach($prodinf as $key) {
//                    echo '<option value="' . $key[0] . '">' . $key[1] . '</option>';
//                }
//            }
//
//            echo "</select>";
//        NEW ADD NEW ITEM
        if ($_GET["type"] == "newinv"){
            echo '
                <form action="invhandle.php" method="post">
                <input type="hidden" name="locid" value="'.$_SESSION["locid"].'">
                <label for="locatie">locatie naam:</label><br/>
                <input type="text" id="locatie" name="locatie" value="'.$_SESSION["locinfo"].'" readonly><br/>';
//                SELECT PRODUCTS
            echo "<label for='prodid'>Product Naam:</label><br/>";
            echo "<select name='prodid' id='prodid' style='width: 150px; text-align: center;'><br/>";
try {

                $sql = $conn->prepare("SELECT pr.Naam, pr.ProductID FROM producten pr 
                                                WHERE NOT EXISTS(SELECT vr.ProductID FROM voorraden vr
                                                WHERE vr.ProductID = pr.ProductID AND vr.LocatieID = :lid)
                                                ORDER BY pr.Naam ASC");
    $sql->bindParam(":lid", $_SESSION["locid"], PDO::PARAM_INT, 10);
    $sql->execute();
                $prodinf = $sql->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
            if (count($prodinf) == 0) {
                echo "<option value=\"\">-----</option>";
            } else {
                foreach($prodinf as $key) {
                    echo '<option value="' . $key[1] . '">' . $key[0] . '</option>';
                }
            }
echo "</select><br/>".
    '
                <label for="aantal">aantal:</label><br/>
                <input type="number" id="aantal" name="aantal" value="'.$_POST["retamt"].'"><br/>                
                <button name="submit" value="newinv">Submit</button>
                </form>
                ';
        }
//        END NEW ITEM

        if ($_GET["type"] == "changeinv"){


        }






//            echo '
//                <form action="invhandle.php" method="post">
//                <label for="naam">item naam:</label><br/>
//                <input type="text" id="naam" name="naam" value="'.$_POST["retnaam"].'"><br/>
//                <label for="type">type:</label><br/>
//                <input type="text" id="type" name="type" value="'.$_POST["rettype"].'"><br/>
//                <label for="fabrikant">fabrikant:</label><br/>
//                <input type="text" id="fabrikant" name="fabrikant" value="'.$_POST["retfabr"].'"><br/>                
//                <button name="submit" value="newinv">Submit</button>
//                </form>
//                ';
//
//        }elseif($_GET["type"] == "change"){
////                CHANGE EXISTING ITEM
//            echo "<div style='float: left; padding-left: 250px; padding-top: 75px';>";
//            echo '<form method="post" action="invhandle.php" id="changeform">
//                <select name="itemid">
//';
//            try {
//                $sql=$conn->prepare("SELECT ProductID,Naam FROM producten ORDER BY Naam ASC");
//                $sql->execute();
//                $invinf = $sql->fetchAll();
//            } catch(PDOException $e) {
//                $conn->rollBack();
//                echo $e->getMessage();
//            }
//
//            if(count($invinf)==0) {
//                echo "<option value=\"\">-----</option>";
//            } else{
//                foreach($invinf as $key){
//                    echo '<option value="'.$key[0].'">'.$key[1].'</option>';
//                }
//            }
//
//            echo "</select>";
//            echo "<br/><button type='submit' name='submit' form='changeform' value='requestinvinfo'>Request info</button>";
//            echo "</div>";
//            echo '
//                <div style="float: right; padding-right: 250px; padding-top: 75px">
//                <form action="invhandle.php" method="post">
//                <label for="naam">naam:</label><br/>
//                <input type="text" id="naam" name="naam" value="'.$_SESSION["invinfo"]["0"].'"><br/>
//                <label for="type">type:</label><br/>
//                <input type="text" id="type" name="type" value="'.$_SESSION["invinfo"]["1"].'"><br/>
//                <label for="fabrikant">fabrikant:</label><br/>
//                <input type="text" id="fabrikant" name="fabrikant" value="'.$_SESSION["invinfo"]["2"].'"><br/>
//                <input type="hidden" name="id" value="'.$_SESSION["invinfo"]["3"].'">
//                <button name="submit" value="repinv">Submit</button>
//                <br/>
//                <br/>
//                <br/>
//                <button name="submit" value="deleteinv">verwijder artikel</button>
//                </form>
//                </div>
//                ';
//
//
//
//        }

            if ($_GET["invmod"] == "1") {
                echo "Item is toegevoegd aan het inventaris.";
            } elseif ($_GET["invmod"] == "2") {
                echo "inventaris is aangepast.";
            } elseif ($_GET["invmod"] == "3") {
                echo "inventaris item verwijdert.";
            }
        ?>


    </div>

</div>




</body>
</html>
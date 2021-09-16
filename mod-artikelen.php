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
        if ($_GET["type"]==""){
            echo "
                <a href='mod-artikelen.php?type=new'><button>Nieuw artikel</button></a>
                <a href='mod-artikelen.php?type=change'><button>Artikel aanpassen</button></a><br/>
                 ";
        }elseif($_GET["type"] == "new"){
//                ADD NEW ITEM
            echo '
                <form action="itmhandle.php" method="post">
                <label for="naam">item naam:</label><br/>
                <input type="text" id="naam" name="naam" value=""><br/>
                <label for="type">type:</label><br/>
                <input type="text" id="type" name="type" value=""><br/>
                <label for="fabrikant">fabrikant:</label><br/>
                <input type="text" id="fabrikant" name="fabrikant" value=""><br/>  
                
                <label for="inprijs">Inkoop prijs:</label><br/>
                <input type="number" id="inprijs" name="inprijs" step="0.01" value=""><br/>  
                <label for="uitprijs">Verkoop prijs:</label><br/>
                <input type="number" id="uitprijs" name="uitprijs" step="0.01" value=""><br/>                
                <button name="submit" value="newitm" style="color:green;">Submit</button>
                </form>
                ';

        }elseif($_GET["type"] == "change"){
//                CHANGE EXISTING ITEM
            echo "<div style='float: left; padding-left: 250px; padding-top: 75px';>";
            echo '<form method="post" action="itmhandle.php" id="changeform">
                <select name="itemid">
';
            try {
                $sql=$conn->prepare("SELECT ProductID,Naam FROM producten ORDER BY Naam ASC");
                $sql->execute();
                $itminf = $sql->fetchAll();
            } catch(PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }

            if(count($itminf)==0) {
                echo "<option value=\"\">-----</option>";
            } else{
                foreach($itminf as $key){
                    echo '<option value="'.$key[0].'">'.$key[1].'</option>';
                }
            }

            echo "</select>";
            echo "<br/><button type='submit' name='submit' form='changeform' value='requestitminfo'>Request info</button>";
            echo "</div>";
            echo '
                <div style="float: right; padding-right: 250px; padding-top: 75px">
                <form action="itmhandle.php" method="post">
                <label for="naam">naam:</label><br/>
                <input type="text" id="naam" name="naam" value="'.$_SESSION["itminfo"]["0"].'"><br/>
                <label for="type">type:</label><br/>
                <input type="text" id="type" name="type" value="'.$_SESSION["itminfo"]["1"].'"><br/>
                <label for="fabrikant">fabrikant:</label><br/>
                <input type="text" id="fabrikant" name="fabrikant" value="'.$_SESSION["itminfo"]["2"].'"><br/>                
                <input type="hidden" name="id" value="'.$_SESSION["itminfo"]["3"].'">
                <label for="inkoop">Inkoop prijs:</label><br/>
                <input type="text" id="inkoop" name="inkoop" value="'.$_SESSION["itminfo"]["4"].'"><br/> 
                <label for="verkoop">Verkoop prijs:</label><br/>
                <input type="text" id="verkoop" name="verkoop" value="'.$_SESSION["itminfo"]["5"].'"><br/> 
                <button name="submit" value="repitm" style="color:green; margin-top: 7px">Submit</button>
                <br/>
                ';


            if ($_SESSION["delcount"]["0"]["0"] == "0"){
                echo '<button name="submit" value="deleteitm" style="color: darkred; margin-top: 15px;">verwijder artikel</button>';
                }
            echo '</form>
                </div>
                ';
        }
        if ($_GET["itmmod"]=="1"){
            echo "artikel is toegevoegd.";
        }elseif($_GET["itmmod"]=="2"){
            echo "artikel is aangepast.";
        }elseif($_GET["itmmod"]=="3"){
            echo "artikel verwijdert.";
        }

        ?>


    </div>

</div>




</body>
</html>
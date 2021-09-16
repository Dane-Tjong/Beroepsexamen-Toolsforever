<?php session_start(); require_once("conn.php");error_reporting(0);

//            Get location data for select
try {
    $sql=$conn->prepare("SELECT LocatieID,Locatie FROM locaties ORDER BY Locatie ASC");
    $sql->execute();
    $locinf = $sql->fetchAll();
} catch(PDOException $e) {
    $conn->rollBack();
    echo $e->getMessage();
}
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
                <a href='mod-medewerkers.php?type=new'><button>Nieuwe medewerker</button></a>
                <a href='mod-medewerkers.php?type=change'><button>Medewerker aanpassen</button></a><br/>
                 ";
        }elseif($_GET["type"] == "new"){

//                ADD NEW WORKER
            echo '
                <form action="medhandle.php" method="post">
                <label for="naam">Naam:</label><br/>
                <input type="text" id="naam" name="naam" value="'.$_POST["retnaam"].'"><br/>
                <select name="locatie" style="margin-top: 15px; padding: 3px 40px">';
                            if(count($locinf)==0) {
                                echo "<option value=\"\">-----</option>";
                            } else{
                                foreach($locinf as $key){
                                    echo '<option value="'.$key[0].'">'.$key[1].'</option>';
                                }
                            }
                echo '</select><br/>
                <label for="adres">Adres:</label><br/>
                <input type="text" id="adres" name="adres" value="'.$_POST["retadres"].'"><br/>
                <label for="postcode">Postcode:</label><br/>
                <input type="text" id="postcode" name="postcode" value="'.$_POST["retpost"].'"><br/>   
                <label for="telefoon">Telefoon:</label><br/>
                <input type="text" id="telefoon" name="telefoon" value="'.$_POST["rettel"].'"><br/>   
                <label for="username">Username:</label><br/>
                <input type="text" id="username" name="username" value="'.$_POST["retusern"].'"><br/>  
                <label for="pin">Pin:</label><br/>
                <input type="number" id="pin" name="pin" value="'.$_POST["retpin"].'"><br/>
                <label for="functie">Functie:</label><br/>
                <select name="functie" style="margin-top: 5px;margin-bottom: 5px; padding: 3px 20px">
                ';if($_SESSION["dbloc"]["functie"] == 2){
                    echo '<option value="2">Administrator</option>';
                    }
              echo '<option value="1">Medewerker</option>
                    <option value="0">Buitendienst</option>
                </select>
                <br/>
                <button name="submit" value="newmed" style="color:green;">Submit</button>
                </form>
                ';

        }elseif($_GET["type"] == "change"){
//                CHANGE EXISTING WORKER
            echo "<div style='float: left; padding-left: 250px; padding-top: 55px';>";
            echo '<form method="post" action="medhandle.php" id="changeform">
                <select name="itemid">';
            try {
                $sql=$conn->prepare("SELECT MedewerkerID,Naam FROM medewerkers ORDER BY Naam ASC");
                $sql->execute();
                $medinf = $sql->fetchAll();
            } catch(PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
//CHOOSE WORKER
            if(count($medinf)==0) {
                echo "<option value=\"\">-----</option>";
            } else{
                foreach($medinf as $key){
                    echo '<option value="'.$key[0].'">'.$key[1].'</option>';
                }
            }
//CHANGE WORKER DATA
            echo "</select>";
            echo "<br/><button type='submit' name='submit' form='changeform' value='requestmedinfo'>Request info</button>";
            echo "</div>";
            echo '
                <div style="float: right; padding-right: 250px; padding-top: 55px">
                <form action="medhandle.php" method="post">
                <label for="naam">Naam:</label><br/>
                <input type="text" id="naam" name="naam" value="'.$_SESSION["medinfo"]["0"].'"><br/>
                <label for="curloc">Huidige werklocatie:</label><br/>
                <input type="text" id="curloc" value="'.$_SESSION["medinfo"]["9"].'" readonly><br/>
                <label for="newloc">Nieuwe werklocatie:</label><br/>
                <select id="newloc" name="locatie" style="margin-top: 5px; padding: 3px 40px"><br/>
                <option value=""></option>';
//            call possible locations
                if(count($locinf)==0) {
                    echo "<option value=\"\">-----</option>";
                } else{
                    foreach($locinf as $key){
                        echo '<option value="'.$key[0].'">'.$key[1].'</option>';
                    }
                }


            echo '</select><br/>
                <label for="adres">Adres:</label><br/>
                <input type="text" id="adres" name="adres" value="'.$_SESSION["medinfo"]["1"].'"><br/>
                <label for="postcode">Postcode:</label><br/>
                <input type="text" id="postcode" name="postcode" value="'.$_SESSION["medinfo"]["2"].'"><br/>   
                <label for="telefoon">Telefoon:</label><br/>
                <input type="text" id="telefoon" name="telefoon" value="'.$_SESSION["medinfo"]["3"].'"><br/>   
                <label for="username">Username:</label><br/>
                <input type="text" id="username" name="username" value="'.$_SESSION["medinfo"]["4"].'"><br/>  
                <label for="pin">Pin:</label><br/>
                <input type="number" id="pin" name="pin" value="'.$_SESSION["medinfo"]["5"].'"><br/>
                <label for="functie">Nieuwe functie:</label><br/>
                <select name="functie" style="margin-top: 5px;margin-bottom: 5px; padding: 3px 20px">';
                if($_SESSION["dbloc"]["functie"] == 2){
                    echo "<option value=''></option>";
                echo '<option value="2">Administrator</option>';
                }
                echo '<option value="1">Medewerker</option>
                      <option value="0">Buitendienst</option>
                </select>
                <input type="hidden" name="id" value="'.$_SESSION["medinfo"]["7"].'"><br/>
                <button name="submit" value="changemed" style="margin-top: 5px; color: green">Verstuur veranderingen</button></br>
                <button name="submit" value="delmed" style="margin-top: 5px; color: darkred;">verwijder gebruiker</button>
                </form>
                <br/>
                <br/>
                <br/>
     
                </form>
                </div>
                ';

        }

        if ($_GET["medmod"]=="1"){
            echo "medewerker is toegevoegd.";
        }elseif($_GET["medmod"]=="2"){
            echo "medewerker is aangepast.";
        }elseif($_GET["medmod"]=="3"){
            echo "medewerker verwijdert.";
        }

        ?>

    </div>

</div>




</body>
</html>
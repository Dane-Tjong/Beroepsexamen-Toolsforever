<?php session_start();

if($_SESSION["loggedin"] != true){
    header("Location: login.php");
} ?>

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
    <div id="container">
        <a href="index.php"><img src="logo.png" style="width: 250px;"></a>

<!--  change value   <a href='mod-value.php'><button class='mbutton'>Waarde aanpassen</button></a> -->


        <?php 
        // 2= admin 1= medewerker 0= buitendienst.
            if ($_SESSION["dbloc"]["functie"] == 2) {
                echo "
                <a href='mod-medewerkers.php'><button class='mbutton'>Medewerker aanpassen</button></a>
                <a href='mod-artikelen.php'><button class='mbutton'>Artikel aanpasen</button></a>
                <a href='mod-locaties.php?e'><button class='mbutton'>Locatie aanpassen</button></a>
                <a href='mod-inventory.php'><button class='mbutton'>inventaris aanpassen</button></a>
                ";
            }else if ($_SESSION["dbloc"]["functie"] =="1") {
                echo "                        
                <a href='mod-artikelen.php'><button class='mbutton'>Artikel aanpasen</button></a>
                <a href='mod-locaties.php'><button class='mbutton'>Locatie aanpassen</button></a>
                <a href='mod-inventory.php'><button class='mbutton'>inventaris aanpassen</button></a>
                ";
            }else if ($_SESSION["dbloc"]["functie"] =="0") {
                echo "        
                ";
            }
        
        
        
        
        
        
        ?>

    </div>

</div>




</body>
</html>
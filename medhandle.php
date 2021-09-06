<?php session_start(); require_once("conn.php");

//SUBMIT NEW
if ($_POST["submit"] == "newmed") {
    if ($_POST["naam"] != "" && $_POST["adres"] != "" && $_POST["postcode"] != "" && $_POST["telefoon"] != "" && $_POST["username"] != "" && $_POST["pin"] != "" && $_POST["functie"] != "" ) {
        try {
            $sql = $conn->prepare("INSERT INTO Medewerkers (Naam,Adres,Postcode,Telefoon,username,pin,Functie,LocatieID) VALUES (:naam, :adres, :postcode, :telefoon, :username, :pin, :functie, :locatie)");
            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 60);
            $sql->bindParam(":adres", $_POST["adres"], PDO::PARAM_STR, 60);
            $sql->bindParam(":postcode", $_POST["postcode"], PDO::PARAM_STR, 60);
            $sql->bindParam(":telefoon", $_POST["telefoon"], PDO::PARAM_STR, 60);
            $sql->bindParam(":username", $_POST["username"], PDO::PARAM_STR, 60);
            $sql->bindParam(":pin", $_POST["pin"], PDO::PARAM_INT, 60);
            $sql->bindParam(":functie", $_POST["functie"], PDO::PARAM_INT, 60);
            $sql->bindParam(":locatie", $_POST["locatie"], PDO::PARAM_INT, 60);
            $sql->execute();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: mod-medewerkers.php?medmod=1");
    } else {
        $_POST["retnaam"] = $_POST["naam"];
        $_POST["retadres"] = $_POST["adres"];
        $_POST["retpostcode"] = $_POST["postcode"];
        $_POST["rettelefoon"] = $_POST["telefoon"];
        $_POST["retusername"] = $_POST["username"];
        $_POST["retpin"] = $_POST["pin"];
        $_POST["retfunctie"] = $_POST["functie"];
        $_POST["retlocatie"] = $_POST["locatie"];
        header("Location: mod-medewerkers.php?type=new");
    }

}

//INFO REQUEST
if ($_POST["submit"] =="requestmedinfo"){
    if ($_POST["itemid"] != ""){
        try {
            $sql=$conn->prepare("SELECT Naam,Adres,Postcode,Telefoon,username,pin,Functie,MedewerkerID,LocatieID FROM medewerkers WHERE MedewerkerID = :id  ");
            $sql->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
            $sql->execute();
            $_SESSION["medinfo"] = $sql->fetchAll()[0];
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
//        echo var_dump($_SESSION["medinfo"]);
    header("Location: mod-medewerkers.php?type=change");
    }
}


if ($_POST["submit"] == "repmed"){
    if ($_POST["naam"] != "" && $_POST["adres"] != "" && $_POST["postcode"] != "" && $_POST["telefoon"] != "" && $_POST["username"] != "" && $_POST["pin"] != "" && $_POST["functie"] != ""){
        try {
            $sql=$conn->prepare("UPDATE medewerkers SET Naam = :naam, Adres = :adres ,Postcode = :postcode, Telefoon = :telefoon, username = :username, pin = :pin, Functie = :functie, LocatieID = :locatie WHERE MedewerkerID = :id");
            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 60);
            $sql->bindParam(":adres", $_POST["adres"], PDO::PARAM_STR, 60);
            $sql->bindParam(":postcode", $_POST["postcode"], PDO::PARAM_STR, 60);
            $sql->bindParam(":telefoon", $_POST["telefoon"], PDO::PARAM_STR, 60);
            $sql->bindParam(":username", $_POST["username"], PDO::PARAM_STR, 60);
            $sql->bindParam(":pin", $_POST["pin"], PDO::PARAM_STR, 60);
            $sql->bindParam(":functie", $_POST["functie"], PDO::PARAM_STR, 60);
            $sql->bindParam(":locatie", $_POST["locatie"], PDO::PARAM_INT, 60);
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_INT, 60);

            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-medewerkers.php?itmmod=2");
    }

}

if ($_POST["submit"] == "deletemed"){
    if ($_POST["id"] != ""){
        try {
            $sql=$conn->prepare("DELETE FROM `medewerkers` WHERE `medewerkers`.`MedewerkerID` = :id");
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-medewerkers.php?itmmod=3");
    }
}
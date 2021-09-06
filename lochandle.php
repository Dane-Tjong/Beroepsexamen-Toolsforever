<?php session_start(); require_once("conn.php");

//SUBMIT NEW
if ($_POST["submit"] == "newloc") {
    if ($_POST["locatie"] != "" && $_POST["adres"] != "" && $_POST["postcode"] != "") {
        try {
            $sql = $conn->prepare("INSERT INTO locaties (Locatie, Adres, Postcode) VALUES (:locatie, :adres, :postcode)");
            $sql->bindParam(":locatie", $_POST["locatie"], PDO::PARAM_STR, 60);
            $sql->bindParam(":adres", $_POST["adres"], PDO::PARAM_STR, 60);
            $sql->bindParam(":postcode", $_POST["postcode"], PDO::PARAM_STR, 60);
            $sql->execute();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }

        header("Location: mod-locaties.php?locmod=1");
    } else {
        $_POST["retloc"] = $_POST["locatie"];
        $_POST["retadr"] = $_POST["adres"];
        $_POST["retpos"] = $_POST["postcode"];
        header("Location: mod-locaties.php?type=new");
    }

}

//INFO REQUEST
if ($_POST["submit"] =="requestlocinfo"){
    if ($_POST["itemid"] != ""){
        try {
            $sql=$conn->prepare("SELECT Locatie,Adres,Postcode,LocatieID FROM locaties WHERE LocatieID = :id  ");
            $sql->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
            $sql->execute();
            $_SESSION["locinfo"] = $sql->fetchAll()[0];
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
    header("Location: mod-locaties.php?type=change");
    }
}


if ($_POST["submit"] == "reploc"){
    if ($_POST["locatie"] != "" && $_POST["adres"] != "" && $_POST["postcode"] != ""){
        try {
            $sql=$conn->prepare("UPDATE locaties SET Locatie = :locatie, Adres = :adres ,Postcode = :postcode WHERE LocatieID = :id");
            $sql->bindParam(":locatie", $_POST["locatie"], PDO::PARAM_STR, 48);
            $sql->bindParam(":adres", $_POST["adres"], PDO::PARAM_STR, 48);
            $sql->bindParam(":postcode", $_POST["postcode"], PDO::PARAM_STR, 48);
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-locaties.php?locmod=2");
    }

}

if ($_POST["submit"] == "deleteloc"){
    if ($_POST["id"] != ""){
        try {
            $sql=$conn->prepare("DELETE FROM `locaties` WHERE `locaties`.`LocatieID` = :id");
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-locaties.php?locmod=3");
    }
}
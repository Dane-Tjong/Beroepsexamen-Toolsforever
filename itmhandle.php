<?php session_start(); require_once("conn.php");

//SUBMIT NEW
if ($_POST["submit"] == "newitm") {
    if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != "") {
        try {
            $sql = $conn->prepare("INSERT INTO producten (Naam,Type,Fabrikant) VALUES (:naam, :type, :fabrikant)");
            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 60);
            $sql->bindParam(":type", $_POST["type"], PDO::PARAM_STR, 60);
            $sql->bindParam(":fabrikant", $_POST["fabrikant"], PDO::PARAM_STR, 60);
            $sql->execute();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }

        header("Location: mod-artikelen.php?itmmod=1");
    } else {
        $_POST["retnaam"] = $_POST["naam"];
        $_POST["rettype"] = $_POST["type"];
        $_POST["retfabr"] = $_POST["fabrikant"];
        header("Location: mod-artikelen.php?type=new");
    }

}

//INFO REQUEST
if ($_POST["submit"] =="requestitminfo"){
    if ($_POST["itemid"] != ""){
        try {
            $sql=$conn->prepare("SELECT Naam,Type,Fabrikant,ProductID FROM producten WHERE ProductID = :id  ");
            $sql->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
            $sql->execute();
            $_SESSION["itminfo"] = $sql->fetchAll()[0];
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
    header("Location: mod-artikelen.php?type=change");
    }
}


if ($_POST["submit"] == "repitm"){
    if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != ""){
        try {
            $sql=$conn->prepare("UPDATE producten SET Naam = :naam, Type = :type ,Fabrikant = :fabrikant WHERE ProductID = :id");
            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 48);
            $sql->bindParam(":type", $_POST["type"], PDO::PARAM_STR, 48);
            $sql->bindParam(":fabrikant", $_POST["fabrikant"], PDO::PARAM_STR, 48);
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-artikelen.php?itmmod=2");
    }

}

if ($_POST["submit"] == "deleteitm"){
    if ($_POST["id"] != ""){
        try {
            $sql=$conn->prepare("DELETE FROM `producten` WHERE `producten`.`ProductID` = :id");
            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
            $sql->execute();
        } catch(PDOException $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        header("Location: Mod-artikelen.php?itmmod=3");
    }
}
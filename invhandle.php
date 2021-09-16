<?php session_start(); require_once("conn.php");




//SUBMIT NEW
if ($_POST["submit"] == "sendlocinf"){
    try {
    $sql = $conn->prepare("SELECT Locatie FROM locaties WHERE LocatieID = :id");
    $sql->bindParam(":id", $_POST["locid"], PDO::PARAM_INT, 10);
    $sql->execute();
    $locinf = $sql->fetchAll();
} catch (PDOException $e) {
    $conn->rollBack();
    echo $e->getMessage();
}
    $_SESSION["locid"] = $_POST['locid'];
    $_SESSION["locinfo"] = $locinf[0][0];
    header("Location: mod-inventory.php?type=newinv");
}


if ($_POST["submit"] == "newinv"){
    try {
        $sql = $conn->prepare("INSERT INTO voorraden(LocatieID,ProductID,Huidig) VALUES (:lid,:pid,:amnt)");
        $sql->bindParam(":lid", $_POST["locid"], PDO::PARAM_INT, 10);
        $sql->bindParam(":pid", $_POST["prodid"], PDO::PARAM_INT, 10);
        $sql->bindParam(":amnt", $_POST["aantal"], PDO::PARAM_INT, 10);
        $sql->execute();
        $prodinf = $sql->fetchAll();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }
    unset($_SESSION["locidfin"],$_SESSION["prodidfin"],$_SESSION["modifier"],$_SESSION["proddata"]);
    header("Location: mod-inventory.php?invmod=1");
}

//SUBMIT CHANGE

if ($_POST["submit"] == "selectloc") {
    $_SESSION["locid"] = $_POST["locid"];
    try {
        $sql = $conn->prepare("SELECT Locatie,LocatieID FROM locaties WHERE LocatieID = :lid");
        $sql->bindParam(":lid", $_POST["locid"], PDO::PARAM_INT, 10);
        $sql->execute();
        $locname = $sql->fetchAll();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }
    $_SESSION["locdata"] = $locname[0];
    $_SESSION["finlocdata"] = $locname[0][1];
    header("Location: mod-inventory.php?type=change2");
}


if ($_POST["submit"] == "selectprod"){
//    get prod info
    try {
        $sql = $conn->prepare("SELECT Naam, ProductID FROM producten WHERE ProductID = :pid");
        $sql->bindParam(":pid", $_POST["prodid"], PDO::PARAM_INT, 10);
        $sql->execute();
        $prodname = $sql->fetchAll();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }
    $_SESSION["proddata"] = $prodname["0"];
    $_SESSION["finprodid"] = $prodname["1"];

    //    get prod ammount
    try {
        $sql = $conn->prepare("SELECT Huidig From voorraden WHERE LocatieID = :lid AND ProductID = :pid");
        $sql->bindParam(":lid", $_SESSION["finlocdata"], PDO::PARAM_INT, 10);
        $sql->bindParam(":pid", $prodname[0][1], PDO::PARAM_INT, 10);
        $sql->execute();
        $_SESSION["prodamnt"] = $sql->fetchAll();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }


    header("Location: mod-inventory.php?type=change3");
}

if ($_POST["submit"] == "modinvsend"){



//    calculate new ammount
    $x = $_POST["currentammount"];
    $y = $_POST["ammount"];
    $newdbdata = $x+$y;
//    echo $y;
//      update to new ammount
    try {
        $sql = $conn->prepare("UPDATE voorraden SET Huidig = :newammount WHERE ProductID = :pid AND LocatieID = :lid");
        $sql->bindParam(":pid", $_POST["prodid4"], PDO::PARAM_INT, 10);
        $sql->bindParam(":lid", $_POST["locid4"], PDO::PARAM_INT, 10);
        $sql->bindParam(":newammount", $newdbdata, PDO::PARAM_INT, 10);
        $sql->execute();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }


    unset($_SESSION["locdata"],$_SESSION["prodamnt"],$_SESSION["locidfin"],$_SESSION["prodidfin"],$_SESSION["modifier"],$_SESSION["proddata"]);
    header("Location: mod-inventory.php?invmod=2");
}

if ($_POST["submit"] == "delinv"){
    try {
        $sql = $conn->prepare("DELETE FROM voorraden WHERE ProductID = :pid AND LocatieID = :lid ");
        $sql->bindParam(":lid", $_SESSION["locid"], PDO::PARAM_INT, 10);
        $sql->bindParam(":pid", $_SESSION["proddata"][1], PDO::PARAM_INT, 10);
        $sql->execute();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
    }
    unset($_SESSION["locdata"],$_SESSION["prodamnt"],$_SESSION["locidfin"],$_SESSION["prodidfin"],$_SESSION["modifier"],$_SESSION["proddata"]);
    header("Location: mod-inventory.php?invmod=3");
}

//    if ($_POST["submit"] == "sendlocinf"){
//        try {
//            $sql = $conn->prepare("SELECT Locatie FROM locaties WHERE LocatieID = :id");
//            $sql->bindParam(":id", $_POST["locid"], PDO::PARAM_INT, 10);
//            $sql->execute();
//            $locinf = $sql->fetchAll();
//        } catch (PDOException $e) {
//            $conn->rollBack();
//            echo $e->getMessage();
//        }
//        $_SESSION["locid"] = $_POST['locid'];
//        $_SESSION["locinfo"] = $locinf[0][0];


//      GET INFO
//    try {
//        $sql = $conn->prepare("SELECT lc.Locatie, pr.Naam, vr.Huidig FROM voorraden as vr
//                                            INNER JOIN producten as pr
//                                            ON pr.ProductID = vr.ProductID
//                                            INNER JOIN locaties as lc
//                                            ON lc.LocatieID = vr.LocatieID
//                                            WHERE pr.ProductID = :pid AND lc.LocatieID = lid");
//        $sql->bindParam(":pid", $_POST["prodid"], PDO::PARAM_INT, 10);
//        $sql->bindParam(":lid", $_POST["locid"], PDO::PARAM_INT, 10);
//        $sql->execute();
//        $sqlinf = $sql->fetchAll();
//    } catch (PDOException $e) {
//        $conn->rollBack();
//        echo $e->getMessage();
//    }
//    $_SESSION["pnaam"] = $sqlinf[0][1];
//    $_SESSION["locnaam"] = $sqlinf[0][0];
//    $_SESSION["aantal"] = $sqlinf[0][2];
//
//    echo var_dump($sqlinf);
//
//    echo $_SESSION["pnaam"];
//    echo $_SESSION["locnaam"];
//    echo $_SESSION["aantal"];


//    header("Location: mod-inventory.php?type=changeinv");



//SELECT lc.Locatie, pr.Naam, vr.Huidig FROM voorraden as vr
//INNER JOIN producten as pr
//ON pr.ProductID = vr.ProductID
//INNER JOIN locaties as lc
//ON lc.LocatieID = vr.LocatieID
//WHERE pr.ProductID = 1;
//
//












//if ($_POST["submit"] == "newitm") {
//    if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != "") {
//        try {
//            $sql = $conn->prepare("INSERT INTO producten (Naam,Type,Fabrikant) VALUES (:naam, :type, :fabrikant)");
//            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 60);
//            $sql->bindParam(":type", $_POST["type"], PDO::PARAM_STR, 60);
//            $sql->bindParam(":fabrikant", $_POST["fabrikant"], PDO::PARAM_STR, 60);
//            $sql->execute();
//        } catch (PDOException $e) {
//            $conn->rollBack();
//            echo $e->getMessage();
//        }
//
//        header("Location: mod-artikelen.php?itmmod=1");
//    } else {
//        $_POST["retnaam"] = $_POST["naam"];
//        $_POST["rettype"] = $_POST["type"];
//        $_POST["retfabr"] = $_POST["fabrikant"];
//        header("Location: mod-artikelen.php?type=new");
//    }
//
//}

//INFO REQUEST
//if ($_POST["submit"] =="requestitminfo"){
//    if ($_POST["itemid"] != ""){
//        try {
//            $sql=$conn->prepare("SELECT Naam,Type,Fabrikant,ProductID FROM producten WHERE ProductID = :id  ");
//            $sql->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
//            $sql->execute();
//            $_SESSION["itminfo"] = $sql->fetchAll()[0];
//        } catch(PDOException $e) {
//            $conn->rollBack();
//            echo $e->getMessage();
//        }
//    header("Location: mod-artikelen.php?type=change");
//    }
//}




//if ($_POST["submit"] == "repitm"){
//    if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != ""){
//        try {
//            $sql=$conn->prepare("UPDATE producten SET Naam = :naam, Type = :type ,Fabrikant = :fabrikant WHERE ProductID = :id");
//            $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 48);
//            $sql->bindParam(":type", $_POST["type"], PDO::PARAM_STR, 48);
//            $sql->bindParam(":fabrikant", $_POST["fabrikant"], PDO::PARAM_STR, 48);
//            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
//            $sql->execute();
//        } catch(PDOException $e) {
//            $conn->rollBack();
//            echo $e->getMessage();
//        }
//        header("Location: Mod-artikelen.php?itmmod=2");
//    }
//
//}



//if ($_POST["submit"] == "deleteitm"){
//    if ($_POST["id"] != ""){
//        try {
//            $sql=$conn->prepare("DELETE FROM `producten` WHERE `producten`.`ProductID` = :id");
//            $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
//            $sql->execute();
//        } catch(PDOException $e) {
//            $conn->rollBack();
//            echo $e->getMessage();
//        }
//        header("Location: Mod-artikelen.php?itmmod=3");
//    }
//}
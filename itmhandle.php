<?php session_start(); require_once("conn.php");

//SUBMIT NEW
if ($_POST["submit"] == "newitm") {
//    send new product
    if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != "" && $_POST["inprijs"] != "" && $_POST["uitprijs"] != "") {
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
// get new product ID
        if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != "" && $_POST["inprijs"] != "" && $_POST["uitprijs"] != "") {
            try {
                $sql = $conn->prepare("SELECT ProductID FROM producten WHERE Naam = :prodnaam AND Type = :soort AND Fabrikant = :fab");
                $sql->bindParam(":prodnaam", $_POST["naam"], PDO::PARAM_STR, 60);
                $sql->bindParam(":soort", $_POST["type"], PDO::PARAM_STR, 60);
                $sql->bindParam(":fab", $_POST["fabrikant"], PDO::PARAM_STR, 60);
                $sql->execute();
                $nitmdta = $sql->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
//        send product vallue
            try {
                $sql = $conn->prepare("INSERT INTO waardes (ProductID,Inkoop,Verkoop) VALUES (:pid, :inkoop, :verkoop)");
                $sql->bindParam(":pid", $nitmdta[0][0], PDO::PARAM_INT, 60);
                $sql->bindParam(":inkoop", $_POST["inprijs"], PDO::PARAM_STR, 60);
                $sql->bindParam(":verkoop", $_POST["uitprijs"], PDO::PARAM_STR, 60);
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
}

//INFO REQUEST
    if ($_POST["submit"] == "requestitminfo") {
        if ($_POST["itemid"] != "") {
            try {
                $sql = $conn->prepare("SELECT pr.Naam,pr.Type,pr.Fabrikant,pr.ProductID,wr.Inkoop,wr.Verkoop FROM producten pr
                                                INNER JOIN waardes wr
                                                ON wr.ProductID = pr.ProductID
                                                WHERE pr.ProductID = :id");
                $sql->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
                $sql->execute();
                $_SESSION["itminfo"] = $sql->fetchAll()[0];
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
        }

        if ($_POST["itemid"] != "") {

            try {
                $sqldel = $conn->prepare("SELECT COUNT(ProductID) FROM voorraden WHERE ProductID = :id");
                $sqldel->bindParam(":id", $_POST["itemid"], PDO::PARAM_STR, 5);
                $sqldel->execute();
                $_SESSION["delcount"] = $sqldel->fetchAll();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
            header("Location: mod-artikelen.php?type=change");
        }
    }


    if ($_POST["submit"] == "repitm") {
//        change item data
        if ($_POST["naam"] != "" && $_POST["type"] != "" && $_POST["fabrikant"] != "") {
            try {
                $sql = $conn->prepare("UPDATE producten SET Naam = :naam, Type = :type ,Fabrikant = :fabrikant WHERE ProductID = :id");
                $sql->bindParam(":naam", $_POST["naam"], PDO::PARAM_STR, 48);
                $sql->bindParam(":type", $_POST["type"], PDO::PARAM_STR, 48);
                $sql->bindParam(":fabrikant", $_POST["fabrikant"], PDO::PARAM_STR, 48);
                $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
                $sql->execute();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
//            change item value
                try {
                    $sql = $conn->prepare("UPDATE waardes SET Inkoop = :inkoop, Verkoop = :verkoop  WHERE ProductID = :id");
                    $sql->bindParam(":inkoop", $_POST["inkoop"], PDO::PARAM_STR, 48);
                    $sql->bindParam(":verkoop", $_POST["verkoop"], PDO::PARAM_STR, 48);
                    $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
                    $sql->execute();
                } catch (PDOException $e) {
                    $conn->rollBack();
                    echo $e->getMessage();
                }
            unset($_SESSION["itminfo"]);
            header("Location: mod-artikelen.php?itmmod=2");
        }

    }

    if ($_POST["submit"] == "deleteitm") {
//        delete values
        if ($_POST["id"] != "") {
            try {
                $sql = $conn->prepare("DELETE FROM `waardes` WHERE `waardes`.`ProductID` = :id");
                $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
                $sql->execute();
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
            }
//        delete item from db
                try {
                    $sql = $conn->prepare("DELETE FROM `producten` WHERE `producten`.`ProductID` = :id");
                    $sql->bindParam(":id", $_POST["id"], PDO::PARAM_STR, 5);
                    $sql->execute();
                } catch (PDOException $e) {
                    $conn->rollBack();
                    echo $e->getMessage();
                }
                unset($_SESSION["itminfo"]);
                header("Location: mod-artikelen.php?itmmod=3");

        }
    }

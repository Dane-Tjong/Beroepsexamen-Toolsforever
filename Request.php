<?php   session_start(); require_once("conn.php");

//if ( isset($_POST["Locatie"])) {
//  $_SESSION["Locatie"] = $_POST["Locatie"];
//    if ( isset($_POST["Item"])) {
//        $_SESSION["Item"] = $_POST["Item"];
//        $_SESSION["sqlq"] = 'SELECT pd.Naam,pd.Type,pd.Fabrikant,vr.huidig as vooraad,wd.verkoop from producten pd INNER JOIN voorraden vr ON pd.ProductID = vr.ProductID INNER JOIN waardes wd ON pd.ProductID = wd.ProductID INNER JOIN locaties lc ON vr.LocatieID = lc.LocatieID WHERE pd.Naam = "'.$_SESSION["Item"].'" AND  lc.Locatie = "'.$_SESSION["Locatie"].'";';
//    }
//}
echo "bruh";
if ( isset($_POST["Locatie"])) {
    $_SESSION["locatie"] = $_POST["Locatie"];
    $_SESSION["Item"] = $_POST["Item"];
    if ($_POST["Item"] == "all") {
//        echo "case 1 all items";
        $sql=$conn->prepare("SELECT pd.Naam,pd.Type,pd.Fabrikant,vr.huidig as vooraad,wd.Inkoop,wd.Verkoop from producten pd
                                            INNER JOIN voorraden vr
                                            ON pd.ProductID = vr.ProductID
                                            INNER JOIN waardes wd
                                            ON pd.ProductID = wd.ProductID
                                            INNER JOIN locaties lc
                                            ON vr.LocatieID = lc.LocatieID
                                            WHERE lc.Locatie = :locatie");
        $sql->bindParam(":locatie", $_SESSION["locatie"], PDO::PARAM_STR, 50);
        $sql->execute();
        $_SESSION["sqlq"] = $sql->fetchAll();


    }elseif($_POST["Item"] != ""){
//        echo "case 2 selected items";
        $sql=$conn->prepare("SELECT pd.Naam,pd.Type,pd.Fabrikant,vr.huidig as vooraad,wd.Inkoop,wd.Verkoop from producten pd
                                            INNER JOIN voorraden vr
                                            ON pd.ProductID = vr.ProductID
                                            INNER JOIN waardes wd
                                            ON pd.ProductID = wd.ProductIDh
                                            INNER JOIN locaties lc
                                            ON vr.LocatieID = lc.LocatieID
                                            WHERE lc.Locatie = :locatie AND pd.Naam = :item");
        $sql->bindParam(":locatie", $_SESSION["locatie"], PDO::PARAM_STR, 50);
        $sql->bindParam(":item", $_SESSION["Item"], PDO::PARAM_STR, 50);
        $sql->execute();
        $_SESSION["sqlq"] = $sql->fetchAll();

    }

}


// $_SESSION["Item"]
// SELECT pd.Naam,pd.Type,pd.Fabrikant,vr.huidig as vooraad,wd.verkoop from producten pd
// INNER JOIN voorraden vr
// ON pd.ProductID = vr.ProductID
// INNER JOIN waardes wd
// ON pd.ProductID = wd.ProductID
// INNER JOIN locaties lc
// ON vr.LocatieID = lc.LocatieID
// WHERE pd.Naam = "testproduct" AND  lc.Locatie = "Test";


$url = "index.php";

header( "Location: $url" );

?>
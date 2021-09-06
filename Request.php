<?php   session_start();

if ( isset($_POST["Locatie"])) {
  $_SESSION["Locatie"] = $_POST["Locatie"];
    if ( isset($_POST["Item"])) {
        $_SESSION["Item"] = $_POST["Item"];
        $_SESSION["sqlq"] = 'SELECT pd.Naam,pd.Type,pd.Fabrikant,vr.huidig as vooraad,wd.verkoop from producten pd INNER JOIN voorraden vr ON pd.ProductID = vr.ProductID INNER JOIN waardes wd ON pd.ProductID = wd.ProductID INNER JOIN locaties lc ON vr.LocatieID = lc.LocatieID WHERE pd.Naam = "'.$_SESSION["Item"].'" AND  lc.Locatie = "'.$_SESSION["Locatie"].'";';
    }
}


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
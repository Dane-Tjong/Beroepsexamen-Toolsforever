<?php session_start(); require_once("conn.php");

if (ISSET($_POST["uname"]) !="" ) {
if ($_POST["pword"] !="") {
    
    //check for username in DB and get the pin linked to it
    try {
        $sql=$conn->prepare('SELECT * FROM medewerkers WHERE username = "'.$_POST["uname"].'" AND pin = "'.$_POST["pword"].'"');
        $sql->execute();
        $dbloc = $sql->fetch();
            } catch(PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
        }
    }
}

if ($_POST["uname"] == "") {
    header("Location: login.php");
}else if ($_POST["pword"] == "") {
    $_SESSION["s-un"] = $_POST["uname"];
    $_SESSION["fail"] = "Failed to login, try again";
    header("Location: login.php");
}else{
 if ($dbloc == false) {
    header("Location: login.php");
 }else{
     if ($dbloc["username"] == $_POST["uname"] & $dbloc["pin"] == $_POST["pword"]){
        $_SESSION["username"]=$_POST["uname"];
        $_SESSION["loggedin"]= true;
        $_SESSION["dbloc"] = $dbloc;
        $_SESSION["loggedin"]= true;
        header("Location: index.php");
     }else{
        header("Location: login.php");
    }
 }


}




?>
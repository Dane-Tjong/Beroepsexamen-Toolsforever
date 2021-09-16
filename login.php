<?php session_start(); require_once("conn.php");

if (ISSET($_POST["uname"]) !="" ) {
    if ($_POST["pword"] !="") {
        
        //check for username in DB and get the pin linked to it
        try {
            $sql=$conn->prepare('SELECT username, pin FROM medewerkers WHERE username = "'.$_POST["uname"].'" AND pin = "'.$_POST["pword"].'"');
            $sql->execute();
            $dbloc = $sql->fetch();
                } catch(PDOException $e) {
                    $conn->rollBack();
                    echo $e->getMessage();
                }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pagina</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div>
    <div id="container">
        <img src="logo.png" style="width: 250px;">
            <fieldset>
        <form method="POST" action="logsec.php" id="LogForm">
        <label for="fname">Gebruikersnaam:</label><br>
            <input type="text" id="uname" name="uname" <?php echo "value=\"".ISSET($_SESSION["s-un"])."\""; ?>><br>
            <label for="pword">Pin:</label><br>
            <input type="password" id="pword" name="pword">
        </form>
        <button type="submit" form="LogForm" value="Submit" style="margin-top: 5px;">Inloggen</button>
            </fieldset>
        <?php echo ISSET($_SESSION["fail"]) ?>
    </div>

</div>
<?php

// echo var_dump($dbloc)."<br>";
// echo $dbloc["username"]."<br>";
// echo $dbloc["pin"];
// ?>

</body>
</html>
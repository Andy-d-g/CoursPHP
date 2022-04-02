<?php
    session_start();

    $idUrl = "";
    $redirection = "Location: ./";
    $username = "username";
    $password = "password";

    if (isset($_GET['id'])) {
        $idUrl = "?id=" . $_GET['id'];
        $redirection = 'Location: ./delete.php?id=' . $_GET['id'];
    }

    if (isset($_SESSION["loggedin"])) {
        if ($_SESSION["logeddin"] == true) { 
            header($redirection); 
        }
    }

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($_POST["username"] == $username && $_POST["password"] == $password) {
            $_SESSION["loggedin"] = true;
            header($redirection);
        } else {
            echo "Bad crendentials";
        }
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link href="./css/styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h3>Login</h3>
            <a class="btn" href="./index.php">Voir les images</a>
            <a class='btn' href='./arborescence.php?file=../images'>Voir l'arborescence des images</a>
        </header>
        <div class="center">
            <?php
                echo '<form action="./login.php' . $idUrl . '" method="POST" enctype="multipart/form-data">'
            ?>
                <input type="text" placeholder="username" name="username" id="username">
                <br>
                <input type="text" placeholder="password" name="password" id="password">
                <br>
                <input type="submit" value="Login">
            </form>
        </div>
    </body>
</html>
<?php
    # Login to db
    function login_db() {
        # Identifier
        $servername = "localhost";
        $username = "";
        $password = "";
        $dbname = "test";
                
        # Connection
        $db = new mysqli($servername, $username, $password, $dbname);
        # Handle error (if error)
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        # Return db instance
        return $db;
    }

    # Logout to db
    function logout_db($db) {
        # Close db connexion
        $db->close();
    }

    function delete_by_id($db, $id) {
        $sql = "DELETE FROM `galerie` WHERE id='" . $id . "'";
        $result = $db->query($sql);
    }

    session_start();

    if (isset($_GET['id'])) {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
            header('Location: ./login.php?id=' . $_GET['id']);
        } else {
            print_r($_SESSION);
            $db = login_db();
            delete_by_id($db, $_GET['id']);
            logout_db($db);
            header('Location: ./');
        }

    } else {
        header('Location: ./');
    }
?>
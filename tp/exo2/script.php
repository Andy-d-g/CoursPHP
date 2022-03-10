<?php
    function login_db() {
        # Identifier
        $servername = "localhost";
        $username = "";
        $password = "";
        $dbname = "test";
        
        # connection
        $db = new mysqli($servername, $username, $password, $dbname);
        # Handle error (if error)
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        # Return db instance 
        return $db;
    }

    function logout_db($db) {
        # Logout from db
        $db->close();
    }

    function insert_db($db, $path, $name) {    
        # SQL request to add a new file to the db
        $sql = "INSERT INTO galerie (id, path, name) VALUES (NULL, '" . $path . "', '" . $name . "')";

        # Send request
        $result = $db->query($sql);

        # If successful : ok, else : ko
        if ($result) echo "Fichier ajouté : ok";
        else echo "Fichier ajouté : ko";
    }

    # If there is a file
    if ($_FILES['filename']['size'] > 0) {
        # Get his path
        $filePath = realpath($_FILES["filename"]["tmp_name"]);
        # Get his name
        $fileName = $_FILES['filename']['name'];
        # Login
        $db = login_db();
        # Injection
        insert_db($db, $filePath, $fileName);
        # Logout
        logout_db($db);
    }
    # If there is not a file
    else {
        echo "Pas de fichier trouver";
    }
?>
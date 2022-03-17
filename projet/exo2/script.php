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

    function insert_db($db, $type, $name, $width, $height, $path) {    
        # SQL request to add a new file to the db
        $sql = "INSERT INTO galerie (id, name, type, width, height, path) VALUES (NULL, '" . $name . "', '" . $type . "', '" . $width . "', '" . $height . "', '" . $path . "')";
        # Send request
        $result = $db->query($sql);
        # If successful : ok, else : ko
        if ($result) echo "Fichier ajouté : ok";
        else echo "Fichier ajouté : ko";
    }



    # If there is a file
    if (isset($_FILES['filename'])) {
        if ($_FILES['filename']['size'] > 0 && $_FILES['filename']['error'] == 0) {
            # Get his path
            $filePath = realpath($_FILES["filename"]["tmp_name"]);
            # Get file sub name
            $fileSubName = array_reverse(explode("/", $filePath))[0];
            # Get his name
            $fileName = $_FILES['filename']['name'];
            # Get file sub path
            $fileSubPath = "../images/" . $fileSubName . "-" . $fileName;
            # Get type of image
            $type = $_FILES['filename']['type'];
            # Get image size
            $size = getimagesize($filePath);
            $width = $size['0'];
            $height = $size['1'];
            # Login
            $db = login_db();
            # Move upload file into different folder
            move_uploaded_file($filePath, $fileSubPath);
            # Injection
            insert_db($db, $type, $fileName, $width, $height, $fileSubPath);
            # Logout
            logout_db($db);
        }
        # If error
        else {
            echo "Pas de fichier trouver";
        }
    }
    # If there is not a file
    else {
        echo "Pas de fichier trouver";
    }
?>
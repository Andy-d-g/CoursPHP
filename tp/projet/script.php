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

    function insert_db($db, $data, $type, $name, $width, $height, $path) {    
        # SQL request to add a new file to the db
        $sql = "INSERT INTO galerie (id, data, name, type, width, height, path) VALUES (NULL, '" . $data . "', '" . $name . "', '" . $type . "', '" . $width . "', '" . $height . "', '" . $path . "')";
        # Send request
        $result = $db->query($sql);

        # If successful : ok, else : ko
        if ($result) echo "Fichier ajouté : ok";
        else echo "Fichier ajouté : ko";
    }

    $upload = 0;

    # If there is a file
    if (isset($_FILES['filename'])) {
        if ($_FILES['filename']['size'] > 0 && $_FILES['filename']['error'] == 0) {
            # Get his path
            $filePath = realpath($_FILES["filename"]["tmp_name"]);
            # Get his name
            $fileName = $_FILES['filename']['name'];
            # Get type of image
            $type = $_FILES['filename']['type'];
            # Get image size
            $size = getimagesize($filePath);
            $width = $size['0'];
            $height = $size['1'];
            # Get his content
            $content = file_get_contents($filePath);
            # Convert his content to base64
            $base64 = base64_encode($content);
            # Login
            $db = login_db();
            # Injection
            insert_db($db, $base64, $type, $fileName, $width, $height, $filePath);
            # Logout
            logout_db($db);
            
            $upload = 1;
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
    header('Location: ./?upload=' . $upload);      
?>
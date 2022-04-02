<!DOCTYPE html>

<html>
    <head>
        <title>Arboresence</title>
        <link href="./css/styles.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            # Starter directory 
            # Ne pas oublier le "/" à la fin du $dir
            $dir = "../images/";
            $download = false;
            if (isset($_GET['file'])) {
                $dir = $_GET['file'];
            }
            if (isset($_GET['download'])) {
                $download = (int)$_GET['download'];
            }

            # List of extensions to search
            $extensions = ['jpg', 'jpeg', 'png'];
        ?>
        <a class="btn" href="./form.php">Ajouter des images</a>
        <a class="btn" href="./index.php">Voir les images</a>
        <?php
            echo "<a class='btn' href='./arborescence.php?file=" . $dir . "&download=1'>Telecharger toute les images detectés</a>"
        ?>
        
        <h3>Liste vos fichiers et dossiers depuis <?php echo $dir ?></h3>
        <?php
            function formatExtension($extensions) {
                $str = " [";
                for ($i = 0; $i < count($extensions); $i++) {
                    $str .= strtoupper($extensions[$i]) . " ";
                    if ($i+1 != count($extensions)) {
                        $str .= "/ ";
                    }
                }
                $str .= "FILE DETECTED]";
                return $str;
            }
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

            function insert_db($db, $type, $name, $width, $height, $path) {    
                # SQL request to add a new file to the db
                $sql = "INSERT INTO galerie (id, name, type, width, height, path) VALUES (NULL, '" . $name . "', '" . $type . "', '" . $width . "', '" . $height . "', '" . $path . "')";
                # Send request
                $result = $db->query($sql);
                # If successful : ok, else : ko
                if ($result) echo "Fichier ajouté : ok";
                else echo "Fichier ajouté : ko";
            }

            # display element in function of his depth 
            function displayDepth($dir, $file, $depth, $isDir, $extensions, $db) {
                $space = 25;
                # If directory : -->
                if ($isDir) {
                    echo "<p style='padding-left:" . $depth*$space . "px'>directory : " . $file . "</p>";
                } 
                # Else : -  
                else {
                    # Get file extension
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array(strtolower($extension), $extensions)) {
                        if ($db) {
                            $imageSize = getimagesize($dir . "/" . $file);
                            $width = $imageSize['0'];
                            $height = $imageSize['1'];
                            $type = $imageSize['mime'];
                            insert_db($db, $type, $file, $width, $height, $dir . "/" . $file);
                        }
                        echo "<p style='padding-left:" . $depth*$space . "px'>file : " . $file . formatExtension($extensions) ."</p>";
                    } else {
                        echo "<p style='padding-left:" . $depth*$space . "px'>file : " . $file . "</p>";
                    }
                }
            }
            # Browse every files and folder without . and ..
            function listDirFilesInDepth($dir, $depth, $extensions, $db) {
                # Get list of file and folder from current dir
                $files = scandir($dir);
                # For each file / folder
                foreach($files as $file) {
                    # If directory
                    if (is_dir($dir . '/' . $file)) {
                        # If it's not . or ..
                        if ($file != '.' && $file != '..') {
                            # Display the directory name
                            displayDepth($dir, $file, $depth, true, $extensions, $db);
                            # Launch again the function for the next depth
                            listDirFilesInDepth($dir . $file . '/', $depth+1, $extensions, $db);
                        }
                    }
                    # If file
                    else {
                        # Display the file name
                        displayDepth($dir, $file, $depth, false, $extensions, $db);
                    }
                }
            }

            # Launch the main function
            $db = login_db();
            listDirFilesInDepth($dir, 1, $extensions, $download ? $db : false);
            logout_db($db);
        ?>
    </body>
</html>
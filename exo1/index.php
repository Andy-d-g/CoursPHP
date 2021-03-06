<!DOCTYPE html>

<html>
    <head>
        <title>Arboresence</title>
    </head>
    <body>
        <?php 
            # Starter directory 
            # Ne pas oublier le "/" à la fin du $dir
            $dir = "../images/";

            # List of extensions to search
            $extensions = ['jpg', 'jpeg', 'png'];
        ?>
        <h3>Liste vos fichiers et dossiers depuis <?php echo $dir ?></h3>
        <?php
            # display element in function of his depth 
            function displayDepth($file, $depth, $isDir, $extensions) {
                # If directory : -->
                if ($isDir) {
                    echo "<p style='padding-left:" . $depth*10 . "px'>-> " . $file . "</p>";
                } 
                # Else : -  
                else {
                    # Get file extension
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($extension, $extensions)) {
                        echo "<p style='padding-left:" . $depth*10 . "px'>-  " . $file . " [JPG/JPEG/PNG FILE DETECTED]</p>";
                    } else {
                        echo "<p style='padding-left:" . $depth*10 . "px'>-  " . $file . "</p>";
                    }
                }
            }
            # Browse every files and folder without . and ..
            function listDirFilesInDepth($dir, $depth, $extensions){
                # Get list of file and folder from current dir
                $files = scandir($dir);
                # For each file / folder
                foreach($files as $file) {
                    # If directory
                    if (is_dir($dir . '/' . $file)) {
                        # If it's not . or ..
                        if ($file != '.' && $file != '..') {
                            # Display the directory name
                            displayDepth($file, $depth, true, $extensions);
                            # Launch again the function for the next depth
                            listDirFilesInDepth($dir . $file . '/', $depth+1, $extensions);
                        }
                    }
                    # If file
                    else {
                        # Display the file name
                        displayDepth($file, $depth, false, $extensions);
                    }
                }
            }

            # Launch the main function
            listDirFilesInDepth($dir, 1, $extensions);
        ?>
    </body>
</html>
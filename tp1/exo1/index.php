<!DOCTYPE html>

<html>
    <head>
        <title>Exo1 - arboresence</title>
    </head>
    <body>
        <?php
            # Affiche l'element en fonction de son niveau de profondeur dans l'arboresence
            function displayDepth($value, $depth) {
                for ($i = 0; $i < $depth; $i++) {
                    echo "--";
                }
                echo ">  ";
                echo $value;
            }
            # Parcours les dossiers vers le bas depuis le $dir initial
            # (ne prend pas en compte . et .. qui font revenir en arrière)
            function listDirFilesInDepth($dir, $depth){
                # Recupere la liste des fichiers \ dossier
                $files = scandir($dir);
                # Pour chaque fichiers
                foreach($files as $file) {
                    # Si c'est un dossier
                    if (is_dir($file) == true) {
                        # Si c'est pas le type de fichier qui fais revenir en arrière
                        if ($file != '.' && $file != '..') {
                            # Affiche le nom du dossier en fonction de sa profondeur
                            displayDepth($file, $depth);
                            # Relance la fonction pour refaire le meme travail sur le nouveau directory
                            listDirFilesInDepth($file, $depth+1);
                        }
                    }
                    # Si c'est un fichier
                    else {
                        # Affiche le nom du fichier en fonction de sa profondeur
                        displayDepth($file, $depth);
                        # Si c'est un fichier .jpg : indique qu'il est detecté
                        if (pathinfo($file, PATHINFO_EXTENSION) == "jpg") {
                            echo "\t[JPG FILE DETECTED]";
                        }
                    }
                    # Saut de ligne
                    echo "<br>";
                }
            }
            
            $dir = "./";
            listDirFilesInDepth($dir, 1);
        ?>
    </body>
</html>
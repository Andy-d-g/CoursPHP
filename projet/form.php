<!DOCTYPE html>

<html>
    <head>
        <title>Projet</title>
        <link href="./css/styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h3>Search and import</h3>
            <a class="btn" href="./index.php">Voir les images</a>
            <a class='btn' href='./arborescence.php?file=../images'>Voir l'arborescence des images</a>
        </header>
        <div class="center">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="filename" class="label-file">Choisir une image [.jpg, .jpeg, .png]</label>
                <br>
                <input type="file" id="filename" name="filename[]" accept='.jpg, .jpeg, .png' multiple>
                <br>
                <input type="submit" value="Upload">
            </form>
        </div>
    </body>
</html>
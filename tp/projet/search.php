<!DOCTYPE html>

<html>
    <head>
        <title>Projet</title>
        <link href="./styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h3>Search and import</h3>
        </header>
        <div class="center">
            <form action="script.php" method="POST" enctype="multipart/form-data">
                <label for="filename" class="label-file">Choisir une image [.jpg, .jpeg, .png]</label>
                <br>
                <input type="file" id="filename" name="filename" accept='.jpg, .jpeg, .png'>
                <br>
                <input type="submit" value="Upload">
            </form>
        </div>
    </body>
</html>
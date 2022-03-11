<!DOCTYPE html>

<html>
    <head>
        <title>Televersement</title>
        <link href="./styles.css" rel="stylesheet">
    </head>
    <body>
        <h1>Upload de ficher</h1>
        <form action="script.php" method="POST" enctype="multipart/form-data">
            <label for="filename" class="label-file">Choisir une image [.jpg, .jpeg, .png]</label>
            <br>
            <input type="file" id="filename" name="filename" accept='.jpg, .jpeg, .png'>
            <br>
            <input type="submit" value="Upload">
        </form>
    </body>
</html>
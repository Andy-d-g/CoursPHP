<!DOCTYPE html>

<html>
    <head>
        <title>Projet</title>
        <link href="./css/styles.css" rel="stylesheet">
    </head>
    <body>
        <header style='text-align:center;'>
            <h3>Galerie d'image</h3>
            <div>
                <a class="btn" href="./form.php">Ajouter des images</a>
                <a class='btn' href='./arborescence.php?file=../images'>Voir l'arborescence des images</a>
            </div>
        </header>
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
            
            # Get user
            function get_images($db, $pagination, $image_by_page) {
                # Index to start inside the db
                $start_index = $pagination*$image_by_page;
                
                # SQL request to select $user_by_page from $start_index
                $sql = "SELECT * FROM galerie ORDER BY id DESC LIMIT " . $image_by_page . " OFFSET " . $start_index;

                # Send request
                $result = $db->query($sql);
                
                return $result;
            }

            # Display user
            function display_images($images) {
                $i = 0;
                # If there is some user to display
                if ($images->num_rows > 0) {
                    # For each row
                    echo "<main>";
                    echo "<div>";
                    while($row = $images->fetch_assoc()) {
                        # Display row
                        if ($i % 3 == 0 && $i != 0) {
                            echo "</div>";
                            echo "<div>";
                        }
                        echo "<a style='border:none;' href='./delete.php?id=" . $row['id'] . "'>";
                        echo "<img id-value='" . $row['id'] . "' src='" . $row['path'] . "' alt='" . $row['name'] . "' />";
                        echo "</a>";
                        $i++;
                    }
                    echo "</div>";
                    echo "</main>";
                }
                echo "<br>";
            }

            # Get the total number of user
            function get_image_number($db) {
                # SQL request to get the number of row inside user table
                $sql = "SELECT count(*) as total FROM galerie";

                # Send request
                $result = $db->query($sql);

                # Return number of user inside db
                return $result->fetch_assoc()['total'];
            }

            # Display link + button for pagination
            function display_pagination($user_number, $image_by_page, $pagination) {
                echo "<footer>";
                if ($pagination > 0) {
                    echo "<a class='btn' href='./?pagination=" . $pagination-1 . "'>Precedent</a>";
                }
                for ($i = 0; $i < $user_number/$image_by_page; $i++) {
                    echo "<a href='./?pagination=" . $i . "'>" . $i . "</a>";
                }
                if ($pagination * $image_by_page < $user_number-$image_by_page) {
                    echo "<a class='btn' href='./?pagination=" . $pagination+1 . "'>Suivant</a>";
                }
                echo "</footer>";
            }

            # User to display by page
            $image_by_page = 6;

            # Connection
            $db = login_db();

            if (isset($_GET['upload'])) {
                if ($_GET['upload'] == 1) {
                    echo "<h3 style='color: green;'>FICHIER UPLOADÉ CORRECTEMENT</h3>";
                } else {
                    echo "<h3 style='color: red;'>ERREUR LORS DE L'UPLOAD</h3>";
                }
            }

            # Get pagination number
            $pagination = isset($_GET['pagination']) ? $_GET['pagination'] : 0;

            # Get user 
            $images = get_images($db, $pagination, $image_by_page);

            # Get total number of user
            $size = get_image_number($db);

            # Display user
            display_images($images);

            # Display pagination
            display_pagination($size, $image_by_page, $pagination);
            
            # Deconnexion
            logout_db($db);
        ?>

    </body>
</html>
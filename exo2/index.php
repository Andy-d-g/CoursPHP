<!DOCTYPE html>

<html>
    <head>
        <title>Exo2 - DB - Pagination</title>
    </head>
    <body>
        <?php
            # Fonction pour se connecter a la db
            function login_db() {
                # Indentifiant
                $servername = "localhost";
                $username = "";
                $password = "";
                $dbname = "test";
                
                # Connexion
                $conn = new mysqli($servername, $username, $password, $dbname);
                # Handle error (if error)
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                echo "Connexion : ok";
                echo "<br><br>";
                # Return instance of db
                return $conn;
            }

            function logout_db($conn) {
                # Close db connexion
                $conn->close();
                echo "<br>";
                echo "Connexion : ko";
                echo "<br>";
            }
            
            function get_user($conn, $pagination) {
                # Nombre d'utilisateur à afficher par page
                $user_by_page = 2;
                
                # Select tout de la table user en en recuperant que $user_by_page à partir de $pagination*$user_by_page
                $sql = "SELECT * FROM user LIMIT " . $user_by_page . " OFFSET " . $pagination*$user_by_page;
                # Envoie la requete a la db
                $result = $conn->query($sql);
                
                # Si il y a un resultat
                if ($result->num_rows > 0) {
                    # Tant qu'il y a des lignes
                    while($row = $result->fetch_assoc()) {
                        # Affiche chaque ligne
                        echo $row["id"] . " - " . $row["nom"] . " " . $row["prenom"] . " - " . $row["email"] . "<br>";
                    }
                } else {
                    echo "0 results";
                }
            }

            function displayDBWithPagination() {
                # Connexion
                $conn = login_db();
                if (!is_null($_GET['pagination'])) {
                    # Recuperation de la page a afficher 
                    $pagination = $_GET['pagination'];
                    # Recuperer de la liste d'utilisateur
                    get_user($conn, $pagination);
                }
                # Deconnexion
                logout_db($conn);
            }
            
            displayDBWithPagination();
        ?>
    </body>
</html>
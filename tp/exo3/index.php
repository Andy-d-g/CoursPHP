<!DOCTYPE html>

<html>
    <head>
        <title>DB - Pagination</title>
        <link href="./styles.css" rel="stylesheet">
    </head>
    <body>
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
            function get_user($db, $pagination, $user_by_page) {
                # Index to start inside the db
                $start_index = $pagination*$user_by_page;
                
                # SQL request to select $user_by_page from $start_index
                $sql = "SELECT * FROM user LIMIT " . $user_by_page . " OFFSET " . $start_index;

                # Send request
                $result = $db->query($sql);
                
                return $result;
            }

            # Display user
            function display_user($users) {
                # If there is some user to display
                if ($users->num_rows > 0) {
                    # For each row
                    echo "<table>";
                    echo "<tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                        </tr>";
                    while($row = $users->fetch_assoc()) {
                        # Display row
                        echo "<tr>
                                <td>" . $row['nom'] . "</td>
                                <td>" . $row['prenom'] . "</td>
                                <td>" . $row['email'] . "</td>
                            </tr>";
                    }
                    echo "</table>";
                }
            }

            # Get the total number of user
            function get_user_number($db) {
                # SQL request to get the number of row inside user table
                $sql = "SELECT count(*) as total FROM user";

                # Send request
                $result = $db->query($sql);

                # Return number of user inside db
                return $result->fetch_assoc()['total'];
            }

            # Display link + button for pagination
            function display_pagination($user_number, $user_by_page, $pagination) {
                if ($pagination > 0) {
                    echo "<a class='btn' href='./?pagination=" . $pagination-1 . "'>Precedent</a>";
                }
                for ($i = 0; $i < $user_number/$user_by_page; $i++) {
                    echo "<a href='./?pagination=" . $i . "'>" . $i . "</a>";
                }
                if ($pagination * $user_by_page < $user_number-$user_by_page) {
                    echo "<a class='btn' href='./?pagination=" . $pagination+1 . "'>Suivant</a>";
                }
            }

            # User to display by page
            $user_by_page = 2;

            # Connection
            $db = login_db();

            # Get pagination number
            $pagination = isset($_GET['pagination']) ? $_GET['pagination'] : 0;

            # Get user 
            $users = get_user($db, $pagination, $user_by_page);

            # Get total number of user
            $size = get_user_number($db);

            # Display user
            display_user($users);

            # Display pagination
            display_pagination($size, $user_by_page, $pagination);
            
            # Deconnexion
            logout_db($db);
        ?>
    </body>
</html>
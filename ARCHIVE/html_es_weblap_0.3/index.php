<!DOCTYPE HTML>

<html lang="hu">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="refresh" content="45">

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="meter.png">
        <title>
            IoT Mérők
        </title>
    </head>
    <header>
        <div class="topnav">
            <a class="active" href="index.php">Főoldal</a>
            <a href="page2.php">Hisztorikus adatok</a>
            <a href="page3.html">Információ</a>
            <a href="page4.html">Extra</a>
          </div>
    </header>
    <body>
        <div class="body">
            <h1>IoT Mérők</h1>
            Schneider PM5340 fogyasztásmérő monitorozó oldal 
            <br>

            <h2>Pillanatnyi adatok</h2>
            <br>
            <br>

            <table>
                <thead>
                    <tr>
                        <td>I1</td>
                        <td>I2</td>
                        <td>I3</td>
                        <td>U1</td>
                        <td>U2</td>
                        <td>U3</td>
                        <td>P</td>
                        <td>Q</td>
                        <td>S</td>
                        <td>f</td>
                        <td>IEC</td>
                        <td>P</td>
                        <td>Q</td>
                        <td>S</td>
                    </tr>
                </thead>


                <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "adatbazis";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $sql = "SELECT * FROM pillanatnyi";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }


                // soronkenti adatkiolvasas
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["datum"] . "</td>";
                    echo "<td>" . $row["register_id"] . "</td>";
                    echo "<td>" . $row["meres"] . "</td>";
                    echo "<td>" . $row["eszkoz_id"] . "</td>";
                    echo "</tr>";
                
                }
                ?>
                </tbody>
            </table>

        </div>
    </body>

</html>
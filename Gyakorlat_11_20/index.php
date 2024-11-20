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
                    <th>Idő és datum</th>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "adatbazis";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $sql = "SELECT * FROM tulajdonsagok";
                $result = $connection->query($sql);
                
                
                

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }


                // soronkenti adatkiolvasas
                while($column = $result->fetch_assoc()) {

                    echo "<th>";
                   
                    echo $column["megnevezes"]. " [". $column["mertekegyseg"]. "]". "<br>";
                    
                    echo "</th>"; 
            
                    }

                    



                ?>
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

                
                $sql2 = "SELECT * FROM pillanatnyi";
                $sql3 = "SELECT * FROM pillanatnyi";

                
                
                $result2 = $connection->query($sql2);
                $result3 = $connection->query($sql3);

                $x=0;

                while($asd = $result3->fetch_assoc() and $x < 1 ) {

                    echo "<td>";
                    echo $asd["datum"]."<br>";
                    echo "</td>";     
                    
                    $x++;
            
                    }

                // soronkenti adatkiolvasas
                while($row = $result2->fetch_assoc() ) {

                    
                      
                    echo "<td>";
                    echo $row["meres"]."<br>";
                    echo "</td>";     
                    
            
                    }

                    



                ?>
                </tbody>
            </table>




            <br>



        </div>
    </body>

</html>
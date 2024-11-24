<!DOCTYPE html>

<html lang="hu">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="refresh" content="45">

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="meter.png">
        <title>
            Hisztorikus adatok
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
        <h1>Hisztorikus adatok</h1>
        <br>
        <button onclick="document.location='adatbazis.csv'">Adatok letöltése CSV-ben</button>
        <table>
            <thead>
                
            <th>Datum es ido</th>
            <th>U1 [V]</th>
            <th>U2 [V]</th>
            <th>U3 [V]</th>
            <th>I1 [A]</th>
            <th>I2 [A]</th>
            <th>I3 [A]</th>
            <th>P [kW]</th>
            <th>Q [kVAR]</th>
            <th>S [kVA]</th>
            <th>f [Hz]</th>
            <th>IEC</th>
            <th>P [kWh]</th>
            <th>Q [kVARh]</th>
            <th>S [kVAh]</th>
                
            </thead>


            <tbody>
            
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "adatbazis";

            $connection = new mysqli($servername, $username, $password, $database);

           
            $sql1 = "SELECT datum FROM hisztorikus WHERE register_id=3028";
            $datum = $connection->query($sql1);
            
        
            while($row = $datum->fetch_assoc()) {
                $date = $row["datum"];

                $sql2 = "SELECT meres FROM hisztorikus WHERE datum = ?";
                $stmt = $connection->prepare($sql2);
                $stmt->bind_param("s", $date);  
                $stmt->execute();
                $adat = $stmt->get_result();

                $adatok = [];
                $i=0;
                echo "<tr>";
                echo "<td>" . $date . "</td>";
                while($row2 = $adat->fetch_assoc()){
                    if($i <14){
                    $adatok[]=$row2['meres'];

                    
                    
                    echo "<td>". $adatok[$i] ."</td>";
                    
                    $i++;}
                    else{ break; }
                }
                echo"</tr>";   
                    
            }
            
            
            
            

            
           
            ?>
            </tbody>
        </table>
        <br>
        <br>
</div>
</body>
</html>

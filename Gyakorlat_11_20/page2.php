<!DOCTYPE html>

<html lang="hu">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta http-equiv="refresh" content="45">-->


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
            <a href="page4.php">Extra</a>
          </div>
    </header>
<body>
    <div class="body">
        <h1>Hisztorikus adatok</h1>
        <br>

        <div class="button-container">

        <form method="post" action="">
                <label for="start_date">Kezdő dátum:</label>
                <input type="date" id="start_date" name="start_date" class="datepicker">
                <span>
                <label for="stop_date">Záró dátum:</label>
                <input type="date" id="stop_date" name="stop_date" class="datepicker">
                <input type="submit" value="OK" class="button4">
                
        </form>
        <span class="wide">
        <button type="button" class="button minden-button">Minden adat</button>
        <span>
        <button type="button" class="button open-button">Exportálás</button>
        </div>

        <dialog class="modal" id="modal">
            <h2>Adatok exportálása</h2>

            <div class="button-container">
                <form method="post" action="csv_export.php">
                    <button class="button3" type="submit" name="export" value="CSV Export">CSV Export</button>
                </form>
                <span></span>
                <button class="button2 open-button2">PDF Exportálás</button>
            </div>
            <br>
            <button class="button close-button">Vissza</button>

            </dialog>

            <dialog class="modal" id="modal2">
            <h2>Exportálás PDF-be</h2>

            
                <form method="post" action="pdf_export_portrait.php">
                    <button class="button2" type="submit" name="export" value="PDF Export Portrait">Álló</button>
                </form>
                <p>Betűméret: 6</p>
                <br>
                <form method="post" action="pdf_export_landscape.php">
                    <button class="button2" type="submit" name="export" value="PDF Export Landscape">Fekvő</button>
                </form>
                <p>Betűméret: 8</p>
                <br>
            
            <br>
            <div class="button-container">
                <button class="button close-button2">Vissza</button>
                <button class="button close-button3">Bezárás</button>
            </div>

            </dialog>

            <dialog class="modal" id="modal4">
            <h2>Minden hisztorikus adat</h2>
            <br>
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
            <button class="button close-button4">Vissza</button>

            </dialog>

            <script src="page2_script.js"></script>





                
        
        <br><br>





        <br><br>
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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Capture the input and store it in the $start_date variable
                $start_date = $_POST['start_date'];
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Capture the input and store it in the $start_date variable
                $stop_date = $_POST['stop_date'];
            }

            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "adatbazis";

            $connection = new mysqli($servername, $username, $password, $database);

           
            $sql1 = "SELECT datum FROM hisztorikus WHERE register_id=3028 AND datum BETWEEN '$start_date 00:00:00' AND '$stop_date 23:59:59'";
            $datum = $connection->query($sql1);
            
        
            while($row = $datum->fetch_assoc()) {
                $date = $row["datum"];

                $sql2 = "SELECT meres FROM hisztorikus WHERE datum = ? AND datum BETWEEN '$start_date 00:00:00' AND '$stop_date 23:00:00'";
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
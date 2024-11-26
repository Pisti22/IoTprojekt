<?php  
if(isset($_POST["export"]))  
{  
    // Adatbazishoz csatlakozas
    $connect = mysqli_connect("localhost", "root", "", "adatbazis");  
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // CSV Header
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=hisztorikus_adatok_export.csv');  
    $output = fopen("php://output", "w");  

    // Statikus header 
    fputcsv($output, array('Datum', 'U1', 'U2', 'U3', 'I1', 'I2', 'I3', 'P', 'Q', 'S', 'f', 'IEC', 'P', 'Q', 'S'));

    // Adatok lekerdezese
    $sql1 = "SELECT DISTINCT datum FROM hisztorikus WHERE register_id=3028";
    $datum_result = mysqli_query($connect, $sql1);
    
    if ($datum_result) {
        while($row = mysqli_fetch_assoc($datum_result)) {
            $date = $row["datum"];
            
            $sql2 = "SELECT meres FROM hisztorikus WHERE datum = ?";
            $stmt = $connect->prepare($sql2);
            $stmt->bind_param("s", $date);  
            $stmt->execute();
            $adat_result = $stmt->get_result();
     
            $adatok = [$date];  // Elso oszlop
            
            $i = 0;
            while($row2 = $adat_result->fetch_assoc()) {
                if ($i < 14) {
                    $adatok[] = $row2['meres'];  
                    $i++;
                } else {
                    break;  
                }
            }
            
            // Ellenorzes, hogy minden sor 15 db adatot tartalmaz
            while (count($adatok) < 15) {
                $adatok[] = null;  // Ha nincs 15, a maradek feltoltese semmivel
            }
            
            // A sorok kiirasa a CSV-be
            fputcsv($output, $adatok);
        }
    } else {
        echo "Error in date query: " . mysqli_error($connect);
    }
    
    fclose($output); 
    mysqli_close($connect);
}  
?>

<?php
echo "<h2>Filmsuche</h2>";
echo "<br>";
echo "<form method=post>";

// Function wird Aufgerufen um Label und Type Box Auszugeben - Value Wert bleibt erhalten nach Button klick
makeTypeBoxValueStayProduktionsfirmaRequired("Suche Film nach Produktionsfirma: ", "produktionsfirma", "text", null, "zb.: Harry Potter");

// Ausgabe eines Buttons Suchen
echo '<button type="submit" name="searchFilm">Suchen</button>';
// Ausgabe eines Buttons Abbrechen
echo '<button type="submit" name="cancelSearch">Abbrechen</button>';

// Wenn Button searchFilm gedrückt wird
if(isset($_POST["searchFilm"])){
    try{

        $sqlCount = "select count(*) from film f
                        natural left join produktionsfirma p
                        where p.prf_name like '%".$_POST["produktionsfirma"]."%'";
        $count = makeStatement($sqlCount);

        while($row = $count->fetch(PDO::FETCH_NUM)){
            foreach ($row as $r){
                // Wenn r nicht 0 ist Ausgabe der Suche, wenn aber 0 zurück kommt Fehlermeldung
                if($r != "0"){
                    $sql = "select f.fim_titel as 'Titel', f.fim_erscheinungsdatum as 'Erscheinungs-Datum', 
                                p.prf_name as 'Produktionsfirma' from film f
                                natural left join produktionsfirma p
                                where p.prf_name like '%".$_POST["produktionsfirma"]."%' 
                                order by f.fim_erscheinungsdatum";

                    $sqlFoundProd = "select distinct p.prf_name as 'Produktionsfirma' 
                    from film f
                    natural left join produktionsfirma p
                    where p.prf_name like '%".$_POST["produktionsfirma"]."%'";

                    $foundProd = makeStatement($sqlFoundProd);

                    echo "<h2>Suchergebnis</h2>";
                    echo "<br>";
                    echo "<br>";
                    echo "Gesuchte Produktionsfirma: ".$_POST["produktionsfirma"];
                    echo "<br>";
                    echo "<br>";
                    echo "Gefundene Produktionsfirma: ";

                    while($rows = $foundProd->fetch(PDO::FETCH_NUM)){
                        foreach ($rows as $rw){
                            // Ausgabe der gefundenen Produktionsfirma (Wert in der DB)
                            echo $rw;
                        }
                    }
                    echo "<br>";
                    echo "<br>";

                    echo "Gefundene Filmtitel: ".$r;
                    echo "<br>";
                    echo "<br>";

                    // Aufruf der Function makeTable in function.php
                    makeTable($sql);
                }else{
                    // Fehlermeldung - kommt danach gleich in den catch Block um Fehlermeldung Auszugeben
                    throw new Exception("<h2>Produktionsfirma nicht gefunden!<h2>");
                }
            }
        }

        
    }catch(Exception $e){
        // Ausgabe aller Exceptions
        echo "<br>".$e->getMessage()."<br>";
    }
}
// Wenn Button cancelSearch gedrückt wird
if(isset($_POST["cancelSearch"])){
    // Seite wird neu geladen
    header("Refresh:0");
}
echo "</form>";
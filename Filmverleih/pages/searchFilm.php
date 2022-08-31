<?php
echo "<h2>Filmsuche</h2>";
echo "<br>";
echo "<form method=post>";

makeTypeBoxValueStayProduktionsfirmaRequired("Suche Film nach Produktionsfirma: ", "produktionsfirma", "text", null, "zb.: Harry Potter");

echo '<button type="submit" name="searchFilm">Suchen</button>';
echo '<button type="submit" name="cancelSearch">Abbrechen</button>';

if(isset($_POST["searchFilm"])){
    try{

        $sqlCount = "select count(*) from film f
                        natural left join produktionsfirma p
                        where p.prf_name like '%".$_POST["produktionsfirma"]."%'";
        $count = makeStatement($sqlCount);

        while($row = $count->fetch(PDO::FETCH_NUM)){
            foreach ($row as $r){
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
                            echo $rw;
                        }
                    }
                    echo "<br>";
                    echo "<br>";

                    echo "Gefundene Filmtitel: ".$r;
                    echo "<br>";
                    echo "<br>";
            
                    makeTable($sql);
                }else{
                    throw new Exception("<h2>Produktionsfirma nicht gefunden!<h2>");
                }
            }
        }

        
    }catch(Exception $e){
        echo "<br>".$e->getMessage()."<br>";
    }
}
if(isset($_POST["cancelSearch"])){
    // browser wird neu geladen
    header("Refresh:0");
}
echo "</form>";
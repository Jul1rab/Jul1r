<?php
echo "<h2>Suche nach Schauspieler</h2>";
echo "<br>";
echo "<form method=post>";

// Ausgabe von Label und Inputfeld
makeTypeBoxValueStaySchauspielerRequired("Suche Schauspieler: ", "schauspieler", "text", null, "zb.: Mila Kunis");

// Such-Button
echo '<button type="submit" name="searchSchauspieler">Suchen</button>';
// Abbrechen-Button
echo '<button type="submit" name="cancelSearch">Abbrechen</button>';

if(isset($_POST["searchSchauspieler"])){
    try{

        $sqlCount = "select count(*)
        from schauspieler s
        natural left join film_schauspieler fsc
        natural left join film f
        where concat_ws(' ', s.sch_vname, s.sch_nname) like '%".$_POST["schauspieler"]."%'";
        $count = makeStatement($sqlCount);

        while($row = $count->fetch(PDO::FETCH_NUM)){
            foreach ($row as $r){
                if($r != "0"){
                    // SQL-Statement
                    $sql = "select f.fim_titel as 'Titel', f.fim_erscheinungsdatum as 'Erscheinungs-Datum',
                    concat_ws(' ', s.sch_vname, s.sch_nname) as 'Schauspieler', p.prf_name as 'Produktionsfirma'
                    from schauspieler s
                    natural left join film_schauspieler fsc
                    natural left join film f
                    natural left join produktionsfirma p
                    where concat_ws(' ', s.sch_vname, s.sch_nname) like ?";
                    
                    // Ausgabe des SQL-Statements und beim array wird die suche mit % % gemacht
                    makeTable($sql, ["%$_POST[schauspieler]%"]);
                }else{
                    // Fehlermeldung wird aufgebaut --> geht dann in den catch block rein
                    throw new Exception("<h2>Schauspieler nicht gefunden!<h2>");
                }
            }
        }

        
    }catch(Exception $e){
        // Ausgabe der Fehlermeldung
        echo "<br>".$e->getMessage()."<br>";
    }
}
if(isset($_POST["cancelSearch"])){
    // Seite wird neu geladen
    header("Refresh:0");
}

echo "</form>";
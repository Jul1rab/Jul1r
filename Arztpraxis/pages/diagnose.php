<?php
echo "<h2>Diagnose erfassen</h2>";
echo "<h2>Bestehende Diagnosen</h2>";
echo "<form method=\"post\">";

if(!isset($_POST["diagnose"])){
    $sql = "select dia_id as 'ID', dia_name as 'Diagnose' from diagnose order by dia_name";

    makeTable($sql);
    makeTypeBox("Diagnose", "diagnose", "text", "zb.: Husten");
    echo '<button type="submit" name="insertDiagnose">speichern</button>';
}
if(isset($_POST["diagnose"])){
    $diagnose = $_POST["diagnose"];
    try{
        $query = "select count(*) from diagnose where dia_name = ?";
        $stmt = makeStatement($query, [$_POST["diagnose"]]);
        $lastID = 0;
        echo "Diagnose: ".$diagnose."*";
        if((int) $stmt->fetchColumn() == 0){ // wenn es nicht doppelt im stmt vorkommt liefert es false (0) sonst true
            $sql = 'insert into diagnose(dia_name) values (?)';

            $stmt = makeStatement($sql, array($diagnose));
            $lastID = $con->lastInsertId();
        }else{
            echo "<h2>Der Wert " .$diagnose." ist bereits vorhanden!</h2>";
        }

        $sql = "select dia_id as 'ID', dia_name as 'Diagnose' from diagnose order by dia_name";
        makeTableWithLastIDColour($sql, $lastID);
    }catch (Exception $e){
        echo "Der Wert " .$diagnose." ist bereits vorhanden!";
    }
}

echo "</form>";
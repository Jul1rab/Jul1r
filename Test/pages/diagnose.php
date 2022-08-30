<?php
echo "<h2>Diagnose erfassen</h2>";
echo "<h2>Bestehende Diagnosen</h2>";
echo "<form method=post>";

if(!isset($_POST["diagnose"])){
    $sql = "select dia_id as 'ID', dia_name as 'Diagnose' from diagnose
    order by dia_name";

    makeTable($sql);

    makeTypeBox("Diagnose", "diagnose", "text", "zb.: Covid");
    echo '<button type="submit" name="insertDiagnose">speichern</button>';
}

if(isset($_POST["insertDiagnose"])){
    $diagnose = $_POST["diagnose"];
    echo "Diagnose: ".$diagnose;
    try{
        $sql = "select count(*) from diagnose where dia_name = ?";
        $stmt = makeStatement($sql, array($diagnose));

        $lastID = 0;
        if((int) $stmt->fetchColumn() == 0){ // wenn es nicht doppelt im stmt1 vorkommt liefert es false (0) sonst true
            if($diagnose == ""){
                throw new Exception('Der Wert "'.$diagnose. '" war leer!');
            }else{
                $sql = 'insert into diagnose(dia_name) values (?)';

                 $stmt = makeStatement($sql, array($diagnose));
                 $lastID = $con->lastInsertId();
            }
        }else{
            throw new Exception("Der Wert '" .$diagnose. "' existiert bereits in der Tabelle!");
        }

        $sql = "select dia_id as 'ID', dia_name as 'Diagnose' from diagnose
        order by dia_name";
        makeTableWithLastIDColour($sql, $lastID);

    }catch(Exception $e){
        echo "<br>".$e->getMessage()."<br>";
    }
}

echo "</form>";
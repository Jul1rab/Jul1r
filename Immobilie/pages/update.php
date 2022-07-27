<?php
echo '<h1>Änderungen an Immobilien vornehmen</h1>';
echo '<form action="" method="post">';
makeTypeBoxValueStay("Wählen sie eine Immobilie zum Ändern aus", "search", "search", null, "zb.: Straße 1, 4020 Linz");
echo '<button type="submit" name="searchImmobilien">Auswählen</button>';
$id = 0;
if(isset($_POST["searchImmobilien"]) || isset($_POST["save_details"]) || isset($_POST["ja"])){
    echo '<h1>Immobilien</h1>';

    $sql = "select 
            i.imm_id as 'ID', 
            g.gru_nutzflaeche as 'Nutzfläche', g.gru_wohnflaeche as 'Wohnfläche', 
            g.gru_gartenflaeche as 'Gartenfläche', g.gru_gesamtflaeche as 'Gesamtfläche',
            count(rz.rzo_id) as 'Anzahl Räume' 
            from immobilie i 
            natural left join standort st
            natural left join grund g
            natural left join raum r
            natural left join raumzuordnung rz
            where concat_ws('', st.sta_strasse, ' ', st.sta_hausnummer, ', ', st.sta_plz, ' ', st.sta_stadt) like ? 
            group by i.imm_id";

    makeTableFirstColFixOtherRowsInputFields($sql, ["%$_POST[search]%"], [
        0 => "nutz", 1 => "wohn", 2 => "garten", 3 => "gesamt"
    ]);

    $sql2 = "select i.imm_id as 'ID', b.bez_datum as 'Bezugsdatum'
                from immobilie i 
                natural left join bezug b
                natural left join standort st 
                where concat_ws('', st.sta_strasse, ' ', st.sta_hausnummer, ', ', st.sta_plz, ' ', st.sta_stadt) like ?";
    makeTableFirstColFixOtherRowsInputDateField($sql2, ["%$_POST[search]%"], [
            0 => "bez"
    ]);

    echo '<button type="submit" name="save_details">Änderung vornehmen</button>';
}
if(isset($_POST["save_details"]) || isset($_POST["ja"])){

    echo "<h2>Folgende Daten werden gespeichert:</h2>";

    echo "<br>";
    echo $_POST["nutz"];
    echo "<br>";
    echo $_POST["wohn"];
    echo "<br>";
    echo $_POST["garten"];
    echo "<br>";
    echo $_POST["gesamt"];
    echo "<br>";
    echo $_POST["bez"];
    echo "<br>";

    echo '<button type="submit" name="ja">Ja</button>';
    echo '<button type="submit" name="nein">Nein</button>';
}
if(isset($_POST["ja"])){

    $cnt = 0;
    $stmt = makeStatement($sql, ["%$_POST[search]%"]);
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        foreach ($row as $r){
            if ($cnt == 0){
                $id = $r;
                $cnt = $cnt + 1;
            }
        }
    }

    echo '<br>';
    echo "Ja";
    echo $id;
    echo "<br>";
    echo $_POST["nutz"];
    echo "<br>";
    echo $_POST["wohn"];
    echo "<br>";
    echo $_POST["garten"];
    echo "<br>";
    echo $_POST["gesamt"];
    echo "<br>";
    echo $_POST["bez"];

    $updateGrund = "update grund set gru_nutzflaeche = ".$_POST["nutz"].", gru_wohnflaeche = ".$_POST["wohn"].", 
                    gru_gartenflaeche = ".$_POST["garten"].", gru_gesamtflaeche = ".$_POST["gesamt"]." where gru_id = ".$id;

    $updateBez = "update bezug set bez_datum = '".$_POST["bez"]."' where bez_id = ".$id;

    makeStatement($updateGrund);
    makeStatement($updateBez);

    echo "<h3>Gespeichert</h3>";
}
?>
</form>

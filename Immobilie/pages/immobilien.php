<?php
echo '<h1>Alle Immobilien auflisten</h1>';
$query = 'select i.imm_id as "ID", imt.imt_bezeichnung as "Objektart", p.pre_preis as "Preis", 
concat_ws(\'\', st.sta_plz, " ", st.sta_stadt, ", ", st.sta_strasse, " ", st.sta_hausnummer) as "Anschrift", 
st.sta_land as "Land"
from immobilie i
natural left join immobilientyp imt
natural left join preis p
natural left join standort st';

//$stmt = makeStatement($query);
echo '<form action="" method="post">';
makeTableWithButtonRadioEnd($query, null, [
    "name" => "immobilie",
    "value_field" => 0
]);
?>
<button type="submit" name="load_details">Details anzeigen</button>
</form>
<?php
// Form wird benötigt damit nach Button klick die Details angezeigt werden
if (isset($_POST["load_details"])){
    echo '<h1>Details anzeigen</h1>';

    $sql = 'select i.imm_id as "ID", gru.gru_wohnflaeche as "qm", kty.kty_typ as "Kauf", p.pre_preis as "Preis"
from immobilie i
natural left join grund gru
natural left join kaufstyp kty
natural left join preis p where i.imm_id = ' . $_POST['immobilie'];

    //$stmt1 = makeStatement($sql);
    makeTable($sql);

    //Bild

    $sqlB = 'select b.bil_datei as "Bild"
from immobilie i
natural left join bilder b
where i.imm_id = '. $_POST['immobilie'];

    $stmtB = makeStatement($sqlB);
    while($row = $stmtB->fetch(PDO::FETCH_NUM)){
        foreach ($row as $r){
            echo '<img width="500px" src="/Immobilie/Bilder/'.$r.'">';
        }
    }

    //Bild ende

    $sql = 'select hww.hww_typ as "Heizen/Wasser/System"
from immobilie i
natural left join heizungWarmwasser hww
natural left join immobilie_heizungwarmwasser ihww
where ihww.imm_id = ' . $_POST['immobilie'];

    //$stmt2 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select gru.gru_gartenflaeche as "Garten qm", gru.gru_gesamtflaeche as "Gesamtfläche qm", 
gru.gru_nutzflaeche as "Grundfläche qm"
from immobilie i
natural left join grund gru
where i.imm_id = '. $_POST['immobilie'];

    //$stmt3 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select count(rz.rzo_id) as "Anzahl Räume"
from immobilie i
natural left join raum r
natural left join raumzuordnung rz
group by i.imm_id
HAVING i.imm_id = '. $_POST['immobilie'];

    //$stmt4 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select ife.imf_featurename as "Sonstiges"
from immobilie i
natural left join immobilie_immobilienfeatures iif
natural left join immobilienfeatures ife
where i.imm_id = '. $_POST['immobilie'];

    //$stmt5 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select b.bad_geraete as "Bad"
from immobilie i
natural left join raum r
natural left join raumzuordnung rz
natural left join raum_bad rb
natural join bad b
where i.imm_id = '. $_POST['immobilie'];

    //$stmt6 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select k.kug_name as "Küche"
from immobilie i
natural left join raum r
natural left join raumzuordnung rz
natural left join raum_kuechengeraete rkg
natural join kuechengeraete k
where i.imm_id = '. $_POST['immobilie'];

    //$stmt7 = makeStatement($sql);
    makeTable($sql);

    $sql = 'select rz.rzo_beschreibung
from immobilie i
natural left join raum r
natural left join raumzuordnung rz
where i.imm_id = '. $_POST['immobilie'];

    $stmt8 = makeStatement($sql);

    while($row = $stmt8->fetch(PDO::FETCH_NUM)){
        foreach ($row as $r){
            makeTableAttsHeader($r);
        }
    }
}

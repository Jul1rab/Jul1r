<?php
echo '<h1>Suche</h1>';
echo '<form action="" method="post">';
makeTypeBox("Suchbegriff", "search", "search", "zb.: Wien");
?>
<div class="form-group row">
    <label class="col-4">Suchbegriff auswählen:</label>
    <div class="col-8">
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_1" type="radio" class="custom-control-input" checked value="sta_stadt">
            <label for="radio_1" class="custom-control-label">Ort</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_2" type="radio" class="custom-control-input" value="sta_plz">
            <label for="radio_2" class="custom-control-label">PLZ</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_3" type="radio" class="custom-control-input" value="sta_strasse">
            <label for="radio_3" class="custom-control-label">Straßenname</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_4" type="radio" class="custom-control-input" value="pre_preis">
            <label for="radio_4" class="custom-control-label">Preis (suchergebnis bis max. doppeltes des eingegebenen Wertes)</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_5" type="radio" class="custom-control-input" value="rzo_beschreibung">
            <label for="radio_5" class="custom-control-label">Raumname</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_6" type="radio" class="custom-control-input" value="gru_wohnflaeche">
            <label for="radio_6" class="custom-control-label">Wohnfläche (ab Suchwert)</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input name="radio" id="radio_7" type="radio" class="custom-control-input" value="gru_gesamtflaeche">
            <label for="radio_7" class="custom-control-label">Grundstücksgröße (Gesamtgröße ab Suchwert)</label>
        </div>
    </div>
</div>
<button type="submit" name="search_start">Suche starten</button>
<?php
if (isset($_POST["search_start"]) || isset($_POST["load_details"])){
    echo '<h1>Ergebnis der Suche</h1><br/>';
    echo $_POST["search"];
    echo $_POST["radio"];

    $sql = "
        select 
            i.imm_id as `ID`, concat_ws(' ', st.sta_strasse, st.sta_hausnummer) as `Straße`, st.sta_plz as `PLZ`, 
            st.sta_stadt as `Ort`, p.pre_preis as `Preis`, p.pre_gueltigkeitBis as `Gültigkeitsdatum (Preis) ab`, 
            kty.kty_typ as `Handel`
        from 
            immobilie i
            natural left join standort st
            natural left join preis p
            natural left join kaufstyp kty ";
    if($_POST["radio"] == "sta_stadt" || $_POST["radio"] == "sta_plz"
    || $_POST["radio"] == "sta_strasse"){
        $sql = $sql. "where 
            ".$_POST["radio"]." like ?";
    }
    else if($_POST["radio"] == "pre_preis"){
        $sql = $sql. "where 
            ".$_POST["radio"]." between ".$_POST["search"]." and " .$_POST["search"] * 2;
    }
    else if($_POST["radio"] == "rzo_beschreibung"){
        $sql = $sql. "natural left join raum r
                    natural left join raumzuordnung rzo 
                    where ".$_POST["radio"]. " like ?";
    }
    else if($_POST["radio"] == "gru_wohnflaeche" || $_POST["radio"] == "gru_gesamtflaeche"){
        $sql = $sql. "natural left join grund g 
                        where " .$_POST["radio"]. " >= ".$_POST["search"];
    }

    makeTableWithButtonRadioEnd($sql, ["%$_POST[search]%"], [
        "name" => "immobilie",
        "value_field" => 0
    ]);
    ?>
    <button type="submit" name="load_details">Details anzeigen</button>
<?php
    if(isset($_POST["load_details"])){
        echo '<h1>Details anzeigen</h1>';

        $sql = "select 
                concat_ws('', st.sta_strasse, ' ', st.sta_hausnummer, ', ', st.sta_plz, ' ', st.sta_stadt)
                from immobilie i 
                natural left join standort st 
               where i.imm_id = ". $_POST['immobilie'];
        $stmt = makeStatement($sql);

        while($row = $stmt->fetch(PDO::FETCH_NUM)){
            foreach ($row as $r){
                echo '<h2>'.$r.'</h2>';
            }
        }

        $sql2 = "select i.imm_id as \"ID\", gru.gru_wohnflaeche as \"qm\", kty.kty_typ as \"Kauf\", p.pre_preis as \"Preis\", p.pre_gueltigkeitVon as \"Gültig ab\"
                    from immobilie i
                    natural left join grund gru
                    natural left join kaufstyp kty
                    natural left join preis p
                    where i.imm_id = ". $_POST['immobilie'];

        makeTable($sql2);

        $sql3 = 'select hww.hww_typ as "Heizen/Wasser/System"
                from immobilie i
                natural left join heizungWarmwasser hww
                natural left join immobilie_heizungwarmwasser ihww
                where ihww.imm_id = ' . $_POST['immobilie'];

        makeTable($sql3);

        $sql4 = 'select gru.gru_gartenflaeche as "Garten qm", gru.gru_gesamtflaeche as "Gesamtfläche qm", 
                    gru.gru_nutzflaeche as "Grundfläche qm"
                    from immobilie i
                    natural left join grund gru
                    where i.imm_id = '. $_POST['immobilie'];

        makeTable($sql4);

        $sql5 = 'select count(rz.rzo_id) as "Anzahl Räume"
                    from immobilie i
                    natural left join raum r
                    natural left join raumzuordnung rz
                    group by i.imm_id
                    HAVING i.imm_id = '. $_POST['immobilie'];

        makeTable($sql5);

        $sql6 = 'select ife.imf_featurename as "Sonstiges"
                from immobilie i
                natural left join immobilie_immobilienfeatures iif
                natural left join immobilienfeatures ife
                where i.imm_id = '. $_POST['immobilie'];

        makeTable($sql6);
    }
}
?>
</form>
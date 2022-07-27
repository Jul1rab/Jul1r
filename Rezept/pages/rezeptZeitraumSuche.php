<?php
echo "<h1>Rezepte</h1>";
echo "<h2>Rezepte nach Bereitstellungszeitraum durchsuchen</h2>";
echo '<form action="" method="post">';
makeTypeBox("Zeitraum von:", "zeitraumVon", "datetime-local", "");
makeTypeBox("Zeitraum bis (kann ausgelassen werden):", "zeitraumBis", "datetime-local", "");
echo '<button type="submit" name="searchZeitraumVonBis">Suche starten</button>';
if(isset($_POST["searchZeitraumVonBis"])){
    echo "<br>";
    echo $_POST["zeitraumVon"];
    echo "<br>";
    try{
        // Überprüft ob Zeitraum Von leer ist wenn ja -> Errormessage
        if($_POST["zeitraumVon"] == ""){
            throw new Exception("Zeiraum Von ist leer! Geben sie einen Wert ein!");
        }
        // Überprüft ob Zeitraum Bis leer ist wenn ja -> Zeitraum Von bis Aktuelles Datum wird ausgegeben
        // wenn nein -> Ausgabe von Zeitraum Von bis Zeitraum Bis
        else if($_POST["zeitraumBis"] == ""){
            $sql = "select rez_id as 'ID', rez_name as 'Rezeptname' 
                from rezeptname natural join zubereitung
                where zub_bereitgestellt_am between '".$_POST["zeitraumVon"]."' and curdate()";
            echo $sql;
            echo "<br>";

            makeTable($sql);
        }
        else{
            echo $_POST["zeitraumBis"];
            $sql = "select rez_id as 'ID', rez_name as 'Rezeptname' 
                from rezeptname natural join zubereitung
                where zub_bereitgestellt_am between '".$_POST["zeitraumVon"]."' and '".$_POST["zeitraumBis"]."'";
            echo $sql;
            echo "<br>";

            makeTable($sql);
        }
    }catch (Exception $e){
        echo "<br>Error : ".$e->getMessage()."<br>";
    }

}
echo '<h2>Oder wählen Sie aus folgenden Optionen:</h2>';
echo '<br>';
?>
<div class="row">
    <div class="col-8">
        <?php
        makeInputWithRadioButton("letzterMonat","optionMonat", true);
        ?>
        <label for="letzterMonat" class="custom-control-label">letzter Monat</label>
    </div>
</div>

<div class="row">
    <div class="col-8">
        <?php
        makeInputWithRadioButton("laufenderMonat","optionMonat", false);
        ?>
        <label for="laufenderMonat" class="custom-control-label">laufender Monat</label>
    </div>
</div>

<div class="row">
    <div class="col-sm-1">
        <?php
        makeInputWithRadioButton("monatdesLaufendenJahres", "optionMonat", false);
        ?>
    </div>
    <div class="col-sm-3">
        <input id="monatdesLaufendenJahres" style="width: 150px" name="monatdesLaufendenJahres" type="text" placeholder="zb.: 4" class="form-control">
    </div>
    <div class="col-sm-3>
        <label for="monatdesLaufendenJahres" class="custom-control-label">Monat des Jahres angeben</label>
    </div>
</div>
<?php

echo '<br>';
echo '<button type="submit" name="searchZeitraumOption">Suche starten</button>';
// Wenn Button Suche Starten geklickt wurde wird eine Ausgabe zusammen gebaut
if(isset($_POST["searchZeitraumOption"])){
    $option = $_POST["optionMonat"];
    echo $option;
    echo "<br>";
    // Überprüft ob der Radio-Button für den letzten Monat angeklickt wurde
    if($option == "letzterMonat"){
        echo date("m");
        // Wenn Aktuelles Monat 1 ist wird das Aktuelle Jahr -1 und Monat 12 selected
        // Wenn Aktuelles Monat nicht 1 ist wird nur das Monat -1 selected
        if(date("m") == 1){
            $sql = "select * from zubereitung where year(zub_bereitgestellt_am) like (year(curdate()) - 1) and month(zub_bereitgestellt_am) like 12";
        }else{
            $sql = "select * from zubereitung where year(zub_bereitgestellt_am) like year(curdate()) and month(zub_bereitgestellt_am) like (month(curdate()) - 1)";
        }
        // Ausgabe des SQL-Statements
        makeTable($sql);
    }
    // Überprüft ob der Radio-Button für das Laufende Monat geklicked wurde
    else if ($option == "laufenderMonat"){
        $sql = "select * from zubereitung where year(zub_bereitgestellt_am) like year(curdate()) and month(zub_bereitgestellt_am) like (month(curdate()))";
        makeTable($sql);
    }
    // Letzter Radio-Button (mit eingabe eines Monats)
    else{
        try{
            // Wenn im inputfeld beim Monat des Jahres nichts eingegeben wird Fehlermeldung
            // Wenn was eingegeben wird -> Ausgabe
            if($_POST["monatdesLaufendenJahres"] == ""){
                throw new Exception("Monat des Jahres war leer! Geben sie einen Wert ein!");
            }else{
                echo $_POST["monatdesLaufendenJahres"];
                $sql = "select * from zubereitung where year(zub_bereitgestellt_am) like year(curdate()) and month(zub_bereitgestellt_am) like ?";
                makeTable($sql, ["$_POST[monatdesLaufendenJahres]"]);
            }
        }catch (Exception $e){
            echo "<br>Error : ".$e->getMessage()."<br>";
        }
    }
}

echo '</form>';

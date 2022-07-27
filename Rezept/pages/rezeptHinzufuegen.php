<?php
echo "<h1>Neue Rezepte erfassen</h1>";
echo "<p/>Geben Sie zuerst an wieviele Zutaten das Rezept braucht:";
echo '<form action="" method="post">';

try {
    makeTypeBox("Anzahl", "anzahl", "number", "mind. 1");
    echo '<button type="submit" name="searchAnz">zum Erfassen</button>';
    if(isset($_POST["searchAnz"])){
        // Uberprüft ob anzahl 0 ist oder - enthalten ist wenn ja -> Fehlermeldung
        if($_POST["anzahl"] == 0 || stristr($_POST["anzahl"], "-") !== FALSE){
            throw new Exception("Anzahl muss größer sein als 0 eingabe war: ". $_POST["anzahl"]);
        }
        else{
            echo "<br>".$_POST["anzahl"];
            echo "<h1>Neue Rezepte erfassen</h1>";
            makeTypeBox("Rezeptname", "rezeptname", "text", "zb.: Pancake");
            makeTextArea("Zubereitung", "zubereitung", "text", "zb.: Zutaten gut mischen, ...");

            $sqlZut = "select * from zutat";
            $sqlEin = "select * from einheit";

            for($i = 0; $i < $_POST["anzahl"]; $i++){
                echo "menge".$i;
                makeTypeBoxSmallWith2DropDawnSmall("Menge", "menge".$i, "text", "zb.: 10", $sqlZut, $sqlEin);
            }
        }
        echo '<button type="submit" name="saveRezept">Rezept speichern</button>';
    }
    if(isset($_POST["saveRezept"])){
        echo "<br>";
        echo "Ausgabe:";
        for($i = 0; $i < 3; $i++){
            echo $_POST["menge".$i];
        }
    }
}catch (Exception $e){
    echo "<br>Error : ".$e->getMessage()."<br>";
}
echo '</form>';
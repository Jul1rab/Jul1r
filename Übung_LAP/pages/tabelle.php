<?php
echo "<h1>Datenbanken auflisten</h1>";
echo "<form action='' method='post'>";

$sql = "show databases";
makeTableWithButtonRadioEnd($sql, null, [
    "name" => "db",
    "value_field" => 0
]);
echo '<button type="submit" name="load_schema">Auswahl</button>';
if(isset($_POST["load_schema"]) || isset($_POST["load_beschreibung"]) || isset($_POST["load_inhalt"])){
    echo "<h2>Datenbanken auflisten</h2>";
    echo "<h2>".$_POST["db"]."</h2>";

    $sql = "use ".$_POST["db"];
    makeStatement($sql);
    $sql = "show tables;";
    makeTableWithButtonRadioEnd($sql, null, [
        "name" => "tables",
        "value_field" => 0
    ]);
    echo '<button type="submit" name="load_beschreibung">Beschreibung</button>';
    echo '<button type="submit" name="load_inhalt">Inhalt</button>';
}
if(isset($_POST["load_beschreibung"])){
    echo '<h2>Beschreibung</h2>';
    echo 'Tabelle '.$_POST["tables"];

    $sql = "explain ".$_POST["tables"];
    makeTable($sql);

}
if(isset($_POST["load_inhalt"])){
    echo '<h2>Inhalt</h2>';
    echo 'Tabelle '.$_POST["tables"];

    $sql = "select * from ".$_POST["tables"];
    makeTable($sql);
}
?>
</form>

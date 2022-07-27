<?php
echo '<h1>Neuen Raum erfassen</h1>';
if(isset($_POST['raum'])){
    // Daten speichern
    $raum = $_POST['raum']; // im Post wird das attribut name verwendet nicht die id
    try{

        $query1 = 'select count(*) from raumzuordnung where rzo_beschreibung = ?';
        $stmt1 = makeStatement($query1, [$_POST['raum']]); // [$_POST['raum']] wird zu einem Array

        $lastID = 0;
        if((int) $stmt1->fetchColumn() == 0){ // wenn es nicht doppelt im stmt1 vorkommt liefert es false (0) sonst true
            $sql = 'insert into raumzuordnung(rzo_beschreibung) values (?)';

            $stmt = makeStatement($sql, array($raum));
            $lastID = $con->lastInsertId();
        }else{
            echo "Der Wert '" .$raum. "' existiert bereits in der Tabelle!";
        }
        // Räume ausgeben im Table
        $query = 'select * from raumzuordnung';
        makeTableWithLastIDColour($query, $lastID);

    }catch (Exception $e){
    }

}else{
?>
  <form method="post">
      <div class="row">
          <label class="text-left" for="raum">Eingabe:</label>
          <input class="input-lg" type="text" id="raum" name="raum" placeholder="zb.: Küche">
      </div>
          <?php
          makeSubmitButton("speichern");
          ?>
  </form>
<?php

}
?>
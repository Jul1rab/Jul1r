<?php
echo '<h1>Neue Person erfassen</h1>';
if(isset($_POST[''])){
    // Daten speichern
    $vname = $_POST['vname']; // beim input der name nicht die id
    $nname = $_POST['nname'];
    $funktion = $_POST['funktion'];
    $filiale = $_POST['filiale'];

    // Aufgabe: führen Sie die entsprechenden Insert aus
    try{
        $sql1 = 'insert into personal(pal_vname, pal_nnmae) values (?, ?)';
        $sql2 = 'insert into personal_filiale(pal_id, fun_id) values (?, ?)';
        $sql3 = 'insert into personal_funktion_filiale(pal_id, fun_id, fil_id) values (?, ?, ?)';

        $arr1 = array($vname, $nname);

        $stmt1 = makeStatement($sql1, $arr1);
        $palid= $con->lastInsertId();

        $arr2 = array($palid, $funktion);
        $stmt2 = makeStatement($sql2, $arr2);

        $arr3 = array($palid, $funktion, $filiale);
        $stmt3 = makeStatement($sql3);

    }catch (Exception $e){
        print "Fehler beim hinzufuegen";
    }

}else{
?>
<!-- Erstellen Sie ein Formular zum Erfassen von Personen
    und Zuordnung zu einer Funktion und Filiale -->
  <form method="post">

      <div class="row">
          <label class="text-left" for="vname">Vorname:</label>
          <input class="input-lg" type="text" id="vname" name="vname" placeholder="Vorname">
      </div>
      <div class="row">
        <label class="text-left" for="nname">Nachname:</label>
        <input class="input-lg" type="text" id="nname" name="nname" placeholder="Nachname">
      </div>
      <div class="row">
          <label for="fu">Funktion:</label>
          <!-- Die Funktion aus DB auslesen und als radio-Button ausgeben -->
          <?php
          $query = 'select * from funktion order by fun_name';
          $stmt = makeStatement($query);
          while($row = $stmt->fetch(PDO::FETCH_NUM)){
              echo '<input type="radio" name="funktion" value="'.$row[0].'">'.$row[1].'<br>';
          }
          ?>
      </div>
      <div class="form-group row">
          <label for="fil" class="col-4 col-form-label">Filiale:</label>
          <div class="col-8">
              <select id="fil" name="filiale" class="select form-control">
                  <?php
                  $query = 'select * from filiale order by fil_ort';
                  $stmt = makeStatement($query);
                   while($row = $stmt->fetch(PDO::FETCH_NUM)){
                       echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                   }
                  ?>
              </select>
          </div>
          <?php
          makeSubmitButton("speichern");
          ?>
     <!-- <div class="row">
          <input class="btn btn-default" type="submit" name="save" value="speichern">
      </div>-->
  </form>
<?php
}
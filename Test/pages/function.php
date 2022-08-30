<?php

function makeStatement($query, $array = null){

    try{
        global $con;
        $stmt = $con->prepare($query);
        $stmt->execute($array);
        return $stmt;
    }catch (Exception $e){
        echo $e->getCode().': '.$e->getMessage().'<br>';
    }
}

function makeTable($query, $array = null){
    $stmt = makeStatement($query, $array);

    echo '<table class="table">';
    $meta = array();
    for ($i = 0; $i < $stmt->columnCount(); $i++){
        $meta[]= $stmt->getColumnMeta($i);
        echo '<th>'.$meta[$i]['name'].'</th>';
    }
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        echo '<tr>';
        foreach ($row as $r){
            echo '<td>'.$r.'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function makeTableFirstColFixOtherRowsInputFields($query, $array = null, $button_settings = []){
    $stmt = makeStatement($query, $array);

    echo '<table class="table">';
    $meta = array();
    for ($i = 0; $i < $stmt->columnCount(); $i++){
        $meta[]= $stmt->getColumnMeta($i);
        echo '<th>'.$meta[$i]['name'].'</th>';
    }
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        echo '<tr>';
        $count = 0;
        $countKeys = 0;
        foreach ($row as $r){

            // Wenn in $_POST["nutz"] schon was gespeichert wurde wird dieses beim nächsten mal laden übergeben
            // Im Input feld bleibt der vorherige Wert gespeichert
            if($count != 0 && $count != 5){
                if(isset($_POST["nutz"]) && $button_settings[$countKeys] == "nutz"){
                    $r = $_POST["nutz"];
                }
                if(isset($_POST["wohn"]) && $button_settings[$countKeys] == "wohn"){
                    $r = $_POST["wohn"];
                }
                if(isset($_POST["garten"]) && $button_settings[$countKeys] == "garten"){
                    $r = $_POST["garten"];
                }
                if(isset($_POST["gesamt"]) && $button_settings[$countKeys] == "gesamt"){
                    $r = $_POST["gesamt"];
                }
            }

            if($count != 0 && $count != 5){ // ID und Anzahl Räume kein input feld
                echo '<td><input style="width: 60pt" name="' . $button_settings[$countKeys] . '" 
                    value = "' . $r . '"></td>';
                $countKeys = $countKeys + 1;
            }else{
                echo '<td>'.$r.'</td>';
            }
            $count = $count + 1;
        }
        echo '</tr>';
    }
    echo '</table>';
}

function makeTableFirstColFixOtherRowsInputDateField($query, $array = null, $button_settings = []){
    $stmt = makeStatement($query, $array);

    echo '<table class="table">';
    $meta = array();
    for ($i = 0; $i < $stmt->columnCount(); $i++){
        $meta[]= $stmt->getColumnMeta($i);
        echo '<th>'.$meta[$i]['name'].'</th>';
    }
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        echo '<tr>';
        $count = 0;
        $countKeys = 0;
        foreach ($row as $r){
            if($count != 0){ // 1 Column ist ID (nicht ändern)
                if(isset($_POST["bez"])){
                    $r = date_format( date_create($_POST["bez"]), "Y-m-d");
                }
                echo '<td><input type="date" style="width: 100pt" name="' . $button_settings[$countKeys] . '" 
                    value = "' . $r . '"></td>';
                $countKeys = $countKeys + 1;
            }else{
                echo '<td>'.$r.'</td>';
            }
            $count = $count + 1;
        }
        echo '</tr>';
    }
    echo '</table>';
}

function makeTableAttsHeader($r){
    echo '<table class="table">';
    echo '<th>'.$r.'</th>';
    echo '<tr><td>Ausstattung</td></tr>';
    echo '</table>';
}

function makeTableWithButtonRadioEnd($query, $array = null, $button_settings = []){
    $stmt = makeStatement($query, $array);

    echo '<table class="table">';
    $meta = array();
    for ($i = 0; $i < $stmt->columnCount(); $i++){
        $meta[]= $stmt->getColumnMeta($i);
        echo '<th>'.$meta[$i]['name'].'</th>';
    }
    $count = 0;
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        echo '<tr>';
        foreach ($row as $r){
            echo '<td>'.$r.'</td>';
        }

        if($count != 0){
            echo '<td><input type="radio" 
                name="' . $button_settings["name"] . '" 
                value="' . $row[$button_settings["value_field"]] . '" /></td>';
        }else{
            echo '<td><input checked type="radio" 
                name="' . $button_settings["name"] . '" 
                value="' . $row[$button_settings["value_field"]] . '" /></td>';
        }
        $count = $count + 1;

        echo '</tr>';
    }
    echo '</table>';
}

function makeTableWithLastIDColour($query, $lastID, $array = null){
    $stmt = makeStatement($query, $array);

    echo '<table class="table">';
    $meta = array();
    for ($i = 0; $i < $stmt->columnCount(); $i++){
        $meta[]= $stmt->getColumnMeta($i);
        echo '<th>'.$meta[$i]['name'].'</th>';
    }
    while($row = $stmt->fetch(PDO::FETCH_NUM)){
        echo '<tr';
        if($row[0] == $lastID) // eingefügte ID, da wird der Hintergrund geändert damit es gleich ersichtlich ist
            echo ' style="background-color: #f1a0a0"';
        echo '>';
        foreach ($row as $r){
            echo '<td>'.$r.'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function makeDropDown($query, $labelName, $array = null){
    $stmt = makeStatement($query, $array);
    ?>
    <div class="form-group row">
        <label for="select" class="col-4 col-form-label"><?=$labelName ?></label>
        <div class="col-8">
            <select id="select" name="select" class="custom-select">
                <?php
                while($row = $stmt->fetch(PDO::FETCH_NUM)){
                    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <?php
}

function makeRadioButton($query, $labelName, $array = null){
    $stmt = makeStatement($query, $array);
    ?>
    <div class="form-group row">
        <label class="col-4"><?=$labelName ?></label>
        <div class="col-8">
            <?php
            $count = 0;
            while($row = $stmt->fetch(PDO::FETCH_NUM)){
                echo '<div class="custom-control custom-radio custom-control-inline">';
                echo '<input name="radio" id="radio_'.$count.'" type="radio" class="custom-control-input" value="'.$row[0].'">';
                echo '<label for="radio_'.$count.'" class="custom-control-label">'.$row[1].'</label>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}

function makeCheckbox($query, $labelName, $array = null){
    $stmt = makeStatement($query, $array);
    ?>
    <div class="form-group row">
        <label class="col-4"><?=$labelName ?></label>
        <div class="col-8">
            <?php
            $count = 0;
            while($row = $stmt->fetch(PDO::FETCH_NUM)){
                echo '<div class="custom-control custom-checkbox custom-control-inline">';
                echo '<input name="checkbox" id="checkbox_'.$count.'" type="checkbox" class="custom-control-input" value="'.$row[0].'">';
                echo '<label for="checkbox_'.$count.'" class="custom-control-label">'.$row[1].'</label>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}

// Im Input Feld bleibt die Eingabe nicht bestehen -> bleibt leer
function makeTypeBox($labelName, $paramName, $type, $placeholder){
    ?>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
            <div class="col-8">
                <?php
                echo '<input id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" placeholder="'.$placeholder.'" class="form-control">';
                ?>
            </div>
        </div>
    <?php
}

function makeTypeBoxValueStaySvnrRequired($labelName, $paramName, $type, $value = null, $placeholder){
    ?>
    <div class="row">
        <div class="col-sm-3">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
        </div>
        <div class="col-sm-6">
            <?php
            // Im Input Feld bleibt die Eingabe bestehen
            if(isset($_POST["svnr"])){
                $value = $_POST["svnr"];
            }
            echo '<input value="'.$value.'" id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" placeholder="'.$placeholder.'" required class="form-control">';
            ?>
        </div>
    </div>
    <?php
}

function makeTypeBoxValueStayGeburtsdatumRequired($labelName, $paramName, $type, $value = null){
    ?>
    <div class="row">
        <div class="col-sm-3">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
        </div>
        <div class="col-sm-6">
            <?php
            // Im Input Feld bleibt die Eingabe bestehen
            if(isset($_POST["geburtsdatum"])){
                $value = $_POST["geburtsdatum"];
            }
            echo '<input value="'.$value.'" id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" required class="form-control">';
            ?>
        </div>
    </div>
    <?php
}

function makeInputWithRadioButton($id, $name, $checked){
    if($checked){
        echo '<input name="'.$name.'" id="'.$id.'" type="radio" class="custom-control-input" value="'.$id.'" checked>';
    }else{
        echo '<input name="'.$name.'" id="'.$id.'" type="radio" class="custom-control-input" value="'.$id.'">';
    }
}

function makeSubmitButton($buttonName = "Submit"){
    ?>
    <div class="form-group row">
        <div class="offset-4 col-8">
            <button name="submit" type="submit" class="btn btn-primary"><?=$buttonName ?></button>
        </div>
    </div>
    <?php
}
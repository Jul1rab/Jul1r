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

function makeTypeBoxValueStayProduktionsfirmaRequired($labelName, $paramName, $type, $value = null, $placeholder){
    ?>
    <div class="row">
        <div class="col-sm-6">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
        </div>
        <div class="col-sm-6">
            <?php
            // Im Input Feld bleibt die Eingabe bestehen
            if(isset($_POST["produktionsfirma"])){
                $value = $_POST["produktionsfirma"];
            }
            echo '<input value="'.$value.'" id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" placeholder="'.$placeholder.'" required class="form-control">';
            ?>
        </div>
    </div>
    <?php
}

function makeTypeBoxValueStaySchauspielerRequired($labelName, $paramName, $type, $value = null, $placeholder){
    ?>
    <div class="row">
        <div class="col-sm-6">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
        </div>
        <div class="col-sm-6">
            <?php
            // Im Input Feld bleibt die Eingabe bestehen
            if(isset($_POST["schauspieler"])){
                $value = $_POST["schauspieler"];
            }
            echo '<input value="'.$value.'" id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" placeholder="'.$placeholder.'" required class="form-control">';
            ?>
        </div>
    </div>
    <?php
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
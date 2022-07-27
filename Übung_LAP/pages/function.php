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

        $st = '<td><input ';
        if(isset($_POST["db"]) && $_POST["db"] == $row[$button_settings["value_field"]] ||
            isset($_POST["tables"]) && $_POST["tables"] == $row[$button_settings["value_field"]]
            || $count == 0){
            $st = $st . 'checked ';
        }
        $st = $st . 'type="radio" 
                name="' . $button_settings["name"] . '" 
                value="' . $row[$button_settings["value_field"]] . '" /></td>';
        echo $st;
        $count = $count + 1;

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

function makeTypeBox($labelName, $paramName, $type){
    ?>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label"><?=$labelName ?></label>
            <div class="col-8">
                <?php
                echo '<input id="'.$paramName.'" name="'.$paramName.'" type="'.$type.'" class="form-control">';
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
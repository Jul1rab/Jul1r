<?php
echo "<h2>Patienten - Diagnosen</h2>";
echo "<br>";
echo "<form method=post>";

makeTypeBoxValueStaySvnrRequired("SV-Nr.", "svnr", "text", null, "zb.: 1234");
makeTypeBoxValueStayGeburtsdatumRequired("Geburtsdatum", "geburtsdatum", "Date", null);

echo "<h2>Behandlungsbeginn:</h2>";
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
        <div class="col-sm-6">
            <label for="monatdesLaufendenJahres" class="custom-control-label">Monat des laufenden Jahres angeben</label>
        </div>
    </div>

<?php

echo '<button type="submit" name="search">anzeigen</button>';

if(isset($_POST["search"])){
    try{

        // Prüft ob die SVNR 4 Stellen besitzt wenn nicht Fehlermeldung
        if(strlen($_POST["svnr"]) != 4){
            throw new Exception("SVNR: ".$_POST["svnr"]." ist ungültig, da die länge nicht passt!");
        }

        echo "<br>";
        $option = $_POST["optionMonat"];
        echo $option;
        echo "<br>";
        if($option == "letzterMonat"){
            echo date("y-m-01");
            echo "<br>";
            echo date("y-m")."-";
            echo cal_days_in_month(CAL_GREGORIAN, date("m"), date("y"));
            if(date("m") == 1){
                $sql = "select bhz.ter_beginn as 'Zeitraum', concat_ws(' ', p.per_vname, p.per_nname) as 'Patient', 
                concat_ws('/', p.per_svnr, p.per_geburt) as 'SVNr', d.dia_name as 'Diagnose'
                from behandlungszeitraum bhz natural left join person p
                natural left join diagnose d
                where year(bhz.ter_beginn) like (year(curdate()) - 1) and month(bhz.ter_beginn) like 12
                and p.per_svnr = ? and p.per_geburt = ?";
            }else{
                $sql = "select bhz.ter_beginn as 'Zeitraum', concat_ws(' ', p.per_vname, p.per_nname) as 'Patient', 
                concat_ws('/', p.per_svnr, p.per_geburt) as 'SVNr', d.dia_name as 'Diagnose'
                from behandlungszeitraum bhz natural left join person p
                natural left join diagnose d
                where year(bhz.ter_beginn) like year(curdate()) and month(bhz.ter_beginn) like (month(curdate()) - 1)
                and p.per_svnr = ? and p.per_geburt = ?";
            }
            makeTable($sql, [$_POST["svnr"], $_POST["geburtsdatum"]]);
        }
        else if ($option == "laufenderMonat"){
            echo "<br>";
            echo date("y-m-01");
            echo "<br>";
            echo date("y-m")."-";
            echo cal_days_in_month(CAL_GREGORIAN, date("m"), date("y"));
            $sql = "select bhz.ter_beginn as 'Zeitraum', concat_ws(' ', p.per_vname, p.per_nname) as 'Patient', 
                concat_ws('/', p.per_svnr, p.per_geburt) as 'SVNr', d.dia_name as 'Diagnose'
                from behandlungszeitraum bhz natural left join person p
                natural left join diagnose d
                where year(bhz.ter_beginn) like year(curdate()) and month(bhz.ter_beginn) like month(curdate())
                and p.per_svnr = ? and p.per_geburt = ?";
            makeTable($sql, [$_POST["svnr"], $_POST["geburtsdatum"]]);
        }
        else{
            if($_POST["monatdesLaufendenJahres"] == ""){
                throw new Exception("Monat des laufenden Jahres war leer! Geben sie einen Wert ein!");
            }
            else if($_POST["monatdesLaufendenJahres"] > date("m")){
                throw new Exception("Sie haben als Monat ".$_POST["monatdesLaufendenJahres"]." gewählt, 
                wir haben aber erst ".date("m"));
            }
            else{
                echo $_POST["monatdesLaufendenJahres"];

                $sqlCount = "select count(*)
                    from behandlungszeitraum bhz natural left join person p
                    natural left join diagnose d
                    where year(bhz.ter_beginn) like year(curdate()) and month(bhz.ter_beginn) like ".$_POST["monatdesLaufendenJahres"]."
                    and p.per_svnr = ".$_POST["svnr"]." and p.per_geburt = '".$_POST["geburtsdatum"]."'";

                $sql = "select bhz.ter_beginn as 'Zeitraum', concat_ws(' ', p.per_vname, p.per_nname) as 'Patient', 
                    concat_ws('/', p.per_svnr, p.per_geburt) as 'SVNr', d.dia_name as 'Diagnose'
                    from behandlungszeitraum bhz natural left join person p
                    natural left join diagnose d
                    where year(bhz.ter_beginn) like year(curdate()) and month(bhz.ter_beginn) like ?
                    and p.per_svnr = ? and p.per_geburt = ?";

                $count = makeStatement($sqlCount);
                echo "<br>";
                echo date("y-0".$_POST["monatdesLaufendenJahres"]."-01");
                echo "<br>";
                echo date("y-0".$_POST["monatdesLaufendenJahres"])."-";
                echo cal_days_in_month(CAL_GREGORIAN, date($_POST["monatdesLaufendenJahres"]), date("y"));
                while($row = $count->fetch(PDO::FETCH_NUM)){
                    foreach ($row as $r){
                        if($r != "0"){
                            makeTable($sql, [$_POST["monatdesLaufendenJahres"], $_POST["svnr"], $_POST["geburtsdatum"]]);
                        }
                        else{
                            makeTable($sql, [$_POST["monatdesLaufendenJahres"], $_POST["svnr"], $_POST["geburtsdatum"]]);
                            throw new Exception("<h2>Es sind keine Datensätze vorhanden!</h2>");
                        }
                    }
                }
            }
        }

    }catch (Exception $e){
        echo "<br>".$e->getMessage()."<br>";
    }
}

echo "</form>";
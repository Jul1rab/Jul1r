<?php
echo '<h1>Kurstermine erfassen</h1>';
if(isset($_POST[''])) {

}else{
    ?>
    <form method="post">
        <?php
        $query = 'select kuti_name from kurstitel';
        makeDropDown($query, "Kurstitel");
        ?>
    </form>
    <?php
}
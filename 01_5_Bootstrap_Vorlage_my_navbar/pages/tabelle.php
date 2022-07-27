<?php
echo '<h1>Personal</h1>';
$query = 'select concat_ws(\' \', pal_vname, pal_nname) as "Personal" from personal where pal_id = ?';
$personid = 2;
$arr = array($personid);
//makeStatement($query, $arr);
makeTable($query, $arr);

/* Suche */
$query = 'select * from personal where pal_vname like ? and pal_nname like ?';
$vn = '%a%';
$nn = 'W%';
$arr = array($vn, $nn);
//makeStatement($query, $arr);
makeTable($query, $arr);
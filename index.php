<?php 

require_once('Table.php');

use App\Controllers\Table;

$t = new table('table table-striped');

// $t->tableAttr('id', 3)->tableAttr('class', 'boots');

$t->caption('my caption');

$t->row('thead');
$t->cell('head one')->attr('class', 'head one style');
$t->cell('head two');

$t->row()->cell('row 1 cell one')->attr('class', 'cell one style')->attr('data-id', 5);
$t->cell('row 1 cell two')->attr('class', 'cell two style')->attr('data-id', 3);

$t->row();
$t->cell('row 2 cell one');
$t->cell('row 2 cell two')->attr('data-id', 21);



$t->row('tfoot');
$t->cell('foot one');
$t->cell('foot two');


$table = htmlspecialchars($t->createTable(false));
echo '<pre>';
echo $table;
echo '</pre>';


echo '<hr />';

$t->showObject();


?>
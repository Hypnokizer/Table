<style>

th, td {
    padding: 3px;
    border: solid 1px #ccc;
}

</style>


<?php 

require_once('Table.php');

use App\Controllers\Table;

$t = new table('table table-striped');

$t->tableAttr('id', 3);

$t->caption('my caption');

$t->row('thead')->rowAttr('class', 'headclass');
$t->cell('head one')->attr('class', 'head one style');
$t->cell('head two');

$t->row()->rowAttr('class', 'highlight')->rowAttr('data-id', 123);
$t->cell('row 1 cell one')->attr('class', 'cell one style')->attr('data-id', 5);
$t->cell('row 1 cell two')->attr('class', 'cell two style')->attr('data-id', 3);

$t->row()->rowAttr('data-id', 456);
$t->cell('row 2 cell one');
$t->cell('row 2 cell two')->attr('data-id', 21)->attr('colspan', 2)->attr('title', 'my cell title');


$t->row('tfoot')->rowAttr('class', 'footclass');
$t->cell('foot one')->attr('class', 'foothighlight');
$t->cell('foot two');


$table = htmlspecialchars($t->createTable(false));
echo '<pre>';
echo $table;
echo '</pre>';

$t->createTable();

echo '<hr />';

$t->showObject();


?>
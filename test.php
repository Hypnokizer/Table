<style>

th, td {
    padding: 3px;
    border: solid 1px #ccc;
}

</style>


<?php 

require_once('Table.php');

use App\Controllers\Table;

$results = array(1, 2, 3, 4);


$t = new table('table table-striped table-hover align-middle');
$t->caption(count($results) . ' records found');

$t->row('thead');
$t->cell('PO')->attr('class', 'text-center');
$t->cell('Date')->attr('class', 'text-center');
$t->cell('Vendor');
$t->cell('Total')->attr('class', 'text-end');
$t->cell('Account')->attr('class', 'text-center');
$t->cell('Tags');
$t->cell('OrderedBy');
$t->cell('Actions')->attr('class', 'text-center');

foreach($results as $key => $val) {
    $t->row()->attr('data-id', 5);
    $t->cell('PO #')->attr('class', 'text-center');
    $t->cell('2026-05-27')->attr('class', 'text-center');
    $t->cell('vendor name');
    $t->cell('$4.99')->attr('class', 'text-end');
    $t->cell('90210')->attr('class', 'text-center');
    $t->cell('tag tag2');
    $t->cell('Nathan Kizer');
    $t->cell('buttons')->attr('class', 'text-center');
}

$t->row('tfoot')->attr('class', 'tfooter');
$t->cell()->attr('colspan', 3);
$t->cell('GT')->attr('class', 'text-end');
$t->cell()->attr('colspan', 4);


$table = htmlspecialchars($t->createTable(false));
echo '<pre>';
echo $table;
echo '</pre>';


$t->createTable();

$t->showObject();


/*


// $t = new table('table table-striped table-hover align-middle');
//     $t->setCaption('(' . count($results) . ') records found');
    
    // $t->addRow('thead');
    // $t->setCell('PO#');
    //     $t->setAttr('class', 'text-center');
    // $t->setCell('Date');
    //     $t->setAttr('class', 'text-center');
    // $t->setCell('Vendor');
    // $t->setCell('Total');
    //     $t->setAttr('class', 'text-end');
    // $t->setCell('Account');
    //     $t->setAttr('class', 'text-center');
    // $t->setCell('Tags');
    // $t->setCell('OrderedBy');
    // $t->setCell('Actions');
    //     $t->setAttr('class', 'text-center');
    
    foreach($results as $row) {
        $buttons = '<div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-link text-primary" data-bs-toggle="modal" data-bs-target="#poDetail" data-po="' . $row['id'] . '" title="View this PO data"><i class="bi bi-search"></i></button>
            <a href="po/view/' . $row['id'] . '" class="btn btn-link text-primary" target="_blank" title="Print this PO"><i class="bi bi-printer"></i></a>';

        // PERMISSIONS
        if($_SESSION['webapps']['permissions'][APP]['permissionlevel'] >= 3 && $row['status'] !== 'cancelled') {
            $buttons .= '<a href="po/cancel/' . $row['id'] . '" class="btn btn-link text-danger subNav2" title="Cancel"><i class="bi bi-dash-circle"></i></a>';

            $buttons .= '<a href="po/update/' . $row['id'] . '" class="btn btn-link text-success subNav2" title="Update"><i class="bi bi-pencil"></i></a>';
        }

        $buttons .= '</div>';
    
        if(!empty($row['accountnotes'])) {
            $tags = '<span class="badge bg-info">Notes</span>';
        }
        else {
            $tags = null;
        }
    
        if($row['status'] == 'cancelled') {
            $tags .= ' <span class="badge bg-danger">Cancel</span>';
        }
    
        $t->addRow();
        $t->setCell(showPOnumber($row['id']));
            $t->setAttr('class', 'text-center');
        $t->setCell($row['datecreated']);
            $t->setAttr('class', 'text-center');
        $t->setCell($row['vendorname']);
        $t->setCell(showMoney($row['grandtotal']));
            $t->setAttr('class', 'text-end');
        $t->setCell($row['accountcode']);
            $t->setAttr('class', 'text-center');
        $t->setCell($tags);
        $t->setCell($row['orderedby']);
        $t->setCell($buttons);
            $t->setAttr('class', 'text-center');
    
        $gt += $row['grandtotal'];
    }
    
    $t->addRow('tfoot');
    $t->setCell();
        $t->setAttr('colspan', 3);
    $t->setCell(showMoney($gt));
        $t->setAttr('class', 'text-end');
    $t->setCell();
        $t->setAttr('colspan', 4);
    
*/    
    
    // $t->createTable();

?>
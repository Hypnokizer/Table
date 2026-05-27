# Table class

This class exists to quickly build HTML tables using all components, including headers, footers, captions, and attributes.

## requires PHP 8.3+

## Basic Use

Instantiate the object. The only parameter is optional and used to define a class name for the table. Any of the table attributes, including class name, can be defined using the `setTableAttr()` method.
```
$t = new table();
    $t->setTableAttr('id', 'tableID');
    $t->setTableAttr('class', 'tableClass');
```

Most of the methods define the table structure and data. These can be called in any order, as long as they are called before the `createTable()` method.

Table captions are optional and can be set using the following method. It accepts any string value.

```
$t->setCaption('My Caption');
```


Each new table row must be defined by calling the `addRow()` method. This method accepts a single parameter of `thead`, `tfoot`, or `tbody`. Leaving it empty will default to `tbody`. Attributes for the current table row can be defined using the `setRowAttr()` method.

```
$t->addRow('thead');
$t->setRowAttr('id', 'myRowID');
$t->setRowAttr('class', 'myRowClass');
```


Once the table row has been defined, individual cells can be defined. This is done using the `setCell()` method. The single parameter takes any string value. The attributes for the cell can be defined using the `setAttr()` method. Any valid HTML5 attribute can be used, including data attributes.

```
$t->setCell('content');
    $t->setAttr('id', 'myCellID');
    $t->setAttr('class', 'myCellClass');
    $t->setAttr('title', 'This is a tooltip');
    $t->setAttr('colspan', 2);
    $t->setAttr('data-logic', 'my-data-logic-variable');
```



In cases where multiple header or footer rows are needed, simply call the `addRow()` method again with the proper parameter.

Once the table has been completely defined, you can call the final method to create the complete string of HTML. This method has one optional parameter. The boolean value of `false` will return a string. The default boolean value of `true`, or omitting the parameter altogether, will echo the HTML string.

This optional parameter is useful when creating a table string which is part of a larger string that is not immediately echoed to the screen.
```
$t->createTable();
```



## Debugging
There is one method used for debugging. It displays the entire object and its values.
```
$t->showObject();
```



## Complete Example
The example below shows the most basic usage of this class. Often, the table body is created using a `foreach` loop to add a row and create cells.
```
$t = new table('myclass');
    $t->setTableAttr('id', 'myTableID');

$t->addRow('thead');
$t->setRowAttr('id', 'header-row');
$t->setCell('HeaderOne');
$t->setCell('HeaderTwo');

$t->addRow('tfoot');
$t->setRowAttr('id', 'footer-one');
$t->setCell('HeaderThree');
    $t->setAttr('class', 'headerThreeClass');
$t->setCell('HeaderFour');


$t->addRow();
$t->setRowAttr('class', 'table-success');
$t->setRowAttr('id', 'table-row-id');
$t->setCell('one');
    $t->setAttr('id', 'myCellID');
    $t->setAttr('class', 'myCellClass');
    $t->setAttr('title', 'This is a tooltip');
    $t->setAttr('data-help', 'custom help text');
$t->setCell('two');

$t->addRow();
$t->setCell('three');
$t->setCell('four');

$t->createTable();
```
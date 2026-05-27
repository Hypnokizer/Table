# Table class 

This class quickly builds HTML tables with semantic HTML.

## Basic Use 

Instantiate the object. The only parameter is optional and used to define a class name for the table. Any of the table attributes, including class name, can be defined using the `attr()` method.
```
$t = new table('my class name');
$t->attr('id', 'tableID');
```

The basic methods add a row, cell, or attribute. These define the table which is created when the `createTable()` method is called.

Each new table row must be defined by calling the `row()` method. This method accepts a single parameter of `thead`, `tfoot`, or `tbody`. Leaving it empty will default to `tbody`. Attributes for the current table row can be defined using the `attr()` method.

```
$t->row()->attr('id', 'myRowID')->attr('class', 'myRowClass');
```

Once the table row has been defined, individual cells can be defined. This is done using the `cell()` method. The single parameter takes any string value. The attributes for the cell can be defined using the `attr()` method. Any valid HTML5 attribute can be used, including data attributes.

```
$t->cell('this is cell 1');
$t->cell('this is cell 2');
$t->cell('this is cell 3')->attr('class', 'myCellClass');
```

Once the table has been completely defined, you can call the final method to create the complete string of HTML. This method has one optional parameter. The boolean value of `false` will return a string. The default boolean value of `true`, or omitting the parameter altogether, will echo the HTML string.

```
$t->createTable();
```




## Debugging 

There is one method used for debugging. It displays the entire object and its values.
```
$t->showObject();
```



## Complete Example

The example below shows the most basic usage of this class. Typically, the table body is created by looping through an array of data.

```
$t = new table();

$t->caption('My table caption');

$t->row('thead');
$t->cell('Heading One');
$t->cell('Heading Two');

foreach($databaseresults as $result) {
    $t->row();
    $t->cell($result['cellone'])->attr('class', 'highlightcell');
    $t->cell($result['celltwo]);
}

$t->row('tfoot');
$t->cell('footing one');
$t->cell('footing two');

$t->createTable();

```
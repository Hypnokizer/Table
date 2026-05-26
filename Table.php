<?php

/**
* Class to help build tables quickly and cleanly with semantic XHTML
*
* This table class constructs an object array of attributes and values for the table. This allows the table elements to be added in any order. Once the table attributes and values have all been added, a single method is called to create the table code. The HTML can be stored in a variable or directly displayed to the screen.
* @author Nathan Kizer <nathan.kizer@lubbock911.org>
* @version 4.0 (updated on 2015-06-10)
* @copyright 2011-12-05
* @revision 2015-01-20 The entire class was rewritten to put all values into one TABLE array. Multiple header and footer rows are now possible.
*/

namespace App\Controllers;

class Table {

	/**
	* Description (short) of the property.
	*
	* @access public|protected|private
	* @var variabletype (int|bool|string|array)
	* @see property/method()
	* @see property/method()
	*/
	protected $rowcounter;
	protected $cellcounter;
	protected $section;


	/**
	* An array holding table attributes and values
	*
	* @access protected
	* @var array
	*/
	protected $table;





	/**
	* Description (short) of the method.
	*
	* Description (long) of the method.
	* @access public
	* @param variabletype(int|bool|string|array) $variablename Description of the parameter, including default values.
	* @param...
	* @see property/method()...
	* @return type(int|bool|string|array|void) Description of the value returned by the method.
	*/




	/**
	* Automatically executes when the object is created
	*
	* The CONSTRUCT() function sets many of the variable defaults. The {@link class} variable is set to
	* either the given value or the default setting of NULL. The {@link table}, {@link thead}, and {@link tfoot}
	* arrays are all set to NULL. The {@link caption} string is set to NULL. The {@link rowcounter}, {@link headercounter},
	* and {@link footerrowcounter} are all set to zero as default.
	* @access public
	* @param string The class name for the form
	*/
	public function __CONSTRUCT($classname = NULL) {
		$this->rowcounter = 0;
		$this->cellcounter = 0;
		$this->section = 'tbody';


		$this->table = array(
			'attr' => array(
				'class' => $classname
			),
			'caption' => NULL,
			'thead' => array(),
			'tfoot' => array(),
			'tbody' => array()
		);
	}







	public function setTableAttr($key, $val) {
		$this->table['attr'][$key] = $val;
	}




	/**
	* Sets the caption element for the table
	*
	* This function sets the caption string for the table using the parameter given.
	* @access public
	* @param string $text The caption string for the table
	*/
	public function setCaption($text = NULL) {
		$this->table['caption'] = $text;
	}










	/**
	* Adds a new row to the table to be created
	*
	* This function increments the {@link rowcounter} value by one. This counter, in turn, is used by the {@link setCell()} function to add attributes to specific table array elements.
	* @access public
	* @see setCell()
	* @see addFooterRow()
	*/
	public function addRow($section = 'tbody') {
		// reset the cell counter
		$this->cellcounter = 0;

		// increment the row counter
		$this->rowcounter++;

		// define allowed values for the table section
		$allowed = array('thead', 'tfoot', 'tbody');

		if(in_array($section, $allowed)) {
			$this->section = $section;
		}
		else {
			$this->section = 'tbody';
		}
	}



	public function setRowAttr($key, $val) {
		$this->table[$this->section][$this->rowcounter]['attr'][$key] = $val;
	}






	/**
	* Sets attributes and values for a particular table cell
	*
	* This function sets attributes and values for a table cell. The content is the text string to be displayed in the cell. The default value is a non-breaking space. The tooltip is a text string which displays when the mouse hovers over the table cell. The class variable gives CSS styling options and the column span variable allows a cell to span more than one column.
	* @access public
	* @param string $content Text to be used as the table cell content
	* @param string $tooltip Text to be used as the tooltip for the cell
	* @param string $class Text to be used as the CSS class name
	* @param int $colspan The number of columns the cell should span
	*/
	public function setCell($content = '&nbsp;') {
	    // increment the cell counter
		$this->cellcounter++;

		$this->table[$this->section][$this->rowcounter][$this->cellcounter]['content'] = $content;
	}



	public function setAttr($key, $val) {
		$this->table[$this->section][$this->rowcounter][$this->cellcounter][$key] = $val;
	}








	/**
	* create attributes from array of key value pairs
	*/
	protected function createAttributes($array) {
		$attr = array();

		// create attribute array (except for content)
		foreach($array as $key => $val) {
			if($key != 'content') {
				$attr[] = $key . '="' . $val . '"';
			}
		}

		// create string of attributes
		$string = implode(' ', $attr);

		// add a leading space to attribute string
		if(strlen($string) > 0 ) {
			$string = ' ' . $string;
		}

		return $string;
	}











	/**
	* Creates XHTML code for the table using the {@link table} array
	*
	* This function uses the {@link table} array to construct the XHTML code for rendering a table. The method
	* renders the caption, colgroups, table header, table footer, then table body, as per the XHTML specifications. If {@link thead}
	* or {@link tfoot} are NOT present, they will not be displayed at all. If a {@link caption} is NOT present,
	* an empty set of tags will NOT be displayed. Each table row will have a CSS class of either ODD or EVEN,
	* depending on the order and placement of the row. The DISPLAYTABLE variable decides if the table output is
	* echoed to the browser or returned to a variable
	* @param bool $displaytable Boolean value determining if output is echoed or returned
	* @access public
	* @return string
	*/
	public function createTable($displaytable = true) {
		// open the table tag
		$string = '<table';

		// create table attributes
		$string .= $this->createAttributes($this->table['attr']);

        // close the table tag
		$string .= '>' . PHP_EOL;

        // show the caption if present
		if(!empty($this->table['caption'])) {
			$string .= '<caption>' . $this->table['caption'] . '</caption>' . PHP_EOL;
		}



		/**
		* create THEAD if present
		*/
		if(!empty($this->table['thead'])) {
			$string .= '<thead>' . PHP_EOL;

			// step thru table header rows
			foreach($this->table['thead'] as $row) {
				// begin table row
				$string .= '<tr';

				// add attributes if present
				if(!empty($row['attr'])) {
					$string .= $this->createAttributes($row['attr']);
				}

				$string .= '>';

				foreach($row as $key => $val) {
					if($key != 'attr') {
						$string .= '<th';

						$string .= $this->createAttributes($val);

						$string .= '>' . $val['content'] . '</td>';
					}
				}

				// end table row
				$string .= '</tr>' . PHP_EOL;
			}

			$string .= '</thead>' . PHP_EOL;
		}



		/**
		* create TBODY
		*/
		$string .= '<tbody>' . PHP_EOL;

		// step thru table body rows
		foreach($this->table['tbody'] as $row) {
			// begin table row
			$string .= '<tr';

			// add attributes if present
			if(!empty($row['attr'])) {
				$string .= $this->createAttributes($row['attr']);
			}

			$string .= '>';

			foreach($row as $key => $val) {
				// ignore attributes for the table row
				if($key != 'attr') {
					$string .= '<td';

					$string .= $this->createAttributes($val);

					$string .= '>' . $val['content'] . '</td>';
				}
			}

			// end table row
			$string .= '</tr>' . PHP_EOL;
		}

		// close the table body
		$string .= '</tbody>' . PHP_EOL;



		/**
		* create TFOOT if present
		*/
		if(!empty($this->table['tfoot'])) {
			$string .= '<tfoot>' . PHP_EOL;

			// step thru table header rows
			foreach($this->table['tfoot'] as $row) {
				// begin table row
				$string .= '<tr';

				// add attributes if present
				if(!empty($row['attr'])) {
					$string .= $this->createAttributes($row['attr']);
				}

				$string .= '>';

				foreach($row as $key => $val) {
					if($key != 'attr') {
						$string .= '<th';

						$string .= $this->createAttributes($val);

						$string .= '>' . $val['content'] . '</td>';
					}
				}

				// end table row
				$string .= '</tr>' . PHP_EOL;
			}

			$string .= '</tfoot>' . PHP_EOL;
		}

		// close table
		$string .= '</table>' . PHP_EOL;



		/**
		* display or return the table HTML
		*/
		if($displaytable == true) {
			// display the entire string
			echo $string;
		}
		else {
			// return the entire string
			return $string;
		}
	}









/**
* Displays the entire object for debugging purposes
*
* This function displays the entire object using a print_r() function for debugging purposes.
* @return string An output of the object values
*/
	public function showObject() {
		echo '<pre>';
		print_r($this);
		echo '</pre>';
	}




}



?>

<?php

/**
 * Quickly build tables with semantic HTML.
 * 
 * This class constructs an object arry of attributes and values for the table. Once the attributes and values have all been added, a single method is called to create the table code. The HTML can be stored in a variable or directly displayed to the screen.
 * 
 * @author Nathan Kizer <hypnokizer@gmail.com>
 * @version 7.0
 * @revision 2026-05-25 Added ability to chain methods. Simplified user interface.
 */

namespace Hypnokizer;

class Table {

	/**
	* Counter for the current row.
	* @access protected
	* @var int
	*/
	protected $rowcounter;

	/**
	* Counter for the current cell/column.
	* @access protected
	* @var int
	*/
	protected $cellcounter;

	/**
	* Current table element (table, row, cell).
	* @access protected
	* @var string
	*/
    protected $element;

	/**
	* Current table section (thead, tbody, tfoot).
	* @access protected
	* @var string
	*/
	protected $section; 

	/**
	* Table caption text.
	* @access protected
	* @var string
	*/
	protected $caption;

	/**
	* Array holding table attributes.
	* @access protected
	* @var array
	*/
    protected $table;

	/**
	* Array holding table thead attributes.
	* @access protected
	* @var array
	*/
	protected $thead;

	/**
	* Array holding table tbody attributes.
	* @access protected
	* @var array
	*/
	protected $tbody;

	/**
	* Array holding table tfoot attributes.
	* @access protected
	* @var array
	*/
	protected $tfoot;


    /**
     * Create new instance of table class.
     * 
     * Sets many of the variable defaults. The single parameter is the string of CSS class names for the table. The {@link element} and {@link section} properties identify the current HTML element (table/row/cell) or table section (thead/tbody/tfoot).
     * 
     * @param string $class String of class names for the table.
     * @return object
     */
	public function __CONSTRUCT(string $class = NULL) {
		$this->rowcounter = 0;
		$this->cellcounter = 0;
        $this->element = 'table';
		$this->section = 'tbody';

		$this->caption = NULL;

		$this->table = array(
			'class' => $class
		);

		$this->thead = array();
		$this->tbody = array();
		$this->tfoot = array();
	}


    /**
     * Set the caption element for the table.
     * 
     * @param string $text The caption string for the table.
     * @return object
     */
	public function caption(string $text) {

		$this->caption = $text;

		return $this;
	}


    /**
     * Add a new row to the table. 
     * 
     * Resets the cell counter for a new row and increments the row counter. Defines the current section of the table.
     * 
     * @param string $section Defines the current table section. Defaults to the table body.
     * @return object
     * @see attr()
     */
	public function row(string $section = 'tbody') {
        // set the current element 
        $this->element = 'row';

		// reset the cell counter
		$this->cellcounter = 0;

		// increment the row counter
		$this->rowcounter++; 

		// define allowed values for the table sections
		$allowed = array('thead', 'tbody', 'tfoot');

		if(in_array($section, $allowed)) {
			$this->section = $section;
		}
		else {
			$this->section = 'tbody';
		}

		return $this;
	}


    /**
     * Sets content for a table cell.
     * 
     * Sets content for a particular table cell. The default value is a non-breaking space so that empty cells will render correctly.
     * 
     * @param string $content Values for the table cell content.
     * @return object
     * @see attr()
     */

	public function cell(string $content = '&nbsp;') {
        // set the current element 
        $this->element = 'cell';

		// increment the cell counter
		$this->cellcounter++;

		switch($this->section) {
			case 'thead':
				$this->thead[$this->rowcounter][$this->cellcounter]['content'] = $content;
				break;

			case 'tbody':
				$this->tbody[$this->rowcounter][$this->cellcounter]['content'] = $content;
				break;

			case 'tfoot':
				$this->tfoot[$this->rowcounter][$this->cellcounter]['content'] = $content;
				break;
		}

		return $this;
	}


    /**
     * Sets attributes for current element or section.
     * 
     * Sets the attributes for the current element or section as a key value pair. Sets attributes for the table, a row, or a cell. This is determined based on the {@link element} or {@link section} values.
     * 
     * @param string $key The type of attribute.
     * @param string $val The value of the attribute.
     * @return object
     * @see row()
     * @see cell()
     */
	public function attr(string $key, string $val) {
        switch($this->element) {
            case 'table':
                $this->table[$key] = $val;
                break;

            case 'row':
                switch($this->section) {
                    case 'thead':
                        $this->thead[$this->rowcounter]['attr'][$key] = $val;
                        break;

                    case 'tbody':
                        $this->tbody[$this->rowcounter]['attr'][$key] = $val;
                        break;

                    case 'tfoot':
                        $this->tfoot[$this->rowcounter]['attr'][$key] = $val;
                        break;
                }
                break;

            case 'cell':
                switch($this->section) {
                    case 'thead':
                        $this->thead[$this->rowcounter][$this->cellcounter][$key] = $val;
                        break;

                    case 'tbody':
                        $this->tbody[$this->rowcounter][$this->cellcounter][$key] = $val;
                        break;

                    case 'tfoot':
                        $this->tfoot[$this->rowcounter][$this->cellcounter][$key] = $val;
                        break;
                }
                break;
        }

        return $this;
	}


    /**
     * Create HTML string of attributes from defined key value pairs.
     * 
     * @param array $array Array of attributes in key value pairs.
     * @return string
     * @see attr()
     */
	protected function createAttributes(array $array) {
		$attr = array();

		// create attribute array (except for content)
        if(!empty($array)) {
            foreach($array as $key => $val) {
                if($key != 'content') {
                    if(is_bool($val)) {
                        if($val == true) {
                            $attr[] = $key;
                        }
                    }
                    else {
                        $attr[] = $key . '="' . $val . '"';
                    }	
                }
            }
        }


		// create string of attributes
		$string = implode(' ', $attr);

		// add a leading space to attribute string
		if(strlen($string) > 0) {
			$string = ' ' . $string;
		}

		return $string;
	}


    /**
     * Create HTML code for the table.
     * 
     * Creates HTML code for the table rendering table sections only if present. The parameter decides if the table output is echoed to the browser or returned to a variable.
     * 
     * @param bool $displaytable Determines if output is echoed to browser or returned to a variable. The default is echo to browser.
     * @return mixed
     */
	public function createTable(bool $displaytable = true) {
		// open the table tag
		$string = '<table';

		// create table attributes
		$string .= $this->createAttributes($this->table);

        // close the table tag
		$string .= '>' . PHP_EOL;

        // show the caption if present
		if(!empty($this->caption)) {
			$string .= '<caption>' . $this->caption . '</caption>' . PHP_EOL;
		}


		// create THEAD if present
		if(!empty($this->thead)) {
			$string .= '<thead>' . PHP_EOL;

			// step thru table header rows
			foreach($this->thead as $row) {
				// begin table row
				$string .= '<tr';

                if(array_key_exists('attr', $row)) {
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


        // create TBODY
		$string .= '<tbody>' . PHP_EOL;

		// step thru table body rows
		foreach($this->tbody as $row) {
			// begin table row
			$string .= '<tr';

            if(array_key_exists('attr', $row)) {
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



		// create TFOOT if present
		if(!empty($this->tfoot)) {
			$string .= '<tfoot>' . PHP_EOL;

			// step thru table header rows
			foreach($this->tfoot as $row) {
				// begin table row
				$string .= '<tr';

                if(array_key_exists('attr', $row)) {
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



		// display or return the table HTML
		if($displaytable == true) {
			echo $string; // display the entire string
		}
		else {
			return $string; // return the entire string
		}
	}


    /**
     * Display the entire object for debugging purposes.
     * 
     * @return string
     */
	public function showObject() {
		echo '<pre>';
		print_r($this);
		echo '</pre>';
	}


}

?>
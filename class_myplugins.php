<?php

/**
 * Implements a line of the myplugins.csv file
 * enabling the values for each component to be estimated.
 *
 * Class myplugins
 */


class myplugins {

	public $date = null;
	public $total = null;
	public $real = null;
	public $components = null;

	function __construct( $csvline=null ) {
		if ( $csvline) {
			$this->csvline( $csvline );
		}

	}

	function csvline( $csvline ) {
		$csvline = trim( $csvline );
		$fields = explode( ',', $csvline );
		$this->date = array_shift( $fields );
		$this->total = array_shift( $fields );
		$this->real = array_shift( $fields );
		$this->components = $fields;
	}

	/**
	 * We want to deal with dates as ccyy-mm-dd
	 * so that we can easily find the 1st of each month
	 */
	function get_date() {
		return $this->date;
	}

	/**
	 * Converts the object back to the CSV line.
	 *
	 * Strings are not quoted. Trailing commas may appear in the components list.
	 *
	 * @return string Comma separated CSV line
	 */

	function as_csv() {
		$csv_arr = [];
		$csv_arr[] = $this->date;
		$csv_arr[] = $this->total;
		$csv_arr[] = $this->real;
		$csv_line = implode( ',', $csv_arr );
		$csv_line .= ',';
		$csv_line .= implode( ',', $this->components );
		return $csv_line;
	}

}
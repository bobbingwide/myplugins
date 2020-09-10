<?php


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

		//print_r( $this );

	}

	/**
	 * We want to deal with dates as ccyy-mm-dd
	 * so that we can easily find the 1st of each month
	 */
	function get_date() {
		return $this->date;
	}



}
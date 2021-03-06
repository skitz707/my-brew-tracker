<?php
//-------------------------------------------------------------------------------------------
// MBTObject.php - Top level object class
// myBrewTracker.com
// Written by: Michael C. Szczepanik
// July 6th, 2018
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// class includes
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// class definition
//-------------------------------------------------------------------------------------------
abstract class MBTObject {
	// public variable declaration
	protected $database;
	
	
	//-----------------------------------------------------------------------
	// constructor function
	//-----------------------------------------------------------------------
	public function __construct($database) {
		$this->database = $database;
	}
	//-----------------------------------------------------------------------
	
	
	//-----------------------------------------------------------------------
	// print contents of object properties
	//-----------------------------------------------------------------------
	public function description() {
		//echo "Description (Object)\n";
		
		$classPropertiesArray = get_object_vars($this);
		
		var_dump($classPropertiesArray);
	}
	//-----------------------------------------------------------------------
	
	
	//-----------------------------------------------------------------------
	// reset variables in class object
	//-----------------------------------------------------------------------
	protected function resetObject() {
		foreach (get_class_vars(get_class($this)) as $var => $value) {
			if ($var != "database") {
				$this->$var = null;
			}
		}
	}
	//-----------------------------------------------------------------------
}
//-------------------------------------------------------------------------------------------
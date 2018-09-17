<?php
//-------------------------------------------------------------------------------------------
// MBTBeer.php - Beer Class Structure
// myBrewTracker.com
// Written by: Michael C. Szczepanik
// September 17, 2018
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// includes
//-------------------------------------------------------------------------------------------
include_once("classes/MBTObject.php");
//-------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------
// beer class definition
//-------------------------------------------------------------------------------------------
class MBTBeer extends MBTObject {
	// class properties
	protected $id;
	protected $typeName;
	
	
	//-------------------------------------------------------------------------------
	// load recipie by id
	//-------------------------------------------------------------------------------
	public function loadYeastById($id) {
		$beerTypeHeader = $this->database->getDatabaseRecord("mybrew.beerTypes", array("beerTypeId"=>$id));
		
		$this->id = $id;
		$this->typeName = $yeastHeader['typeName'];
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get yeast name
	//-------------------------------------------------------------------------------
	public function getBeerTypeName() {
		return $this->typeName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get beer type dropdown menu
	//-------------------------------------------------------------------------------
	public function getBeerTypeDropDown($selected) {
		$selectStmt = "select * from mybrew.beerTypes order by typeName asc";
		$returnHTML = "";
		
		$returnHTML .= '<select id="beerTypeId" name="beerTypeId">';
		
		if ($selectHandle = $this->database->databaseConnection->prepare($selectStmt)) {
			if (!$selectHandle->execute()) {
				var_dump($this->database->databaseConnection->errorInfo());
			}
			
			while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
				$returnHTML .= '<option value="' . $data['beerTypeId'] . '" />' . $data['typeName'] . '</option>';
			}
		} else {
			var_dump($database->databaseConnection->errorInfo());
		}
		
		$returnHTML .= '</select>';
		
		return $returnHTML;
	}
	//-------------------------------------------------------------------------------
}	
//-------------------------------------------------------------------------------------------
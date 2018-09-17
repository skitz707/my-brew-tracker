<?php
//-------------------------------------------------------------------------------------------
// MBTHop.php - Hop Class Structure
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
// hop class definition
//-------------------------------------------------------------------------------------------
class MBTHop extends MBTObject {
	// class properties
	protected $id;
	protected $hopName;
	protected $averageAA;
	
	
	//-------------------------------------------------------------------------------
	// load hop by id
	//-------------------------------------------------------------------------------
	public function loadHopById($id) {
		$hop = $this->database->getDatabaseRecord("mybrew.hops", array("hopId"=>$id));
		
		$this->id = $id;
		$this->hopName = $hop['hopName'];
		$this->averageAA = $hop['averageAA'];
	}
	//-------------------------------------------------------------------------------

	
	//-------------------------------------------------------------------------------
	// get hop types drop down menu
	//-------------------------------------------------------------------------------
	public function getHopTypesDropDownHTML($selected) {
		$selectStmt = "select * from mybrew.hops order by hopName asc";
		$returnHTML = "";
		
		$returnHTML .= '<select id="hopId" name="hopId">';
		
		if ($selectHandle = $this->database->databaseConnection->prepare($selectStmt)) {
			if (!$selectHandle->execute()) {
				var_dump($this->database->databaseConnection->errorInfo());
			}
			
			while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
				$returnHTML .= '<option value="' . $data['hopId'] . '" />' . $data['hopName'] . '</option>';
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
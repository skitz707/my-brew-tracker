<?php
//-------------------------------------------------------------------------------------------
// MBTGrainr.php - Grain Class Structure
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
// grain class definition
//-------------------------------------------------------------------------------------------
class MBTGrain extends MBTObject {
	// class properties
	protected $id;
	protected $grainName;
	protected $country;
	protected $color;
	protected $gravity;
	
	
	//-------------------------------------------------------------------------------
	// load grain by id
	//-------------------------------------------------------------------------------
	public function loadGrainById($id) {
		$grain = $this->database->getDatabaseRecord("mybrew.grains", array("grainId"=>$id));
		
		$this->id = $id;
		$this->grainName = $grain['grainName'];
		$this->country = $grain['country'];
		$this->color = $grain['color'];
		$this->gravity = $grain['gravity'];
	}
	//-------------------------------------------------------------------------------

	
	//-------------------------------------------------------------------------------
	// get grain types drop down menu
	//-------------------------------------------------------------------------------
	public function getGrainTypesDropDownHTML($selected) {
		$selectStmt = "select * from mybrew.grains order by grainName asc";
		$returnHTML = "";
		
		$returnHTML .= '<select id="grainId" name="grainId">';
		
		if ($selectHandle = $this->database->databaseConnection->prepare($selectStmt)) {
			if (!$selectHandle->execute()) {
				var_dump($this->database->databaseConnection->errorInfo());
			}
			
			while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
				$returnHTML .= '<option value="' . $data['grainId'] . '" />' . $data['grainName'] . ' - ' . $data['country'] . '</option>';
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
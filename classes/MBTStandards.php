<?php
//-------------------------------------------------------------------------------------------
// MBTStandards.php - Standards Class Structure
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
// standards class definition
//-------------------------------------------------------------------------------------------
class MBTStandards extends MBTObject {
	// class properties


	//-------------------------------------------------------------------------------
	// get unit of measure drop down html
	//-------------------------------------------------------------------------------
	public function getUnitOfMeasureDropDownHTML($fieldSuffix, $selected) {
		$selectStmt = "select * from mybrew.unitOfMeasure order by unitOfMeasure asc";
		$returnHTML = "";
		
		$returnHTML .= '<select id="unitOfMeasureId' . $fieldSuffix . '" name="unitOfMeasureId' . $fieldSuffix . '">';
		
		if ($selectHandle = $this->database->databaseConnection->prepare($selectStmt)) {
			if (!$selectHandle->execute()) {
				var_dump($database->databaseConnection->errorInfo());
			}
			
			while ($data = $selectHandle->fetch(PDO::FETCH_ASSOC)) {
				$returnHTML .= '<option value="' . $data['unitOfMeasureId'] . '">' . $data['unitOfMeasure'] . '</option>';
			}
		} else {
			var_dump($this->database->databaseConnection->errorInfo());
		}
		
		$returnHTML .= '</select>';
		
		return $returnHTML;
	}
	//-------------------------------------------------------------------------------
}	
//-------------------------------------------------------------------------------------------
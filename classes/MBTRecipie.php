<?php
//-------------------------------------------------------------------------------------------
// MBTRecipie.php - Recipie Class Structure
// myBrewTracker.com
// Written by: Michael C. Szczepanik
// July 6th, 2018
//-------------------------------------------------------------------------------------------



//-------------------------------------------------------------------------------------------
// includes
//-------------------------------------------------------------------------------------------
include_once("classes/MBTObject.php");
//-------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------
// recipie class definition
//-------------------------------------------------------------------------------------------
class MBTRecipie extends MBTObject {
	// class properties
	protected $id;
	protected $ownerId;
	protected $recipieName;
	protected $beerTypeId;
	protected $beerTypeName;
	protected $yeastId;
	protected $averageIBU;
	protected $averageABV;
	protected $originalGravity;
	protected $finalGravity;
	protected $mashTemperature;
	protected $mashTime;
	protected $batchSize;
	protected $batchUnitOfMeasureId;
	protected $batchUnitOfMeasureName;
	protected $boilSize;
	protected $boilUnitOfMeasureId;
	protected $boilTime;
	protected $ingredients;
	protected $grains;
	protected $sugars;
	protected $fruits;
	protected $hops;
	protected $lastChange;
	protected $creationDate;
	
	
	//-------------------------------------------------------------------------------
	// load recipie by id
	//-------------------------------------------------------------------------------
	public function loadRecipieById($recipieId) {
		$recipieHeader = $this->database->getDatabaseRecord("mybrew.recipieHeader", array("recipieId"=>$recipieId));
		
		$this->recipieId = $recipieId;
		$this->ownerId = $recipieHeader['ownerId'];
		$this->recipieName = $recipieHeader['recipieName'];
		$this->beerTypeId = $recipieHeader['beerTypeId'];
		$this->yeastId = $recipieHeader['yeastId'];
		$this->averageIBU = $recipieHeader['averageIBU'];
		$this->averageABV = $recipieHeader['averageABV'];
		$this->originalGravity = $recipieHeader['originalGravity'];
		$this->finalGravity = $recipieHeader['finalGravity'];
		$this->mashTemperature = $recipieHeader['mashTemp'];
		$this->mashTime = $recipieHeader['mashTime'];
		$this->batchSize = $recipieHeader['batchSize'];
		$this->batchUnitOfMeasureId = $recipieHeader['batchUnitOfMeasureId'];
		$this->boilSize = $recipieHeader['boilSize'];
		$this->boilUnitOfMeasureId = $recipieHeader['boilUnitOfMeasureId'];
		$this->boilTime = $recipieHeader['boilTime'];
		$this->lastChange = $recipieHeader['lastChange'];
		$this->creationDate = $recipieHeader['creationDate'];
		
		// load ingredients
		$this->loadIngredients();
		
		// load beer type name
		$beerTypeName = $this->database->getDatabaseRecord("mybrew.beerTypes", array("beerTypeId"=>$this->beerTypeId));
		$this->beerTypeName = $beerTypeName['typeName'];
		
		// load batch size uom
		$batchUOM = $this->database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$this->batchUnitOfMeasureId));
		$this->batchUnitOfMeasureName = $batchUOM['unitOfMeasure'];
		
		// load boil size uom
		$boilUOM = $this->database->getDatabaseRecord("mybrew.unitOfMeasure", array("unitOfMeasureId"=>$this->boilUnitOfMeasureId));
		$this->boilUnitOfMeasureName = $boilUOM['unitOfMeasure'];
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// load ingredients
	//-------------------------------------------------------------------------------
	private function loadIngredients() {
		// load ingredient ids
		$detailStmt = "select * from mybrew.recipieDetail where recipieId = ?";
		$this->ingredient = array();
		$this->grains = array();
		$this->sugars = array();
		$this->fruits = array();
		$this->hops = array();
		
		if ($detailHandle = $this->database->databaseConnection->prepare($detailStmt)) {
			if (!$detailHandle->execute(array(0=>$this->recipieId))) {
				var_dump($this->database->databaseConnection->errorInfo());
			}
			
			while ($detailData = $detailHandle->fetch(PDO::FETCH_ASSOC)) {
				$this->ingredients[] = $detailData['recipieDetailId'];
				
				if ($detailData['ingredientType'] == "G") {
					$this->grains[] = $detailData['recipieDetailId'];
				} else if ($detailData['ingredientType'] == "S") {
					$this->sugars[] = $detailData['recipieDetailId'];
				} else if ($detailData['ingredientType'] == "F") {
					$this->fruits[] = $detailData['recipieDetailId'];
				} else if ($detailData['ingredientType'] == "H") {
					$this->hops[] = $detailData['recipieDetailId'];
				}
			}
		} else {
			var_dump($database->databaseConnection->errorInfo());
		}
	}
	//-------------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------------
	// get recipie header html
	//-------------------------------------------------------------------------------
	function getRecipieHeaderHTML() {
		$returnHTML = "";
	
		$returnHTML .= 
			$this->recipieName . ' (' . $this->beerTypeName . ') <br />
			ABV: ' . $this->averageABV . ' IBUs: ' . $this->averageIBU . " Boil Time: " . $this->boilTime . " min.<br />
			Batch Size: " . $this->batchSize . " " . $this->batchUnitOfMeasureName . "
			Boil Size: " . $this->boilSize . " " . $this->boilUnitOfMeasureName . "<br />
			Original Gravity: " . $this->originalGravity . " Final Gravity: " . $this->finalGravity;
			
		return $returnHTML;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get recipie name
	//-------------------------------------------------------------------------------
	public function getRecipieName() {
		return $this->recipieName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get beer type name
	//-------------------------------------------------------------------------------
	public function getBeerTypeName() {
		return $this->beerTypeName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get average IBU
	//-------------------------------------------------------------------------------
	public function getAverageIBU() {
		return $this->averageIBU;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get average ABV
	//-------------------------------------------------------------------------------
	public function getAverageABV() {
		return $this->averageABV;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get batch size
	//-------------------------------------------------------------------------------
	public function getBatchSize() {
		return $this->batchSize;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get batch unit of measure name
	//-------------------------------------------------------------------------------
	public function getBatchUnitOfMeasureName() {
		return $this->batchUnitOfMeasureName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get boil size
	//-------------------------------------------------------------------------------
	public function getBoilSize() {
		return $this->boilSize;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get boil unit of measure name
	//-------------------------------------------------------------------------------
	public function getBoilUnitOfMeasureName() {
		return $this->boilUnitOfMeasureName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get boil time
	//-------------------------------------------------------------------------------
	public function getBoilTime() {
		return $this->boilTime;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get mash time
	//-------------------------------------------------------------------------------
	public function getMashTime() {
		return $this->mashTime;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get yeast name
	//-------------------------------------------------------------------------------
	public function getYeastId() {
		return $this->yeastId;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get original gravity
	//-------------------------------------------------------------------------------
	public function getOriginalGravity() {
		return $this->originalGravity;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get final gravity
	//-------------------------------------------------------------------------------
	public function getFinalGravity() {
		return $this->finalGravity;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get grains
	//-------------------------------------------------------------------------------
	public function getGrains() {
		return $this->grains;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get hops
	//-------------------------------------------------------------------------------
	public function getHops() {
		return $this->hops;
	}
	//-------------------------------------------------------------------------------
}	
//-------------------------------------------------------------------------------------------
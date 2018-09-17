<?php
//-------------------------------------------------------------------------------------------
// MBTYeast.php - Yeast Class Structure
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
// yeast class definition
//-------------------------------------------------------------------------------------------
class MBTYeast extends MBTObject {
	// class properties
	protected $id;
	protected $yeastName;
	protected $supplierId;
	protected $supplierName;
	protected $yeastTypeId;
	protected $yeastTypeName;
	protected $flocculation;
	protected $attenuation;
	protected $minTemp;
	protected $maxTemp;
	protected $lastChange;
	protected $creationDate;
	
	
	//-------------------------------------------------------------------------------
	// load recipie by id
	//-------------------------------------------------------------------------------
	public function loadYeastById($yeastId) {
		$yeastHeader = $this->database->getDatabaseRecord("mybrew.yeasts", array("yeastId"=>$yeastId));
		
		$this->id = $yeastId;
		$this->yeastName = $yeastHeader['yeastName'];
		$this->supplierId = $yeastHeader['supplierId'];
		$this->yeastTypeId = $yeastHeader['yeastTypeId'];
		$this->flocculation = $yeastHeader['flocculation'];
		$this->attenuation = $yeastHeader['attenuation'];
		$this->minTemp = $yeastHeader['minTemp'];
		$this->maxTemp = $yeastHeader['maxTemp'];
		$this->lastChange = $yeastHeader['lastChange'];
		$this->creationDate = $yeastHeader['creationDate'];
		
		// get supplier name
		$supplierName = $this->database->getDatabaseRecord("mybrew.suppliers", array("supplierId"=>$this->supplierId));
		$this->supplierName = $supplierName['supplierName'];
		
		// get yeast type name
		$yeastTypeName = $this->database->getDatabaseRecord("mybrew.yeastTypes", array("yeastTypeId"=>$this->yeastTypeId));
		$this->yeastTypeName = $yeastTypeName['yeastType'];
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get yeast name
	//-------------------------------------------------------------------------------
	public function getYeastName() {
		return $this->yeastName;
	}
	//-------------------------------------------------------------------------------
	
	
	//-------------------------------------------------------------------------------
	// get supplier name
	//-------------------------------------------------------------------------------
	public function getSupplierName() {
		return $this->supplierName;
	}
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

}	
//-------------------------------------------------------------------------------------------
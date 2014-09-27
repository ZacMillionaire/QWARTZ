<?php 

class FitnessTemplates extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();

	} // End Class Constructor


	public function GetSavedTemplatesList(){

		$sql = "SELECT *
				FROM `fitnesstemplates`
				ORDER BY `dateAdded` DESC";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	} // End GetSavedTemplatesList


	public function GetSavedTemplatesByID($templateID){

		$sql = "SELECT *
				FROM `fitnesstemplates`
				WHERE `templateID` = :templateID;";
		$params = array(
			"templateID"=>$templateID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	} // End GetSavedTemplatesByID

}

?>
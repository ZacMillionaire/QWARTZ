<?php

class DataLockSystem extends System {
	
	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();
		$this->UserSystem = parent::GetUserSystem();

	} // End Class Constructor
	
	public function LockPlayerData($playerID,$userID){

		date_default_timezone_set('Australian/Brisbane');

		$sql = "UPDATE `playerdetails` SET `lastEditOwner` = :userID, `lastEditDateTime` = :editDate WHERE `PlayerID` = :playerID;";
		$params = array(
			"userID" => $userID,
			"playerID" => $playerID,
			"editDate" => date("Y-m-d g:i:s",time())
		);

		$update = $this->DatabaseSystem->dbQuery($sql,$params);

	}

	public function GetPlayerDataLockStatus($playerID) {

		$sql = "SELECT `lastEditOwner`,`lastEditDateTime` FROM `playerDetails` WHERE `playerID` = :playerID;";
		$params = array(
			"playerID" => $playerID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	}

	public function LockTemplateData($templateUID,$userID){

		date_default_timezone_set('Australian/Brisbane');

		$sql = "UPDATE `fitnesstemplates` SET `lastEditOwner` = :userID, `lastEditDateTime` = :editDate WHERE `templateUID` = :templateUID;";
		$params = array(
			"userID" => $userID,
			"templateUID" => $templateUID,
			"editDate" => date("Y-m-d g:i:s",time())
		);

		$update = $this->DatabaseSystem->dbQuery($sql,$params);

	}

	public function GetTemplateDataLockStatus($templateUID) {
		$sql = "SELECT `lastEditOwner`,`lastEditDateTime` FROM `fitnesstemplates` WHERE `templateUID` = :templateUID;";
		$params = array(
			"templateUID" => $templateUID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	}
	
	public function LockTestData($testID,$userID){

		date_default_timezone_set('Australian/Brisbane');

		$sql = "UPDATE `playertestinginfo` SET `lastEditOwner` = :userID, `lastEditDateTime` = :editDate WHERE `playerTestID` = :testID;";
		$params = array(
			"userID" => $userID,
			"testID" => $testID,
			"editDate" => date("Y-m-d g:i:s",time())
		);

		$update = $this->DatabaseSystem->dbQuery($sql,$params);

	}

	public function GetTestDataLockStatus($testID) {

		$sql = "SELECT `lastEditOwner`,`lastEditDateTime` FROM `playertestinginfo` WHERE `playerTestID` = :testID;";
		$params = array(
			"testID" => $testID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	}

}


?>
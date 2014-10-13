<?php

class Players extends System {
	
	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();
		$this->UserSystem = parent::GetUserSystem();
		$this->DataLockSystem = parent::GetDataLockSystem();

	} // End Class Constructor



	public function GetPlayerList() {

		$sql = "SELECT * FROM `playerdetails`;";
		$params = null;
		$results = $this->DatabaseSystem->dbQuery($sql,$params);

		return $results;

	}


	public function CreateNewPlayer($newPlayerData) {

		foreach ($newPlayerData as $key => $value) {
			if($value == null){
				return array(
					"error" => parent::CamelToEnglish($key)." is missing a value"
				);
			}
		}

		$sql = "INSERT INTO `playerdetails`
					(
						`FirstName`,
						`LastName`,
						`Position`,
						`Weight`
					)
				VALUES
					(
						:firstName,
						:lastName,
						:position,
						:weight
					);";
		$params = array(
			"firstName" => ucfirst($newPlayerData["firstName"]),
			"lastName" => ucfirst($newPlayerData["lastName"]),
			"position" => ucfirst($newPlayerData["position"]),
			"weight" => $newPlayerData["weight"]
		);

		$insert = $this->DatabaseSystem->dbInsert($sql,$params);

		if($insert){

			$sql = "SELECT `PlayerID` FROM `playerdetails` WHERE `FirstName` = :firstName AND `LastName` = :lastName;";
			$params = array(
				"firstName" => $newPlayerData["firstName"],
				"lastName" => $newPlayerData["lastName"]
			);

			$result = $this->DatabaseSystem->dbQuery($sql,$params);

			return array("success" => $result[0]);

		} else {
			return array("error" => "Player creation failed: Player Already Exists with that name combination");
		}

	} // End CreateNewPlayer


	public function UpdatePlayer($newPlayerData) {

		foreach ($newPlayerData as $key => $value) {
			if($value == null){
				return array(
					"error" => parent::CamelToEnglish($key)." is missing a value"
				);
			}
		}

		$sql = "UPDATE `playerdetails`
				SET
					`FirstName`= :firstName,
					`LastName`= :lastName,
					`Position`= :position,
					`Weight`= :weight,
					`profilePicture`= :profilePicture
				WHERE `PlayerID` = :playerID;";
		$params = array(
			"playerID" => $newPlayerData["playerID"],
			"firstName" => ucfirst($newPlayerData["firstName"]),
			"lastName" => ucfirst($newPlayerData["lastName"]),
			"position" => ucfirst($newPlayerData["position"]),
			"weight" => $newPlayerData["weight"],
			"profilePicture" => null
		);

		$insert = $this->DatabaseSystem->dbInsert($sql,$params);

		$userID = $this->UserSystem->GetUserIDFromHash($_COOKIE["loginHash"]);
		$playerID = $newPlayerData["playerID"];

		$this->DataLockSystem->LockPlayerData($playerID,$userID);

		if($insert){

			return array("success" => $newPlayerData["playerID"]);

		} else {
			return array("error" => "Player not found.");
		}

	} // End UpdatePlayer


	public function GetPlayerData($playerID) {

		$playerDetails = $this->DataCollection->GetPlayerDetailsByID($playerID);
		$playerTestData = $this->DataCollection->GetPlayerTestData($playerID);
		$playerTemplates = $this->DataCollection->GetPlayerTemplates($playerID);

		return array(
			"playerInfo" => $playerDetails,
			"testData" => $playerTestData,
			"templateData" => $playerTemplates
		);
	}

}

?>
<?php 

class FitnessTests extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();

	} // End Class Constructor


}

?>
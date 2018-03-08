<?php

	class droger {
		private $servername = getenv('SERVERNAME');
		private $username = getenv('USERNAME');
		private $password = getenv('PWD');
		private $dbname = getenv('DBNAME');
		private $collage = array();


		function __construct(){
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($this->conn->connect_error) {
				die("Connection failed: " . $this->conn->connect_error);
			}
		}

		private function retrieveCollage(){
			$sql = "SELECT DISTINCT * FROM `collage` WHERE `softdelete` = 0";
			$result = $this->conn->query($sql);

			while ($row = $result->fetch_assoc()) {
				$temp = array();
				foreach ($row as $key => $value) {
					$temp[$key] = $value;
				}
				array_push($this->collage, $temp);
			}
			return $this->collage;
		}

		public function getCollage(){
			if (sizeof($this->collage) > 0) {
				return $this->collage;
			} else {
				return $this->retrieveCollage();
			}
		}
	}

?>
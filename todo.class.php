<?php

class ToDo {
	
	private $_dataArray,
			$_dataArrayJson,
			$_dataName;

	public function __construct($dataName = false) {
		if ($dataName) {
			$this->_dataName = $dataName;
		} else {
			$this->_dataName = "data.txt";
		}
	}

	private function getToDoArray() {
		$handel = fopen($this->_dataName, "r");
		$this->_dataArrayJson = fread($handel, filesize ($this->_dataName));
		$this->_dataArray = json_decode($this->_dataArrayJson, true);
		fclose($handel);
	}

	private function setToDoArray($create, $editToDo = "") {
		if($create == "add") {
			$this->_dataArrayJson = json_encode($this->_dataArray + $editToDo);
		} else {
			$this->_dataArrayJson = json_encode($this->_dataArray);
		}
		$handle = fopen ($this->_dataName, "w");
		fwrite ($handle, $this->_dataArrayJson);
		fclose ($handle);
		self::getToDoArray();
	}

	public function setToDo($newToDo) {
		if ($newToDo != "") {
			self::getToDoArray();
			$newToDo = array($newToDo => "true");
			self::setToDoArray("add", $newToDo);
			header('Location: https://ips.codes/');
		}
	}

	public function delToDo($idToDo) {
		if (is_numeric($idToDo)) {
			self::getToDoArray();
			$arrayKeys = array_keys($this->_dataArray);
			unset($this->_dataArray[$arrayKeys[--$idToDo]]);
			self::setToDoArray("remove");
			header('Location: https://ips.codes/');
		}
	}

	public function getToDo() {
		self::getToDoArray();
		$arrayCount = count($this->_dataArray);
		$arrayKeys = array_keys($this->_dataArray);
		for ($i=0; $i < $arrayCount; $i++) { 
			$del = $i;
			echo '<h4>';
			if ($this->_dataArray[$arrayKeys[$i]] == "false") {
				echo '<tr><th><s>' . $arrayKeys[$i] . '</s></th> <th><a href="?succes=' . $i . '">[X]</a></th>';
			} else {
				echo '<th>' . $arrayKeys[$i] . '</th> <th><a href="?succes=' . $i . '">[✓]</a></th>';
			}
			echo ' <th><a href="?delet=' . ++$del . '">[Löschen]</a></h4></th></tr>';
		}
	}
}
?>
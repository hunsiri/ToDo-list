<?php

class ToDo {
	
	private $_dataArray,
			$_dataArrayJson,
			$_dataName;

	public function __construct($dataName = false) {
		if ($dataName) {
			$this->_dataName = 'saves/' . $dataName;
		} else {
			$this->_dataName = "saves/data.txt";
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
		header('Location: http://' . htmlspecialchars($_SERVER["HTTP_HOST"]));
	}

	public function setToDo($newToDo) {
		if ($newToDo != "") {
			self::getToDoArray();
			$newToDo = array($newToDo => "true");
			self::setToDoArray("add", $newToDo);
		}
	}

	public function delToDo($idToDo) {
		if (is_numeric($idToDo)) {
			self::getToDoArray();
			$arrayKeys = array_keys($this->_dataArray);
			unset($this->_dataArray[$arrayKeys[--$idToDo]]);
			self::setToDoArray("remove");
		}
	}

	public function changeToDo($idToDo) {
		if (is_numeric($idToDo)) {
			self::getToDoArray();
			$arrayKeys = array_keys($this->_dataArray);
			if ($this->_dataArray[$arrayKeys[--$idToDo]] == "true") {
				$this->_dataArray[$arrayKeys[$idToDo]] = "false";
			} else {
				$this->_dataArray[$arrayKeys[$idToDo]] = "true";
			}
			self::setToDoArray("change");
		}
	}

	public function getToDo() {
		self::getToDoArray();
		$arrayCount = count($this->_dataArray);
		$arrayKeys = array_keys($this->_dataArray);
		for ($i=0; $i < $arrayCount; $i++) { 
			$newi = $i;
			echo '<h4>';
			if ($this->_dataArray[$arrayKeys[$i]] == "false") {
				echo '<tr><th><s>' . $arrayKeys[$i] . '</s></th> <th><a href="?change=' . ++$newi . '">[X]</a></th>';
			} else {
				echo '<th>' . $arrayKeys[$i] . '</th> <th><a href="?change=' . ++$newi . '">[✓]</a></th>';
			}
			echo ' <th><a href="?delet=' . $newi . '">[Löschen]</a></h4></th></tr>';
		}
	}
}
?>
<?php

class ToDo {
	
	private $_dataArray,
			$_dataName;

	//constructor muss in andere function verschoben werden das die datei erst nach enderung geladen wird.
	public function __construct($dataName = false) {
		$this->_dataName = $dataName;
		$handel = fopen($this->_dataName, "r");
		$this->_dataArray = fread($handel, filesize ($dataName));
		$this->_dataArray = json_decode($this->_dataArray, true);
		fclose($handel);
	}

	private function getToDoArray() {

	}

	public function setToDo($newToDo) {
		if ($newToDo != "") {
			$newToDo = array($newToDo => "true");
			$arrayJson = json_encode($this->_dataArray + $newToDo);
			$handle = fopen ($this->_dataName, "w");
			fwrite ($handle, $arrayJson);
			fclose ($handle);
		}
	}

	public function delToDo($idToDo) {
		if (is_numeric($idToDo)) {
			$arrayKeys = array_keys($this->_dataArray);
			$arrayData = $this->_dataArray;
			print_r($arrayKeys[--$idToDo]);
			unset($arrayData[$arrayKeys[$idToDo]]);
			$arrayJson = json_encode($arrayData);
			$handle = fopen ($this->_dataName, "w");
			fwrite ($handle, $arrayJson);
			fclose ($handle);
			header('Location: https://todo.ips.codes/');
		}
	}

	public function getToDo() {
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
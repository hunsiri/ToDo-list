<?php
	$newData = htmlspecialchars($_POST["new"]);
	$changeData = htmlspecialchars($_GET["change"]);
	$deletData = htmlspecialchars($_GET["delet"]);

	require_once 'classes/todo.class.php';

	$todo = new ToDo('data.txt');

	if (isset($newData)) {
		$todo->setToDo($newData);
	}

	if (isset($changeData)) {
		$todo->changeToDo($changeData);
	}

	if (isset($deletData)) {
		$todo->delToDo($deletData);
	}
?>

<!doctype html>

<html lang="de">
<head>
  <meta charset="utf-8">
  <title>ToDo List</title>
</head>
<body>
<div class="cont">
  <center>
  <form action="" method="post">
  <p>Add a task: <input type="text" size="50" value="" name="new">
  <input type="submit" value="Submit" name="submitbutton"></p>
  </form>
  	<table border="1"> 
	<?php
 		$todo->getToDo();
 	?>
  	</table>
  </center>
</div>
</body>
</html>
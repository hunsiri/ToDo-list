<?php
	$newData = htmlspecialchars($_POST["new"]);
	$succesData = htmlspecialchars($_GET["succes"]);
	$deletData = htmlspecialchars($_GET["delet"]);

	require_once 'todo.class.php';

	$todo = new ToDo('data.txt');

	if (isset($newData)) {
		$todo->setToDo($newData);
	}

	if (isset($succesData)) {

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
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.2/gh-fork-ribbon.min.css" />
  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono" rel="stylesheet"> 
</head>
<body>
<a class="github-fork-ribbon" href="https://github.com/ipsKenni/Wordpress-themes-finder" data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>
<div class="cont">
  <center>
  <form action="" method="post">
  <p>Aufgabe Hinzufügen: <input type="text" size="50" value="" name="new">
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
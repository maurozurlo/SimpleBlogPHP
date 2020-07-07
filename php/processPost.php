<?php
include "_auth.php";
include "_dbConfig.php";

if(isset($_POST['accion'])){
	$accion = $_POST['accion'];
	$id = $_POST['id'];
	$titulo = $_POST['titulo'];
	$fecha = $_POST['fecha'] ? $_POST['fecha'] : date("Y-m-d H:i:s");
	$estado = $_POST['estado'];
	$contenido = $_POST['contenido'];
	$autor = $_SESSION['name'];
	switch ($accion) {
		case 'nuevo':
			createPost($titulo,$estado,$contenido,$autor,$fecha);
			break;
		case 'actualiza':
			updatePost($titulo,$estado,$contenido,$autor,$fecha,$id);
			break;
		case 'eliminar':
			deletePost($id);
			break;
		default:
			echo "error";
			break;
	}
}

function deletePost($id){
	$sql = "DELETE FROM `posts` WHERE `id` = {$id}";
	QueryDatabase($sql);
}

function createPost($titulo,$estado,$contenido,$autor,$fecha){
	$sql = "INSERT INTO `posts` (`title`, `state`, `content`,`ts`,`idAuthor`) VALUES ('{$titulo}','{$estado}','{$contenido}','{$fecha}','{$autor}')";
	QueryDatabase($sql);
}

function updatePost($titulo,$estado,$contenido,$autor,$fecha,$id){
	$sql = "UPDATE `posts` SET `title` = '{$titulo}', `state` = '{$estado}', `content` = '{$contenido}', `ts` = '{$fecha}', `idAuthor` = '{$autor}' WHERE `id` = {$id}";
	QueryDatabase($sql);
}

function QueryDatabase($sql){
global $con;
$result = mysqli_query($con, $sql) or die("Failed to Query database ".$con->error);
echo "dashboard.php";
}

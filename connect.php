<?php


$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
    exit;
}

mysqli_close($link);
?>


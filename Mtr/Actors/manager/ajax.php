<?php

$action = $_GET['action'];
include 'class.php';
$crud = new Action();

if($action == 'save_movie'){
	$logout = $crud->save_movie();
	if($logout)
		echo $logout;
}
if($action == 'save_theater'){
	$logout = $crud->save_theater();
	if($logout)
		echo $logout;
}
if($action == 'delete_movie'){
	$delete = $crud->delete_movie();
	if($delete)
		echo $delete;
}

if($action == 'delete_theater'){
	$delete = $crud->delete_theater();
	if($delete)
		echo $delete;
}
if($action == 'save_seat'){
	$logout = $crud->save_seat();
	if($logout)
		echo $logout;
}
if($action == 'delete_seat'){
	$delete = $crud->delete_seat();
	if($delete)
		echo $delete;
}
/*
if($action == 'save_reserve'){
	$save = $crud->save_reserve();
	if($save)
		echo $save;
}
<?php
session_start();
require '../classes/class.db_local.php';
$db = new db_connect();

$sql = 'DELETE FROM project5_kosiky WHERE id = ' . $_POST['ID'];
$ajaxData['sql'] = $sql;
$db->db()->query($sql);
$ajaxData['action'] = 'deleteProduct';

$ajaxData['kosik_id'] = $_POST['ID'];

echo json_encode($ajaxData);
exit();

<?php
session_start();
require '../classes/class.db_local.php';
$db = new db_connect();

//  Increase mnozstvi in db, then update it via javascript
$sql =
    'UPDATE project5_kosiky SET mnozstvi = mnozstvi + 1 WHERE id = ' .
    $_POST['ID'];
$db->db()->query($sql);
$ajaxData['action'] = 'higherAmount';

$ajaxData['kosik_id'] = $_POST['ID'];

echo json_encode($ajaxData);
exit();

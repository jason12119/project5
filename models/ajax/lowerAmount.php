<?php
session_start();
require '../classes/class.db_local.php';
$db = new db_connect();

//  Decrease mnozstvi in db, then update it via javascript
$sql = "SELECT mnozstvi FROM project5_kosiky WHERE id = '" . $_POST['ID'] . "'";
$result = $db->db()->query($sql);
$result = mysqli_fetch_object($result);
if ($result->mnozstvi > 1) {
    $sql =
        'UPDATE project5_kosiky SET mnozstvi = mnozstvi - 1 WHERE id = ' .
        $_POST['ID'];
    $db->db()->query($sql);
    $ajaxData['action'] = 'lowerAmount';
} else {
    // delete the whole row

    $sql = 'DELETE FROM project5_kosiky WHERE id = ' . $_POST['ID'];
    $ajaxData['sql'] = $sql;
    $db->db()->query($sql);
    $ajaxData['action'] = 'deleteProduct';
}

$ajaxData['kosik_id'] = $_POST['ID'];

echo json_encode($ajaxData);
exit();

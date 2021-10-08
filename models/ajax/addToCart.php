<?php
session_start();
require '../classes/class.db_local.php';
$db = new db_connect();

//  If cart does not exist, create new cart id, test if it is unique and then add products under this cart id

if (!isset($_SESSION['cartID'])) {
    $cartID = uniqid('', true);
    $sql =
        'SELECT * FROM ' . $db->prefix . 'kosiky WHERE kosik_ID = ' . $cartID;
    $result = $db->db()->query($sql);
    $result = mysqli_fetch_row($result);
    if ($result == null) {
        $_SESSION['cartID'] = $cartID;
    }
}

//  Test if there is a record of this specific product under this specific cart id,

$sql =
    'SELECT * FROM ' .
    $db->prefix .
    "kosiky WHERE kosik_id = '" .
    $_SESSION['cartID'] .
    "' AND produkt_id = '" .
    $_POST['productID'] .
    "'";

$result = $db->db()->query($sql);
$result = mysqli_fetch_row($result);
if ($result[0] == null) {
    //  Add product into database under specific cart id, and retrieve the products data to be added to header-cart-detail
    $sql =
        'INSERT INTO ' .
        $db->prefix .
        "kosiky (kosik_id, produkt_id) VALUES ('" .
        $_SESSION['cartID'] .
        "', '" .
        $_POST['productID'] .
        "')";

    $db->db()->query($sql);

    $sql =
        'SELECT project5_kosiky.id AS kosik_id, project5_produkty.id, project5_produkty.nazev, project5_produkty.cena,  project5_kosiky.mnozstvi, project5_produkty.img FROM ' .
        $db->prefix .
        "produkty INNER JOIN project5_kosiky ON project5_produkty.id = project5_kosiky.produkt_id WHERE project5_kosiky.kosik_id = '" .
        $_SESSION['cartID'] .
        "' AND project5_kosiky.produkt_id = '" .
        $_POST['productID'] .
        "'";

    $result = $db->db()->query($sql);
    $data = mysqli_fetch_object($result);

    $ajaxData['data'] = $data;
    $ajaxData['action'] = 'newProduct';
} else {
    // just update mnozstvi
    $sql =
        'UPDATE ' .
        $db->prefix .
        'kosiky SET mnozstvi = mnozstvi + 1 WHERE id = ' .
        $result[0];

    $db->db()->query($sql);

    $ajaxData['cartID'] = $result[0];
    $ajaxData['action'] = 'addAmount';

    $sql =
        'SELECT cena FROM project5_produkty WHERE id = ' . $_POST['productID'];
    $result = $db->db()->query($sql);
    $result = mysqli_fetch_object($result);
    $ajaxData['price'] = $result->cena;
}

if (isset($ajaxData)) {
    echo json_encode($ajaxData);
}
exit();

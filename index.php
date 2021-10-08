<?php
session_start();
include 'models/classes/class.db_local.php';
$db = new db_connect();

//  Get products from database
$sql = 'SELECT * FROM ' . $db->prefix . 'produkty';
$result = $db->db()->query($sql);
while ($row = mysqli_fetch_object($result)) {
    $products[] = [
        'id' => $row->id,
        'nazev' => $row->nazev,
        'perex' => $row->perex,
        'cena' => $row->cena,
        'img' => $row->img,
    ];
}

//  Get all products which the user has put into his cart

if (isset($_SESSION['cartID'])) {
    $sql =
        'SELECT project5_kosiky.id AS kosik_id, project5_produkty.id, project5_produkty.nazev, project5_produkty.cena, project5_produkty.img, project5_kosiky.mnozstvi FROM ' .
        $db->prefix .
        "produkty INNER JOIN project5_kosiky ON project5_produkty.id = project5_kosiky.produkt_id WHERE project5_kosiky.kosik_id = '" .
        $_SESSION['cartID'] .
        "'";
    $result = $db->db()->query($sql);

    while ($row = mysqli_fetch_object($result)) {
        $cartData[] = [
            'cartID' => $row->kosik_id,
            'id' => $row->id,
            'nazev' => $row->nazev,
            'cena' => $row->cena,
            'img' => $row->img,
            'mnozstvi' => $row->mnozstvi,
        ];
    }

    //  Calculate price and number of items and add it to header-cart
    $totalPrice = 0;
    foreach ($cartData as $cartProduct) {
        $totalPrice += $cartProduct['cena'] * $cartProduct['mnozstvi'];
    }
    $numberOfProducts = sizeof($cartData);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Project 5 - Eshop Core (Cart)</title>
    <meta name="description" content="Eshop core - Cart" />
    <link rel="stylesheet" href="dist/css/frameworks.css" />
    <link rel="stylesheet" href="css/app.bundle.css" />
    <script src="dist/js/frameworks-min.js"></script>
  </head>

  <body>
    <div id="header" class="container-fluid">
      <div class="container">
        <div id="header-logo">Shop Logo</div>
        <div id="header-search">
          <input type="text" />
          <button class="btn btn-primary">Search</button>
        </div>
        <nav id="header-nav">
          <a href="">About</a>
          <a href="">Products</a>
          <a href="">Contact</a>
        </nav>
        <div class="" id="header-contact">
          <span>Volejte na</span>
          <span>733 733 733</span>
        </div>
        <div id="header-cart">
          <i class="fa fa-shopping-cart"><div class="circle"><?= $numberOfProducts ?></div></i>
          <div class="total">
            <span><?= $totalPrice ?></span>
            ,-
          </div>
        </div>
        <div id="header-cart-detail">
          <?php foreach ($cartData as $cartProduct) { ?>
          <div id="<?= $cartProduct['cartID'] ?>" class="product">
            <img src="img/produkty/<?= $cartProduct['img'] ?>" alt="" />
            <div class="product-name"><?= $cartProduct['nazev'] ?></div>
            <div class="amount">
              <i data-cart="<?= $cartProduct[
                  'cartID'
              ] ?>" class="fa fa-minus"></i>
              <span><?= $cartProduct['mnozstvi'] ?></span>
              <i data-cart="<?= $cartProduct[
                  'cartID'
              ] ?>" class="fa fa-plus"></i>
            </div>
            <div class="price">
              <span><?= $cartProduct['cena'] *
                  $cartProduct['mnozstvi'] ?></span>
              ,-
            </div>
            <i data-cart="<?= $cartProduct[
                'cartID'
            ] ?>" class="fa fa-times"></i>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="container">
        <div class="products">
          <?php foreach ($products as $product) { ?>
          <div class="product">
            <img src="img/produkty/<?= $product['img'] ?>" alt="product pic" />
            <h3 class="product-name"><?= $product['nazev'] ?></h3>
            <div class="product-perex">
              <?= $product['perex'] ?>
            </div>
            <div class="flex-wrap">
              <div class="product-price">
                <span><?= $product['cena'] ?></span>
                ,-
              </div>
              <div class="buy" data-cart="<?= $product['id'] ?>">
                <i class="fa fa-shopping-cart"></i>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <script src="js/shopping.js"></script>
  </body>
</html>

<?php
require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

try {
    $capsule->addConnection([
        "driver" => "mysql",
        "host" => __host__,
        "database" => __database__,
        "username" => __username__,
        "password" => __password__
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
} catch (\Exception $ex) {
    die("Error :" . $ex->getMessage());
}

$pageID = isset($_GET['page']) ? $_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

$query = $capsule->table("items");

if ($searchTerm) {
    $query->where('id', 'like', "%$searchTerm%")
          ->orWhere('product_name', 'like', "%$searchTerm%")
          ->orWhere('PRODUCT_code', 'like', "%$searchTerm%")
          ->orWhere('list_price', 'like', "%$searchTerm%");
}

$totalItems = $query->count();
$totalPages = ceil($totalItems / __items_per_page);

$items = $query->select()->skip(($pageID - 1) * __items_per_page)->take(__items_per_page)->get();

require_once("views/index.php");
?>

<?php
// Test database connection and data
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'qldienthoai',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Test connection
    $pdo = Capsule::connection()->getPdo();
    echo "✅ Database connection successful!\n";
    
    // Test loai_san_pham table
    $categories = Capsule::table('loai_san_pham')->get();
    echo "✅ Found " . count($categories) . " categories:\n";
    foreach ($categories as $category) {
        echo "- " . $category->name . "\n";
    }
    
    // Test san_pham table
    $products = Capsule::table('san_pham')->get();
    echo "✅ Found " . count($products) . " products:\n";
    foreach ($products as $product) {
        echo "- " . $product->name . " (Brand: " . $product->thuong_hieu . ")\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

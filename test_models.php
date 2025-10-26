<?php
// Simple test to check if Laravel can load data
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\LoaiSanPham;
use App\Models\SanPham;

echo "=== TESTING LARAVEL MODELS ===\n\n";

try {
    // Test LoaiSanPham
    echo "1. Testing LoaiSanPham model:\n";
    $categories = LoaiSanPham::all();
    echo "Found " . $categories->count() . " categories:\n";
    foreach ($categories as $category) {
        echo "- ID: {$category->id}, Name: {$category->name}\n";
    }
    
    echo "\n2. Testing SanPham model:\n";
    $products = SanPham::all();
    echo "Found " . $products->count() . " products:\n";
    foreach ($products as $product) {
        echo "- ID: {$product->id}, Name: {$product->name}, Brand: {$product->thuong_hieu}\n";
    }
    
    echo "\n3. Testing relationship:\n";
    $category = LoaiSanPham::first();
    if ($category) {
        echo "First category: {$category->name}\n";
        $categoryProducts = $category->sanPhams;
        echo "Products in this category: " . $categoryProducts->count() . "\n";
        foreach ($categoryProducts as $product) {
            echo "- {$product->name} (Brand: {$product->thuong_hieu})\n";
        }
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

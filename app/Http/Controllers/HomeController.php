<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = SanPham::with('images')->get();
        $categories = LoaiSanPham::with('sanPhams')->get();
        
        return view('home.index', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        $products = SanPham::where('name', 'like', '%' . $query . '%')
            ->orWhere('mo_ta', 'like', '%' . $query . '%')
            ->orWhere('gioi_thieu', 'like', '%' . $query . '%')
            ->with('images')
            ->get();
            
        $categories = LoaiSanPham::with('sanPhams')->get();
            
        return view('home.search', compact('products', 'query', 'categories'));
    }

    public function productsByBrand(Request $request)
    {
        $brand = $request->get('brand');
        $categoryId = $request->get('category');
        
        $products = SanPham::where('thuong_hieu', $brand)
            ->where('loai_san_pham_id', $categoryId)
            ->with('images')
            ->get();
            
        $categoryName = LoaiSanPham::find($categoryId)->name ?? '';
        $categories = LoaiSanPham::with('sanPhams')->get();
        
        return view('home.products-by-brand', compact('products', 'brand', 'categoryName', 'categories'));
    }

    public function productsByCategory($categoryId)
    {
        $products = SanPham::where('loai_san_pham_id', $categoryId)
            ->with('images')
            ->get();
            
        $category = LoaiSanPham::find($categoryId);
        $categories = LoaiSanPham::with('sanPhams')->get();
        
        return view('home.index', compact('products', 'category', 'categories'));
    }

    public function show($id)
    {
        $product = SanPham::with('images', 'loaiSanPham')->findOrFail($id);
        $categories = LoaiSanPham::with('sanPhams')->get();
        
        return view('home.product-detail', compact('product', 'categories'));
    }
}

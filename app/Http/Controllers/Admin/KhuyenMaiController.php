<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class KhuyenMaiController extends Controller
{
    public function index(Request $request)
    {
        $query = KhuyenMai::query();

        if ($request->has('search') && $request->search) {
            $s = $request->search;
            $query->where('name', 'like', "%{$s}%");
        }

        $dateCol = Schema::hasColumn('khuyen_mai', 'created_at') ? 'created_at' : 'id';
        $promotions = $query->orderByDesc($dateCol)->paginate(15);

        return view('admin.promotions.index', compact('promotions'));
    }
}


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhuyenMaiController
{
    //
}

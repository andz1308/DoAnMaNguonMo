<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use App\Models\SanPham;
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


    public function create()
    {
        $sanPhams = SanPham::all();
        return view('admin.promotions.create', compact('sanPhams'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:khuyen_mai',
            'gia' => 'required|numeric|min:0|max:100',
            'san_phams' => 'nullable|array',
            'san_phams.*' => 'integer|exists:san_pham,id',
            'ngay_bd' => 'nullable|date',
            'ngay_kt' => 'nullable|date|after_or_equal:ngay_bd',
        ], [
            'name.required' => 'Vui lòng nhập tên khuyến mãi',
            'name.unique' => 'Tên khuyến mãi đã tồn tại',
            'gia.required' => 'Vui lòng nhập giá trị khuyến mãi',
            'gia.numeric' => 'Giá trị phải là số',
            'gia.min' => 'Giá trị không được âm',
            'gia.max' => 'Giá trị không được vượt quá 100%',
            'ngay_kt.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        $promotion = KhuyenMai::create([
            'name' => $validated['name'],
            'gia' => $validated['gia'],
        ]);

        if (!empty($validated['san_phams'])) {
            foreach ($validated['san_phams'] as $sanPhamId) {
                ChiTietKhuyenMai::create([
                    'khuyen_mai_id' => $promotion->id,
                    'san_pham_id' => $sanPhamId,
                    'ngay_bd' => $validated['ngay_bd'] ?? now(),
                    'ngay_kt' => $validated['ngay_kt'] ?? now()->addDays(30),
                ]);
            }
        }

        return redirect()->route('admin.khuyen_mai.index')
            ->with('success', 'Tạo khuyến mãi thành công');
    }


    public function show($id)
    {
        $promotion = KhuyenMai::with('chiTietKhuyenMais')->findOrFail($id);
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = KhuyenMai::findOrFail($id);
        $sanPhams = SanPham::all();
        $selectedSanPhams = $promotion->chiTietKhuyenMais->pluck('san_pham_id')->toArray();
        
        return view('admin.promotions.edit', compact('promotion', 'sanPhams', 'selectedSanPhams'));
    }

    public function update(Request $request, $id)
    {
        $promotion = KhuyenMai::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:khuyen_mai,name,' . $id,
            'gia' => 'required|numeric|min:0|max:100',
            'san_phams' => 'nullable|array',
            'san_phams.*' => 'integer|exists:san_pham,id',
            'ngay_bd' => 'nullable|date',
            'ngay_kt' => 'nullable|date|after_or_equal:ngay_bd',
        ], [
            'name.required' => 'Vui lòng nhập tên khuyến mãi',
            'name.unique' => 'Tên khuyến mãi đã tồn tại',
            'gia.required' => 'Vui lòng nhập giá trị khuyến mãi',
            'gia.numeric' => 'Giá trị phải là số',
            'gia.min' => 'Giá trị không được âm',
            'gia.max' => 'Giá trị không được vượt quá 100%',
            'ngay_kt.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        $promotion->update([
            'name' => $validated['name'],
            'gia' => $validated['gia'],
        ]);

        $promotion->chiTietKhuyenMais()->delete();

        if (!empty($validated['san_phams'])) {
            foreach ($validated['san_phams'] as $sanPhamId) {
                ChiTietKhuyenMai::create([
                    'khuyen_mai_id' => $promotion->id,
                    'san_pham_id' => $sanPhamId,
                    'ngay_bd' => $validated['ngay_bd'] ?? now(),
                    'ngay_kt' => $validated['ngay_kt'] ?? now()->addDays(30),
                ]);
            }
        }

        return redirect()->route('admin.khuyen_mai.index')
            ->with('success', 'Cập nhật khuyến mãi thành công');
    }


    public function destroy($id)
    {
        $isUsed = \App\Models\ChiTietKhuyenMai::where('khuyen_mai_id', $id)->exists();

        if ($isUsed) {
            return redirect()->route('admin.khuyen_mai.index')
                ->with('error', 'Không thể xóa!');
        }

        $promotion = KhuyenMai::findOrFail($id);
        
        $promotion->chiTietKhuyenMais()->delete();
        
        $promotion->delete();

        return redirect()->route('admin.khuyen_mai.index')
            ->with('success', 'Xóa khuyến mãi thành công');
    }
}

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
    /**
     * Hiển thị danh sách khuyến mãi
     */
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

    /**
     * Hiển thị form tạo khuyến mãi mới
     */
    public function create()
    {
        $sanPhams = SanPham::all();
        return view('admin.promotions.create', compact('sanPhams'));
    }

    /**
     * Lưu khuyến mãi mới vào database
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
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

        // Tạo khuyến mãi mới
        $promotion = KhuyenMai::create([
            'name' => $validated['name'],
            'gia' => $validated['gia'],
        ]);

        // Thêm chi tiết khuyến mãi (nếu có sản phẩm được chọn)
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

    /**
     * Hiển thị chi tiết khuyến mãi
     */
    public function show($id)
    {
        $promotion = KhuyenMai::with('chiTietKhuyenMais')->findOrFail($id);
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Hiển thị form chỉnh sửa khuyến mãi
     */
    public function edit($id)
    {
        $promotion = KhuyenMai::findOrFail($id);
        $sanPhams = SanPham::all();
        $selectedSanPhams = $promotion->chiTietKhuyenMais->pluck('san_pham_id')->toArray();
        
        return view('admin.promotions.edit', compact('promotion', 'sanPhams', 'selectedSanPhams'));
    }

    /**
     * Cập nhật khuyến mãi
     */
    public function update(Request $request, $id)
    {
        $promotion = KhuyenMai::findOrFail($id);

        // Validate dữ liệu
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

        // Cập nhật khuyến mãi
        $promotion->update([
            'name' => $validated['name'],
            'gia' => $validated['gia'],
        ]);

        // Xóa chi tiết khuyến mãi cũ
        $promotion->chiTietKhuyenMais()->delete();

        // Thêm chi tiết khuyến mãi mới
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

    /**
     * Xóa khuyến mãi
     */
    public function destroy($id)
    {
        $promotion = KhuyenMai::findOrFail($id);
        
        // Xóa chi tiết khuyến mãi
        $promotion->chiTietKhuyenMais()->delete();
        
        // Xóa khuyến mãi
        $promotion->delete();

        return redirect()->route('admin.khuyen_mai.index')
            ->with('success', 'Xóa khuyến mãi thành công');
    }
}

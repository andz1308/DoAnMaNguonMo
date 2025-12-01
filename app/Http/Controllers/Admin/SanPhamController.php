<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\Image;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SanPhamController
{

    public function index()
    {
        $data = SanPham::with('loaiSanPham')
            ->orderBy('id', 'desc')
            ->paginate(5); 

        return view('admin.san_pham.index', compact('data'));
    }


    public function create()
    {
        $loaiSanPhams = LoaiSanPham::all();
        return view('admin.san_pham.create', compact('loaiSanPhams'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'gioi_thieu' => 'nullable|string',
            'mo_ta' => 'nullable|string',
            'thuong_hieu' => 'nullable|string|max:100',
            'man_hinh' => 'nullable|string|max:100',
            'do_phan_giai' => 'nullable|string|max:100',
            'camera' => 'nullable|string|max:100',
            'cpu' => 'nullable|string|max:100',
            'pin' => 'nullable|string|max:100',
            'ngay_phat_hanh' => 'nullable|date',
            'dung_luong' => 'nullable|string|max:100',
            'kich_thuoc' => 'nullable|string|max:100',
            'trong_luong' => 'nullable|string|max:100',
            'so_luong_con' => 'required|integer|min:0',
            'loai_san_pham_id' => 'required|exists:loai_san_pham,id',
            'HinhAnh' => 'nullable|array', 
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageData = $validatedData['HinhAnh'] ?? null;
        unset($validatedData['HinhAnh']);
        $sanPham = SanPham::create($validatedData);

        if ($imageData && $sanPham) {
            foreach ($imageData as $file) {
                $filename = time() . '_' . $file->getClientOriginalname();
                $destinationPath = public_path('uploads/images/san_pham');
                $file->move($destinationPath, $filename);


                Image::create(['name' => $filename, 'san_pham_id' => $sanPham->id]);
            }
        }

        return redirect()->route('admin.san_pham.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(SanPham $sanPham)
    {
        $sanPham->load('images');
        $loaiSanPhams = LoaiSanPham::all();
        return view('admin.san_pham.edit', compact('sanPham', 'loaiSanPhams'));
    }

    public function update(Request $request, SanPham $sanPham)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'gioi_thieu' => 'nullable|string',
            'mo_ta' => 'nullable|string',
            'thuong_hieu' => 'nullable|string|max:100',
            'man_hinh' => 'nullable|string|max:100',
            'do_phan_giai' => 'nullable|string|max:100',
            'camera' => 'nullable|string|max:100',
            'cpu' => 'nullable|string|max:100',
            'pin' => 'nullable|string|max:100',
            'ngay_phat_hanh' => 'nullable|date',
            'dung_luong' => 'nullable|string|max:100',
            'kich_thuoc' => 'nullable|string|max:100',
            'trong_luong' => 'nullable|string|max:100',
            'so_luong_con' => 'required|integer|min:0',
            'loai_san_pham_id' => 'required|exists:loai_san_pham,id',
            'HinhAnh' => 'nullable|array', 
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array', 
            'delete_images.*' => 'integer|exists:images,id' 
        ]);

        if ($request->has('delete_images')) {
            $imagesToDeleteIds = $request->input('delete_images');

            $imagesToDelete = Image::whereIn('id', $imagesToDeleteIds)
                ->where('san_pham_id', $sanPham->id) 
                ->get();

            foreach ($imagesToDelete as $image) {
                if ($image->name && File::exists(public_path('uploads/images/san_pham/' . $image->name))) {
                    File::delete(public_path('uploads/images/san_pham/' . $image->name));
                }
                $image->delete();
            }
        }

        $newImageData = $validatedData['HinhAnh'] ?? null;
        if ($newImageData) {
            foreach ($newImageData as $file) {
                $filename = time() . '_' . $file->getClientOriginalname();
                $destinationPath = public_path('uploads/images/san_pham');
                $file->move($destinationPath, $filename);

                $sanPham->images()->create(['name' => $filename]);
            }
        }

        unset($validatedData['HinhAnh']);
        unset($validatedData['delete_images']);
        $sanPham->update($validatedData);

        return redirect()->route('admin.san_pham.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }


    public function destroy(SanPham $sanPham) 
    {
        try {
            $existsInOrders = \App\Models\ChiTietDonHang::where('san_pham_id', $sanPham->id)->exists();

            if ($existsInOrders) {
                $sanPham->update(['so_luong_con' => 0]);

                return redirect()->route('admin.san_pham.index')
                    ->with('error', 'Sản phẩm này đã có đơn hàng, không thể xóa! Đã chuyển về hết hàng.');
            }
            foreach ($sanPham->images as $image) {
                if ($image->Name && File::exists(public_path('uploads/images/san_pham/' . $image->name))) {
                    File::delete(public_path('uploads/images/san_pham/' . $image->Name));
                }
                $image->delete();
            }
            $sanPham->delete();

            return redirect()->route('admin.san_pham.index')
                ->with('success', 'Xóa sản phẩm thành công!');

        } catch (\Exception $e) {
            return redirect()->route('admin.san_pham.index')
                ->with('error', 'Lỗi khi xóa sản phẩm: ' . $e->getMessage());
        }
    }


    public function show(SanPham $sanPham)
    {
        //
    }
}

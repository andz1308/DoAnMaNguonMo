<?php

<<<<<<< HEAD
namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
=======
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\Image;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SanPhamController
>>>>>>> origin/longvu
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
        $data = SanPham::orderBy('id', 'asc')->paginate(5);
        return view('admin.san_pham.index', compact('data'));
    }

=======
        $data = SanPham::with('loaiSanPham')
            ->orderBy('id', 'desc')
            ->paginate(5); // Lấy 5 sản phẩm mỗi trang

        // Trả về view và truyền biến $data chứa danh sách sản phẩm đã có thông tin loại
        return view('admin.san_pham.index', compact('data'));
    }


>>>>>>> origin/longvu
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
<<<<<<< HEAD
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

=======
        // Lấy tất cả loại sản phẩm để hiển thị trong dropdown
        $loaiSanPhams = LoaiSanPham::all();
        // Trả về view 'create' và truyền danh sách loại sản phẩm sang
        return view('admin.san_pham.create', compact('loaiSanPhams'));
    }

    public function store(Request $request)
    {
        // 1. Validate dữ liệu từ form (dùng snake_case)
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
            'HinhAnh' => 'nullable|array', // Cho phép HinhAnh là mảng hoặc null
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate từng file trong mảng
        ]);

        // Tạo sản phẩm trước (loại bỏ HinhAnh khỏi validatedData)
        $imageData = $validatedData['HinhAnh'] ?? null;
        unset($validatedData['HinhAnh']);
        $sanPham = SanPham::create($validatedData);

        // Xử lý upload và lưu nhiều ảnh nếu có
        if ($imageData && $sanPham) {
            foreach ($imageData as $file) {
                $filename = time() . '_' . $file->getClientOriginalname();
                $destinationPath = public_path('uploads/images/san_pham');
                $file->move($destinationPath, $filename);


                // Lưu vào bảng images
                //$sanPham->images()->create(['name' => $imagePath]);
                Image::create(['name' => $filename, 'san_pham_id' => $sanPham->id]);
            }
        }

        return redirect()->route('admin.san_pham.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(SanPham $sanPham)
    {
        // Eager load ảnh để hiển thị trong view edit
        $sanPham->load('images');
        $loaiSanPhams = LoaiSanPham::all();
        return view('admin.san_pham.edit', compact('sanPham', 'loaiSanPhams'));
    }

    public function update(Request $request, SanPham $sanPham)
    {
        // 1. Validate dữ liệu (dùng PascalCase cho các key, trừ khóa ngoại và mảng ảnh)
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
            'HinhAnh' => 'nullable|array', // Mảng ảnh mới
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array', // Mảng ID ảnh cần xóa
            'delete_images.*' => 'integer|exists:images,id' // Đảm bảo ID tồn tại trong bảng images
        ]);

        // 2. Xử lý xóa ảnh được chọn
        if ($request->has('delete_images')) {
            $imagesToDeleteIds = $request->input('delete_images');

            // Lấy các bản ghi Image cần xóa (và đảm bảo chúng thuộc sản phẩm này)
            $imagesToDelete = Image::whereIn('id', $imagesToDeleteIds)
                ->where('san_pham_id', $sanPham->id) // Quan trọng: chỉ xóa ảnh của sản phẩm hiện tại
                ->get();

            foreach ($imagesToDelete as $image) {
                // Xóa file vật lý
                if ($image->name && File::exists(public_path('uploads/images/san_pham/' . $image->name))) {
                    File::delete(public_path('uploads/images/san_pham/' . $image->name));
                }
                // Xóa bản ghi trong CSDL
                $image->delete();
            }
        }

        // 3. Xử lý thêm ảnh mới (nếu có)
        $newImageData = $validatedData['HinhAnh'] ?? null;
        if ($newImageData) {
            foreach ($newImageData as $file) {
                $filename = time() . '_' . $file->getClientOriginalname();
                $destinationPath = public_path('uploads/images/san_pham');
                $file->move($destinationPath, $filename);

                // Tạo bản ghi mới trong bảng images, liên kết với sản phẩm này
                $sanPham->images()->create(['name' => $filename]);
            }
        }

        // 4. Cập nhật thông tin cơ bản của sản phẩm (loại bỏ dữ liệu ảnh khỏi mảng update)
        unset($validatedData['HinhAnh']);
        unset($validatedData['delete_images']);
        $sanPham->update($validatedData);

        // 5. Chuyển hướng
        return redirect()->route('admin.san_pham.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SanPham $sanPham) // Sử dụng Route Model Binding
    {
        try {
            // 1. Xóa các file ảnh vật lý liên quan
            // Lặp qua collection 'images' mà $sanPham có được nhờ quan hệ hasMany
            foreach ($sanPham->images as $image) {
                // Kiểm tra xem file có tồn tại trong thư mục public không
                if ($image->Name && File::exists(public_path('uploads/images/san_pham/' . $image->name))) {
                    // Xóa file ảnh
                    File::delete(public_path('uploads/images/san_pham/' . $image->Name));
                }
                // Không cần xóa bản ghi Image ở đây nếu khóa ngoại có onDelete('cascade')
                // Nếu không có cascade, bạn cần thêm: $image->delete();
            }

            // 2. Xóa bản ghi sản phẩm trong CSDL
            // Nếu khóa ngoại trong bảng 'images' có onDelete('cascade'),
            // việc xóa $sanPham sẽ tự động xóa các bản ghi Image liên quan.
            $sanPham->delete();

            // 3. Chuyển hướng về trang danh sách với thông báo thành công
            return redirect()->route('admin.san_pham.index')
                ->with('success', 'Xóa sản phẩm thành công!');

        } catch (\Exception $e) {
            // 4. Nếu có lỗi, chuyển hướng về trang danh sách với thông báo lỗi
            return redirect()->route('admin.san_pham.index')
                ->with('error', 'Lỗi khi xóa sản phẩm: ' . $e->getMessage());
        }
    }



>>>>>>> origin/longvu
    /**
     * Display the specified resource.
     */
    public function show(SanPham $sanPham)
    {
        //
    }
<<<<<<< HEAD

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SanPham $sanPham)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SanPham $sanPham)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SanPham $sanPham)
    {
        //
    }
=======
>>>>>>> origin/longvu
}

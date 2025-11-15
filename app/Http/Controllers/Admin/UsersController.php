<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

                if (Schema::hasColumn('users', 'dien_thoai')) {
                    $q->orWhere('dien_thoai', 'like', "%{$search}%");
                }
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role_id', $request->role);
        }

        // Filter by status
        if (
            $request->has('status') &&
            $request->status !== '' &&
            Schema::hasColumn('users', 'trang_thai')
        ) {
            $query->where('trang_thai', $request->status);
        }

    $userDateCol = Schema::hasColumn('users', 'created_at') ? 'created_at' : 'id';
        $users = $query->orderByDesc($userDateCol)->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $roleTable = (new Role())->getTable();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dien_thoai' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role_id' => ['required', Rule::exists($roleTable, 'id')],
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'nullable|string|max:10',
            'trang_thai' => 'nullable|boolean',
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dien_thoai' => $validated['dien_thoai'] ?? null,
            'password' => bcrypt($validated['password']),
            'role_id' => $validated['role_id'],
            'dia_chi' => $validated['dia_chi'] ?? null,
            'gioi_tinh' => $validated['gioi_tinh'] ?? null,
            'trang_thai' => $validated['trang_thai'] ?? 1,
        ];

        if (!Schema::hasColumn('users', 'trang_thai')) {
            unset($payload['trang_thai']);
        }

        User::create($payload);

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $roleTable = (new Role())->getTable();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'dien_thoai' => 'nullable|string|max:20',
            'role_id' => ['required', Rule::exists($roleTable, 'id')],
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'nullable|string|max:10',
            'trang_thai' => 'nullable|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dien_thoai' => $validated['dien_thoai'] ?? null,
            'role_id' => $validated['role_id'],
            'dia_chi' => $validated['dia_chi'] ?? null,
            'gioi_tinh' => $validated['gioi_tinh'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = bcrypt($validated['password']);
        }

        if (Schema::hasColumn('users', 'trang_thai')) {
            $payload['trang_thai'] = $validated['trang_thai'] ?? $user->trang_thai;
        }

        $user->update($payload);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function toggleStatus(Request $request, $id)
    {
        if (!Schema::hasColumn('users', 'trang_thai')) {
            return response()->json(['success' => false, 'message' => 'Trường trạng thái chưa được cấu hình'], 422);
        }

        $user = User::findOrFail($id);
        $user->update(['trang_thai' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role_id', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('trang_thai', $request->status);
        }

    $userDateCol = Schema::hasColumn('users', 'created_at') ? 'created_at' : 'id';
    $users = $query->orderByDesc($userDateCol)->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'dia_chi' => 'nullable|string'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['trang_thai'] = 1;

        User::create($validated);

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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'dia_chi' => 'nullable|string'
        ]);

        if ($request->has('password') && $request->password) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['trang_thai' => $request->status]);

        return response()->json(['success' => true]);
    }
}

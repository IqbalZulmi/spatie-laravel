<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assignIndex(){
        $user = User::all();
        $roles = Role::all();

        $action = ['create', 'read', 'update', 'delete'];

        // Ambil semua permission dan kelompokkan berdasarkan nama modul (prefix sebelum titik)
        // $permissions: Collection (Grouped) -> Semua permissions, dikelompokkan berdasarkan modul (prefix)
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0]; // contoh: 'user.create' → 'user'
        });

        // Ambil nama-nama modul dari key hasil groupBy
        // $nama_permission: Collection -> List nama modul
        $nama_permission = $permissions->keys();

        // dd($permissions);

        return view('user-assign',[
            'users' => $user,
            'roles' => $roles,
            'nama_permissions' => $nama_permission,
            'actions' => $action,
        ]);
    }

    public function assignPermission(Request $request, $id_user) {
        $validate = $request->validate([
            'permissions' => 'array',
        ]);

        try {
            // Mencari user berdasarkan ID
            $user = User::findOrFail($id_user);

            // Menyinkronkan permissions dengan user
            $user->syncPermissions($request->permissions);

            return redirect()->back()->with([
                'notifikasi' => 'Permission berhasil ditambahkan ke user',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {  // Menangkap exception
            // Menangani error jika terjadi
            return redirect()->back()->with([
                'notifikasi' => 'Permission gagal ditambahkan ke user: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function assignRoles(Request $request, $id_user) {
        $validate = $request->validate([
            'roles' => 'array',
        ]);

        try {
            // Mencari user berdasarkan ID
            $user = User::findOrFail($id_user);

            // Menyinkronkan role dengan user
            $user->syncRoles($request->roles);

            return redirect()->back()->with([
                'notifikasi' => 'Role berhasil ditambahkan ke user',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {  // Menangkap exception
            // Menangani error jika terjadi
            return redirect()->back()->with([
                'notifikasi' => 'Role gagal ditambahkan ke user: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

}

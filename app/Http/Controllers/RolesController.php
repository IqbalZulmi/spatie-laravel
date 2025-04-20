<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data role beserta relasi users dan permissions
        // $roles: Collection -> Semua role beserta relasi users dan permissions
        $roles = Role::with(['users', 'permissions'])->get()->sortByDesc('created_at');

        // Aksi tetap yang tersedia untuk setiap modul
        // $actions: Array -> Aksi tetap (create, read, update, delete)
        $action = ['create', 'read', 'update', 'delete'];

        // Ambil semua permission dan kelompokkan berdasarkan nama modul (prefix sebelum titik)
        // $permissions: Collection (Grouped) -> Semua permissions, dikelompokkan berdasarkan modul (prefix)
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0]; // contoh: 'user.create' → 'user'
        });

        // Ambil nama-nama modul dari key hasil groupBy
        // $nama_permission: Collection -> List nama modul
        $nama_permission = $permissions->keys();



        // Kirim data ke view
        return view('roles', [
            'roles' => $roles,
            'permissions' => $permissions,
            'nama_permissions' => $nama_permission,
            'actions' => $action,
        ]);
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
        $validate = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create([
            'name' => strtolower($request->name)
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        if($role){
            return redirect()->back()->with([
                'notifikasi' => 'Role '. $request->name .' berhasil ditambahkan',
                'type' => 'success'
            ]);
        }else{
            return redirect()->back()->with([
                'notifikasi' => 'Role '. $request->name .' gagal ditambahkan',
                'type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $roles)
    {
        $validate = $request->validate([
            'name' => 'required|unique:roles,name,' . $roles,
            'permissions' => 'array',
        ]);

        $role = Role::findOrFail($roles);
        $role->name = strtolower($request->name);

        $role->syncPermissions($request->permissions);

        $role->save();


        if($role->save()){
            return redirect()->back()->with([
                'notifikasi' => 'Berhasil mengubah data',
                'type' => 'success'
            ]);
        }else{
            return redirect()->back()->with([
                'notifikasi' => 'gagal mengubah data',
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roles)
    {
        $role = Role::findOrFail($roles);

        if ($role->count() < 1) {
            return redirect()->back()->with([
                'notifikasi' =>'Data tidak ditemukan!',
                'type'=>'error'
            ]);
        }
        if ($role->delete()) {
            return redirect()->back()->with([
                'notifikasi'=>"Berhasil menghapus data!",
                "type"=>"success"
            ]);
        }else{
            return redirect()->back()->with([
                'notifikasi'=>"Gagal menghapus data!",
                "type"=>"error",
            ]);
        }
    }
}

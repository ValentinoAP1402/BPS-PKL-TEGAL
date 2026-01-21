<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Admin;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function manageUsers()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users */
        $users = User::with('userRole')->get();
        $admins = Admin::all();

        // Gabungkan users dan admins dalam satu collection dengan sort order
        $allUsers = collect();

        foreach ($admins as $admin) {
            // Determine sort order: super_admin = 1, admin pending = 2, admin approved or others = 3
            $sortOrder = 3; 
            if ($admin->role === 'super_admin') {
                $sortOrder = 1;
            } elseif ($admin->status === 'pending') {
                $sortOrder = 2;
            }

            $allUsers->push([
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role,
                'status' => $admin->status,
                'type' => 'admin',
                'sort_order' => $sortOrder,
                'model' => $admin,
            ]);
        }

        foreach ($users as $user) {
            $allUsers->push([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Sekarang IDE akan mengenali ini
                'status' => 'approved',
                'type' => 'user',
                'sort_order' => 4,
                'model' => $user,
            ]);
        }

        // Urutkan collection berdasarkan sort_order dan name sebagai second sort untuk konsistensi
        $allUsers = $allUsers->sortBy(function ($item) {
            return [$item['sort_order'], $item['name']];
        })->values();

        return view('admin.user_roles.index', compact('allUsers'));
    }

    public function updateUserRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($userId);

        // Update or create user role
        UserRole::updateOrCreate(
            ['user_id' => $user->id],
            ['role' => $request->role]
        );

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }

    public function updateAdminRole(Request $request, $adminId)
    {
        $request->validate([
            'role' => 'required|in:admin,super_admin',
        ]);

        $admin = Admin::findOrFail($adminId);
        $admin->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Role admin berhasil diperbarui.');
    }

    public function approveAdmin(Request $request, $adminId)
    {
        $admin = Admin::findOrFail($adminId);

        if ($admin->isApproved()) {
            return redirect()->back()->with('error', 'Admin sudah disetujui.');
        }

        $admin->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Admin berhasil disetujui.');
    }

    public function rejectAdmin(Request $request, $adminId)
    {
        $admin = Admin::findOrFail($adminId);

        if ($admin->isApproved()) {
            return redirect()->back()->with('error', 'Tidak dapat menolak admin yang sudah disetujui.');
        }

        $admin->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Admin berhasil ditolak.');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function deleteAdmin($adminId)
    {
        $admin = Admin::findOrFail($adminId);

        // Prevent deleting super admin
        if ($admin->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus super admin.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }
}

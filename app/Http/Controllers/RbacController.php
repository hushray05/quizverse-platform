<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\StaffMember;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;

class RbacController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('staffMembers')->get();
        $staffMembers = StaffMember::with(['user', 'role'])->get();
        $availableUsers = User::whereDoesntHave('staffRecord')->get();

        return view('pages.admin.rbac.index', compact('roles', 'staffMembers', 'availableUsers'));
    }

    public function assignStaff(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'department' => ['required', 'string', 'max:100'],
        ]);

        $staff = StaffMember::create([
            'user_id' => $data['user_id'],
            'role_id' => $data['role_id'],
            'department' => $data['department'],
            'is_active' => true,
        ]);

        $user = User::find($data['user_id']);
        if ($user->role === 'player') {
            $user->update(['role' => 'creator']);
        }

        AuditService::log('staff_assigned', 'warning', 'StaffMember', $staff->id, [
            'user_id' => $data['user_id'],
            'role_id' => $data['role_id'],
        ]);

        return back()->with('success', "Staff assignment dispatched for {$user->name}.");
    }

    public function toggleStaffStatus(StaffMember $staff)
    {
        $staff->update(['is_active' => !$staff->is_active]);

        $status = $staff->is_active ? 'reactivated' : 'suspended';
        AuditService::log('staff_status_toggled', 'warning', 'StaffMember', $staff->id, ['status' => $status]);

        return back()->with('success', "Staff credential {$status}.");
    }
}

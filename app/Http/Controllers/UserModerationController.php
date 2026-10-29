<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'banned') {
                $query->where('is_banned', true);
            } elseif ($request->input('status') === 'active') {
                $query->where('is_banned', false);
            }
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('pages.admin.users.index', compact('users'));
    }

    public function toggleBan(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Self-sanctioning administrator accounts is prohibited.');
        }

        $user->update(['is_banned' => !$user->is_banned]);

        $status = $user->is_banned ? 'banned' : 'unbanned';
        AuditService::log('user_sanction_updated', $user->is_banned ? 'danger' : 'info', 'User', $user->id, [
            'target_user' => $user->email,
            'status' => $status,
        ]);

        return back()->with('success', "Account {$user->name} successfully {$status}.");
    }

    public function changeRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Cannot alter your own administrative role.');
        }

        $request->validate([
            'role' => ['required', 'in:player,creator,admin'],
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $request->input('role')]);

        AuditService::log('user_role_changed', 'warning', 'User', $user->id, [
            'target_user' => $user->email,
            'old_role' => $oldRole,
            'new_role' => $user->role,
        ]);

        return back()->with('success', "Role for {$user->name} transitioned to {$user->role}.");
    }
}

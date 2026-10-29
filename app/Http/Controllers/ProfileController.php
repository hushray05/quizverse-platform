<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $attempts = QuizAttempt::where('user_id', $user->id)
            ->with(['quiz.category'])
            ->latest('completed_at')
            ->paginate(8);

        return view('pages.player.profile', compact('user', 'attempts'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $data['avatar'] = $request->file('image')->store('uploads', 'public');
        } elseif ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('uploads', 'public');
        }

        $user->update($data);

        AuditService::log('profile_updated', 'info', 'User', $user->id);

        return redirect()->route('profile.show')
            ->with('success', 'Profile parameters updated successfully.');
    }
}

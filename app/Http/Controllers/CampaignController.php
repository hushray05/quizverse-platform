<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\AuditService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('pages.admin.campaigns.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:banner,sponsored,announcement,interstitial'],
            'status' => ['required', 'in:active,paused,scheduled,completed'],
            'badge_text' => ['nullable', 'string', 'max:50'],
            'cta_text' => ['required', 'string', 'max:50'],
            'target_url' => ['required', 'url'],
            'content' => ['nullable', 'string', 'max:500'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $campaign = Campaign::create($data);

        AuditService::log('campaign_created', 'info', 'Campaign', $campaign->id, ['title' => $campaign->title]);

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign '{$campaign->title}' published.");
    }

    public function toggleStatus(Campaign $campaign)
    {
        $newStatus = $campaign->status === 'active' ? 'paused' : 'active';
        $campaign->update(['status' => $newStatus]);

        AuditService::log('campaign_status_toggled', 'info', 'Campaign', $campaign->id, ['status' => $newStatus]);

        return back()->with('success', "Campaign transitioned to {$newStatus}.");
    }

    public function destroy(Campaign $campaign)
    {
        $title = $campaign->title;
        $campaign->delete();

        AuditService::log('campaign_deleted', 'warning', 'Campaign', $campaign->id, ['title' => $title]);

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign '{$title}' removed.");
    }
}

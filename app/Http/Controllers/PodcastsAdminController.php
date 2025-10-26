<?php

namespace App\Http\Controllers;

use App\Models\PodcastsCommentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class PodcastsAdminController extends Controller
{
    /**
     * Affiche les signalements des podcasts.
     *
     * @return \Illuminate\View\View
     */
    public function viewReports()
    {
        $user = Auth::user();
        if (!$user || !($user->role === 'superadmin' || ($user->role === 'admin' && $user->is_active && $user->affectation && in_array('podcast', is_array($user->affectation->modules) ? $user->affectation->modules : json_decode($user->affectation->modules, true))))) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $reports = PodcastsCommentReport::with(['user', 'comment.user', 'reply.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.podcasts_comments_reports', compact('reports'));
    }

    /**
     * Met à jour le statut d'un signalement.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateReport(Request $request, $id)
    {
        $report = PodcastsCommentReport::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,reviewed,dismissed',
        ]);
        $report->update(['status' => $request->status]);
        return redirect()->route('dashboard.podcasts.reports')->with('success', 'Statut du signalement mis à jour.');
    }
}
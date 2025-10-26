<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'IsSuperadmin']);
    }

    public function index(Request $request)
    {
        $query = UserLog::with('user')->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', $request->ip_address);
        }

        $logs = $query->paginate(50);

        // Statistiques pour le dashboard
        $stats = $this->getStats();

        return view('dashboard.logs.index', compact('logs', 'stats'));
    }

    public function show(UserLog $log)
    {
        $log->load('user');
        return view('dashboard.logs.show', compact('log'));
    }

    public function stats()
    {
        return response()->json($this->getStats());
    }

    private function getStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_logs' => UserLog::count(),
            'today_logs' => UserLog::whereDate('created_at', $today)->count(),
            'yesterday_logs' => UserLog::whereDate('created_at', $yesterday)->count(),
            'week_logs' => UserLog::where('created_at', '>=', $thisWeek)->count(),
            'month_logs' => UserLog::where('created_at', '>=', $thisMonth)->count(),
            
            // Actions les plus fréquentes
            'top_actions' => UserLog::select('action', DB::raw('count(*) as count'))
                ->groupBy('action')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            
            // Utilisateurs les plus actifs
            'top_users' => UserLog::select('user_id', DB::raw('count(*) as count'))
                ->whereNotNull('user_id')
                ->with('user:id,name,email')
                ->groupBy('user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            
            // Activité par jour (7 derniers jours)
            'daily_activity' => UserLog::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('count(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            
            // Activité par heure (aujourd'hui)
            'hourly_activity' => UserLog::select(
                    DB::raw('HOUR(created_at) as hour'),
                    DB::raw('count(*) as count')
                )
                ->whereDate('created_at', $today)
                ->groupBy('hour')
                ->orderBy('hour')
                ->get(),
        ];
    }

    public function export(Request $request)
    {
        $query = UserLog::with('user')->orderBy('created_at', 'desc');

        // Appliquer les mêmes filtres que pour l'index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->get();

        $filename = 'logs_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Utilisateur',
                'Email',
                'Action',
                'Description',
                'Route',
                'Méthode',
                'URL',
                'Adresse IP',
                'Code Status',
                'Date/Heure'
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user ? $log->user->name : 'Visiteur',
                    $log->user ? $log->user->email : 'N/A',
                    $log->action,
                    $log->description,
                    $log->route_name,
                    $log->method,
                    $log->url,
                    $log->ip_address,
                    $log->status_code,
                    $log->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function clean(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365'
        ]);

        $date = Carbon::now()->subDays($request->days);
        $deleted = UserLog::where('created_at', '<', $date)->delete();

        return response()->json([
            'success' => true,
            'message' => "Suppression réussie de {$deleted} entrées de log antérieures à {$request->days} jours."
        ]);
    }
}
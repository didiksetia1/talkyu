<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Aduan;
use App\Models\Aspirasi;
use App\Models\AspirasiEvent;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // Statistics
        $totalAgenda = Agenda::count();
        $totalAduan = Aduan::count();
        $totalUsers = User::count();
        $totalAspirasi = Aspirasi::count();

        // Recent data
        $recentAgendas = Agenda::withCount(['comments', 'likes'])
            ->latest()
            ->take(5)
            ->get();

        $recentAduans = Aduan::latest()
            ->take(5)
            ->get();

        $recentAspirasis = Aspirasi::with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();

        // Status distribution
        $aduanStatusDistribution = Aduan::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Category distribution for Agenda
        $agendaCategoryDistribution = Agenda::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // Active events
        $activeEvents = AspirasiEvent::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalAgenda',
            'totalAduan',
            'totalUsers',
            'totalAspirasi',
            'recentAgendas',
            'recentAduans',
            'recentAspirasis',
            'aduanStatusDistribution',
            'agendaCategoryDistribution',
            'activeEvents'
        ));
    }
}

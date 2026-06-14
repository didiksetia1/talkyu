<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Aduan;
use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $canViewAduan = Auth::user()?->role === 'admin';

        // Statistics
        $totalAgenda = Agenda::count();
        $totalUsers = User::count();
        $totalAspirasi = Aspirasi::count();
        $totalAduan = $canViewAduan ? Aduan::count() : 0;

        // Recent data
        $recentAgendas = Agenda::withCount(['comments', 'likes'])
            ->latest()
            ->take(5)
            ->get();

        $recentAduans = $canViewAduan
            ? Aduan::latest()->take(5)->get()
            : collect();

        $recentAspirasis = Aspirasi::with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();

        // Recent activity feed (combined from aduan, aspirasi, agenda)
        $recentActivity = collect();

        // Add recent agendas
        foreach ($recentAgendas as $agenda) {
            $recentActivity->push([
                'type' => 'agenda',
                'title' => $agenda->title,
                'meta' => $agenda->category,
                'date' => $agenda->created_at,
                'badge' => 'Agenda',
                'badge_class' => 'badge-dikirim',
            ]);
        }

        // Add recent aduans
        if ($canViewAduan) {
            foreach ($recentAduans as $aduan) {
                $recentActivity->push([
                    'type' => 'aduan',
                    'title' => $aduan->judul,
                    'meta' => $aduan->status ?? 'pending',
                    'date' => $aduan->created_at,
                    'badge' => ucfirst($aduan->status ?? 'pending'),
                    'badge_class' => 'badge-' . ($aduan->status ?? 'pending'),
                ]);
            }
        }

        // Add recent aspirasis
        foreach ($recentAspirasis as $aspirasi) {
            $recentActivity->push([
                'type' => 'aspirasi',
                'title' => $aspirasi->judul ?? 'Aspirasi',
                'meta' => $aspirasi->user?->name ?? 'Anonymous',
                'date' => $aspirasi->created_at,
                'badge' => 'Aspirasi',
                'badge_class' => 'badge-aspirasi',
            ]);
        }

        // Sort by date descending, take 5 for dashboard
        $recentActivity = $recentActivity->sortByDesc('date')->take(5)->values();

        return view('admin.dashboard', compact(
            'totalAgenda',
            'totalAduan',
            'totalUsers',
            'totalAspirasi',
            'recentAgendas',
            'recentAduans',
            'recentAspirasis',
            'recentActivity',
            'canViewAduan'
        ));
    }

    public function log(): View
    {
        $canViewAduan = Auth::user()?->role === 'admin';

        $allActivity = collect();

        // All agendas
        $agendas = Agenda::latest()->get();
        foreach ($agendas as $agenda) {
            $allActivity->push([
                'type' => 'agenda',
                'title' => $agenda->title,
                'meta' => $agenda->category,
                'date' => $agenda->created_at,
            ]);
        }

        // All aduans
        if ($canViewAduan) {
            $aduans = Aduan::latest()->get();
            foreach ($aduans as $aduan) {
                $allActivity->push([
                    'type' => 'aduan',
                    'title' => $aduan->judul,
                    'meta' => $aduan->status ?? 'pending',
                    'date' => $aduan->created_at,
                ]);
            }
        }

        // All aspirasis
        $aspirasis = Aspirasi::with('user')->latest()->get();
        foreach ($aspirasis as $aspirasi) {
            $allActivity->push([
                'type' => 'aspirasi',
                'title' => $aspirasi->judul ?? 'Aspirasi',
                'meta' => $aspirasi->user?->name ?? 'Anonymous',
                'date' => $aspirasi->created_at,
            ]);
        }

        // Sort desc and paginate manually
        $allActivity = $allActivity->sortByDesc('date')->values();
        $perPage = 20;
        $page = request()->get('page', 1);
        $total = $allActivity->count();
        $items = $allActivity->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.log', [
            'activities' => $paginator,
            'canViewAduan' => $canViewAduan,
        ]);
    }
}

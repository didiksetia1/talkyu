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

        // Sort by date descending, take 15
        $recentActivity = $recentActivity->sortByDesc('date')->take(15)->values();

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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan pengguna
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Cari berdasarkan deskripsi
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activityLogs = $query->paginate(20);

        // Dapatkan aksi unik untuk dropdown filter
        $actions = ActivityLog::distinct('action')->pluck('action');

        // Dapatkan pengguna untuk dropdown filter
        $users = \App\Models\User::select('id', 'name')->get();

        return view('admin.activity-logs.index', compact('activityLogs', 'actions', 'users'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'Log aktivitas berhasil dihapus.');
    }
}

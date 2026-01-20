<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.ulasan.index', compact('reviews'));
    }

    public function create()
    {
        return view('user.ulasan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
            'is_approved' => true, // Langsung aktif tanpa menunggu approval
        ]);

        // Log review creation
        ActivityLog::log(
            'create',
            'Created a new review',
            Auth::id(),
            $review,
            null,
            ['review_name' => $request->name]
        );

        return redirect()->route('user.ulasan.index')->with('success', 'Ulasan berhasil dikirim dan langsung ditampilkan di halaman utama.');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        
        // Pastikan user hanya bisa edit ulasannya sendiri
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.ulasan.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        // Pastikan user hanya bisa update ulasannya sendiri
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->update([
            'comment' => $request->comment,
            'rating' => $request->rating,
            'is_approved' => true, // Tetap aktif setelah update
        ]);

        // Log review update
        ActivityLog::log(
            'update',
            'Updated a review',
            Auth::id(),
            $review,
            null,
            ['review_name' => $request->name]
        );

        return redirect()->route('user.ulasan.index')->with('success', 'Ulasan berhasil diperbarui dan langsung ditampilkan di halaman utama.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Pastikan user hanya bisa hapus ulasannya sendiri
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        // Log review deletion
        ActivityLog::log(
            'delete',
            'Deleted a review',
            Auth::id(),
            null,
            ['review_name' => $review->name],
            null
        );

        return redirect()->route('user.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Set email ke email desa
        $data = $request->all();
        $data['email'] = 'kelmedaeng@gmail.com';

        // Kirim email langsung ke email desa
        Mail::to('kelmedaeng@gmail.com')->send(new ContactMail($data));

        return back()->with('success', 'Pesan Anda telah dikirim ke email desa! Kami akan segera merespons.');
    }
}

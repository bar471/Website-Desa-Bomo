<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function index()
    {
        return view('user.bantuan');
    }

    public function start(Request $request)
    {
        // kategori dipilih user
        $request->validate([
            'kategori' => 'required'
        ]);

        // simpan kategori ke session
        session(['bantuan_kategori' => $request->kategori]);

        // redirect ke halaman chat
        return redirect()->route('bantuan.chat');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BantuanMessage;

class BantuanChatController extends Controller
{
    public function start(Request $request)
    {
        // kategori dipilih user
        $request->validate([
            'kategori' => 'required'
        ]);

        session(['bantuan_kategori' => $request->kategori]);

        return redirect()->route('bantuan.chat.view');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        // simpan pesan user
        BantuanMessage::create([
            'sender' => 'user',
            'message' => $request->message
        ]);

        // admin akan membalas lewat dashboard
        return response()->json(['status' => 'sent']);
    }

    public function chatView()
    {
        $kategori = session('bantuan_kategori');

        if (!$kategori) {
            return redirect()->route('user.bantuan')->with('error', 'Pilih kategori dahulu!');
        }

        return view('user.bantuan-chat', compact('kategori'));
    }

    public function end()
    {
        return response()->json(['status' => 'ended']);
    }
}

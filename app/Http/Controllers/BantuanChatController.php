<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BantuanMessage;
use Illuminate\Support\Str;

class BantuanChatController extends Controller
{
    /**
     * Mulai chat — generate session_id, simpan kategori, buat initial message
     */
    public function start(Request $request)
    {
        $request->validate([
            'kategori' => 'required'
        ]);

        // buat session id unik untuk percakapan ini
        $sessionId = (string) Str::uuid();

        // simpan ke session agar halaman chat bisa memakai session_id & kategori
        session([
            'bantuan_session_id' => $sessionId,
            'bantuan_kategori' => $request->kategori,
        ]);

        // Buat record awal supaya admin punya baris untuk grouped session
        BantuanMessage::create([
            'session_id' => $sessionId,
            'sender' => 'user',
            'message' => 'Memulai percakapan',
            'kategori' => $request->kategori,
            'user_name' => null,
        ]);

        // redirect ke view chat user
        return redirect()->route('bantuan.chat.view');
    }

    /**
     * Kirim pesan user (AJAX)
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $sessionId = session('bantuan_session_id');

        if (! $sessionId) {
            return response()->json(['error' => 'Session chat tidak ditemukan'], 422);
        }

        BantuanMessage::create([
            'session_id' => $sessionId,
            'sender' => 'user',
            'message' => $request->message,
            'kategori' => session('bantuan_kategori') 
        ]);

        return response()->json(['status' => 'sent']);
    }

    /**
     * Tampilkan view chat user (pastikan session ada)
     */
    public function chatView()
    {
        $kategori = session('bantuan_kategori');

        if (! $kategori || ! session('bantuan_session_id')) {
            return redirect()->route('user.bantuan')->with('error', 'Pilih kategori dahulu!');
        }

        return view('user.bantuan-chat', [
            'kategori' => $kategori,
            'session_id' => session('bantuan_session_id')
        ]);
    }

    public function end()
    {
        // Opsional: hapus session keys
        session()->forget(['bantuan_session_id', 'bantuan_kategori']);
        return response()->json(['status' => 'ended']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::where('id_user', Auth::id())->latest()->get();
        Notifikasi::where('id_user', Auth::id())->update(['dibaca' => true]);
        return view('tenant.notifikasi', compact('notifikasis'));
    }
}
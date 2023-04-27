<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user     = AdminModel::where('username', $username)->first();
        if (!$user) return redirect()->back()->withErrors(['message' => 'Maaf username tidak tersedia']);
        if ($password != $password) return redirect()->back()->withErrors(['message' => 'Maaf password tidak sesuai']);

        # save user session
        Session::put('account', $user);
        return redirect()->to('/admin');
    }


    public function index(Request $request)
    {

        $totalParticipant = Participant::count();
        $confirmedParticipant = Participant::where('konfirmasi', 'Konfirmasi')->count();
        $unconfirmedParticipant = Participant::where('konfirmasi', 'Belum Di Konfirmasi')->count();

        return view('admin.dashboard', [
            'active'      => 'dashboard',
            'total'       => $totalParticipant,
            'confirmed'   => $confirmedParticipant,
            'unconfirmed' => $unconfirmedParticipant
        ]);
    }

    public function table(Request $request)
    {
        return view('admin.table', [
            'active'      => 'table',
        ]);
    }
}

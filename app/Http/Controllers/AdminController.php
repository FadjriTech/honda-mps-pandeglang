<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

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

    public function loadTable(Request $request)
    {
        $data = Participant::all();
        $res  =  DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn  = '<button href="javascript:void(0)" class="edit btn btn-primary btn-sm py-2 px-3">Detail</button>';
                $btn .= '<button href="javascript:void(0)" class="edit btn btn-outline-primary btn-sm py-2 px-3 ml-2">Konfirmasi</button>';;
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);

        return $res;
    }
}

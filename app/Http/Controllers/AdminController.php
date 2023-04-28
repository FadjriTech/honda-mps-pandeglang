<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\Motor;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
        $participantField = ['id', 'nama', 'telepon', 'KIS', 'tanggal_lahir', 'start', 'tim', 'kota'];

        return view('admin.table', [
            'active'           => 'table',
            'participantField' => $participantField
        ]);
    }

    public function loadTable(Request $request)
    {
        $data =  Participant::all();
        $res  =  DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn  = '<button data-id="' . $row->id . '" class="edit btn btn-primary btn-sm py-2 px-3 detail-button">Detail</button>';
                $btn .= '<div data-id="' . $row->id . '" class="edit btn btn-outline-primary btn-sm py-2 px-3 ml-2">' . $row->konfirmasi . '</div>';;
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
            })
            ->make(true);
        return $res;
    }

    public function getDetail(Request $request)
    {
        if ($request->ajax()) {
            $participantId = $request->input('participantId');
            $detail = Participant::with('motor')->find($participantId);
            $updatedAt = Carbon::parse($detail->updated_at)->format('F j, Y h:i:s A');
            $detail->updated_at_formatted = $updatedAt;
            return response()->json(['message' => 'OK', 'data' => $detail], 200);
        }
    }

    public function konfirmasiPembayaran(Request $request)
    {

        if (!$request->has('id')) return redirect()->to('/table')->with(['error' => 'Undefined id value']);
        $participantId = $request->input('id');
        $updated       = Participant::where('id', $participantId)->update(['konfirmasi' => 'Konfirmasi']);
        if (!$updated) return redirect()->to('/table')->with(['error' => 'Database Error']);

        $detail         = Participant::find($participantId);
        return redirect()->to('/table')->with(['pesan' => 'Selamat! Pendaftaran ' . $detail->nama . ' berhasil di konfirmasi']);
    }
}

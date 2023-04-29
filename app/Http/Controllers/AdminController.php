<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\Motor;
use App\Models\Participant;
use App\Models\Pengumuman;
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
                $btn .= '<button data-id="' . $row->id . '" class="edit btn btn-danger btn-sm py-2 px-3 ml-2 delete-button">Hapus</button>';
                $btn .= '<a href="/konfirmasi-pembayaran-get/' . Crypt::encrypt($row->id) . '" class="edit btn btn-outline-primary btn-sm py-2 px-3 ml-2">
                    Konfirmasi
                </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('konfirmasi', function ($data) {
                if ($data->konfirmasi == 'Belum Di Konfirmasi') {
                    return '<div class="btn btn-outline-primary py-2">Belum Di Konfirmasi</div>';
                } else {
                    return '<div class="btn btn-primary py-2">Sudah Di Konfirmasi</div>';
                }
            })
            ->rawColumns(['konfirmasi', 'action'])
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

    public function konfirmasiPembayaranGet($participantId)
    {
        $participantId = Crypt::decrypt($participantId);

        $participant   = Participant::find($participantId);

        $updatedTo     = $participant->konfirmasi == "Konfirmasi" ? "Belum Di Konfirmasi" : "Konfirmasi";
        $updated       = Participant::where('id', $participantId)->update(['konfirmasi' => $updatedTo]);
        if (!$updated) return redirect()->to('/table')->with(['error' => 'Database Error']);

        $detail         = Participant::find($participantId);
        return redirect()->to('/table')->with(['pesan' => 'Selamat! Pendaftaran ' . $detail->nama . ' berhasil di konfirmasi']);
    }

    public function deleteParticipant($participantId)
    {
        $participant = Participant::find($participantId);
        if (!$participant) return response()->json(['message' => 'uknown participant'], 404);
        if ($participant->bukti_pembayaran != null && $participant->bukti_pembayaran != '') {

            $filePath = public_path('bukti/' . $participant->bukti_pembayaran);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $participant->delete();
        return response()->json(['message' => 'Participant berhasil dihapus'], 200);
    }

    public function uploadPengumuman(Request $request)
    {
        $request->validate([
            'peraturan' => 'required|file'
        ], [
            'peraturan.required' => 'Pilih File PDF terlebih Dahulu'
        ]);



        // cek apakah sudah ada file peraturan
        $peraturan = Pengumuman::where('jenis', 'peraturan')->first();
        if ($peraturan) {
            $peraturanPath = public_path('pengumuman/' . $peraturan->file);
            if (file_exists($peraturanPath)) {
                unlink($peraturanPath);
            }
        }

        $deleteOld = Pengumuman::where('jenis', 'peraturan')->delete();
        $file = $request->file('peraturan');
        $directory = public_path('pengumuman');
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }


        $filename = $file->getClientOriginalName();
        $file->move($directory, $filename);

        $formData = [
            'file' => $filename,
            'jenis' => 'peraturan',
        ];

        Pengumuman::create($formData);
        return redirect()->back()->with(['pesan' => 'Peraturan .pdf berhasil di upload']);
    }
}

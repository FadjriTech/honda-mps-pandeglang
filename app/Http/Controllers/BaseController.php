<?php

namespace App\Http\Controllers;

use App\Models\Motocross;
use App\Models\Motor;
use App\Models\Participant;
use App\Models\Pengumuman;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManager;

class BaseController extends Controller
{

    public function index(Request $request)
    {
        return view('pages.app');
    }

    public function peraturan()
    {
        $peraturan = Pengumuman::where('jenis', 'peraturan')->first();
        if (!$peraturan) return redirect()->to('/')->with(['error' => 'Maaf peraturan belum ada']);
        return response()->download(public_path('/pengumuman/' . $peraturan->file));
    }

    public function hasilLomba()
    {
        $pemenang = Pengumuman::where('jenis', 'pemenang')->first();
        if (!$pemenang) return redirect()->to('/')->with(['error' => 'Maaf hasil lomba belum ada']);
        return response()->download(public_path('/pengumuman/' . $pemenang->file));
    }

    public function form(Request $request)
    {

        if ($request->method() == "GET") {
            $motocross = collect(Motocross::all());
            return view('pages/form', [
                'motocross' => $motocross
            ]);
        } else {
            $request->validate([
                'nama'          => 'required',
                'telepon'       => 'required',
                'KIS'           => 'required',
                'tanggal_lahir' => 'required',
                'start'         => 'required',
                'tim'           => 'required',
                'kota'          => 'required',
                'motor'         => 'required',
            ]);

            $nama           = $request->input('nama');
            $telepon        = $request->input('telepon');
            $KIS            = $request->input('KIS');
            $tanggal_lahir  = $request->input('tanggal_lahir');
            $start          = $request->input('start');
            $tim            = $request->input('tim');
            $kota           = $request->input('kota');
            $motors          = collect($request->input('motor'));

            $data = [
                'nama'          => $nama,
                'telepon'       => $telepon,
                'KIS'           => $KIS,
                'tanggal_lahir' => $tanggal_lahir,
                'start'         => $start,
                'tim'           => $tim,
                'kota'          => $kota
            ];


            $insertId = Participant::create($data)->id;

            foreach ($motors as $motor) {
                if ($motor['kelas'] != null || $motor['kategori'] != null || $motor['merk'] != null || $motor['mesin'] != null || $motor['rangka'] != null) {
                    try {
                        $motor['participantId'] = $insertId;
                        Motor::create($motor);
                    } catch (Exception $e) {
                        continue;
                    }
                } else {
                    continue;
                }
            }

            return redirect()->to('/pembayaran/' . Crypt::encrypt($insertId));
        }
    }

    public function pembayaran($participantId, Request $request)
    {

        $participantId = Crypt::decrypt($participantId);
        $participant = collect(Participant::with('motor')->find($participantId));
        $totalBiaya  = Motor::where('participantId', $participantId)->sum('biaya');
        $participant['total_biaya'] = $totalBiaya;

        return view('pages.pembayaran', ['data' => $participant]);
    }

    public function buktiPembayaran(Request $request)
    {
        try {
            $validated = $request->validate([
                'participantId'    => 'required|exists:participant,id',
                'bukti_pembayaran' => 'required|image'
            ]);

            $participantId = $request->input('participantId');
            $image = $request->file('bukti_pembayaran');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Delete old image if it exists
            $oldImageName = Participant::where('id', $participantId)->value('bukti_pembayaran');
            if ($oldImageName) {
                $oldImagePath = public_path('bukti') . '/' . $oldImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageCompressor = new ImageManager();
            $image = $imageCompressor->make($image);
            $image->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('bukti') . '/' . $imageName);

            # update DB
            Participant::where('id', $participantId)->update(['bukti_pembayaran' => $imageName]);

            return redirect()->back()->with(['pesan' => 'Upload bukti pembayaran berhasil, Tunggu Konfirmasi 😊']);
        } catch (Exception $error) {
            return redirect()->back()->withInput();
        }
    }

    public function daftarPeserta(Request $request)
    {
        $queries       = $request->query();
        $participant   = Motor::with('participant');


        $params = ['kelas', 'kategori'];
        foreach ($params as $param) {
            if (isset($queries[$param])) {
                $paramValue = $queries[$param];
                $participant->where($param, $paramValue);
            }
        }

        $participant = collect($participant->get());

        $classList = collect(Motocross::get());
        return view('pages.daftar-peserta', [
            'classList'   => $classList,
            'queries'     => $queries,
            'participant' => $participant
        ]);
    }
}

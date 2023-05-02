<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\Motocross;
use App\Models\Motor;
use App\Models\Participant;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\Break_;

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

        if (Hash::check($password, $user->password)) return redirect()->back()->withErrors(['message' => 'Maaf password tidak sesuai']);

        # save user session
        Session::put('admin', $user);
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
                $btn .= '<a target="_blank" href="https://wa.me/+62' . $row->telepon . '" class="edit btn btn-outline-success btn-sm py-2 px-3 ml-2">
                Whatsapp
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
            $lastThreeDigits  = substr($detail->telepon, -3);


            $totalBiaya = Motor::where('participantId', $participantId)->sum('biaya');
            $detail->updated_at_formatted = $updatedAt;
            $detail->totalBiaya = $totalBiaya + intval($lastThreeDigits);
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

            if (getenv('APP_DEBUG')) {
                $filePath = public_path('bukti/' . $participant->bukti_pembayaran);
            } else {
                $filePath = '/bukti/' . $participant->bukti_pembayaran;
            }
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $participant->delete();
        Motor::where('participantId', $participantId)->delete();
        return response()->json(['message' => 'Participant berhasil dihapus'], 200);
    }

    public function uploadPengumuman(Request $request)
    {
        $request->validate([
            'peraturan' => 'required|file'
        ], [
            'peraturan.required' => 'Pilih File terlebih Dahulu'
        ]);



        // cek apakah sudah ada file peraturan
        $peraturan = Pengumuman::where('jenis', 'peraturan')->first();
        if ($peraturan) {
            if (getenv('APP_DEBUG')) {
                $peraturanPath = public_path('pengumuman/' . $peraturan->file);
            } else {
                $peraturanPath = '/pengumuman/' . $peraturan->file;
            }
            if (file_exists($peraturanPath)) {
                unlink($peraturanPath);
            }
        }

        $deleteOld = Pengumuman::where('jenis', 'peraturan')->delete();
        $file = $request->file('peraturan');
        if (getenv('APP_DEBUG')) {
            $directory = public_path('pengumuman');
        } else {
            $directory = 'pengumuman';
        }
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
        return redirect()->back()->with(['pesan' => 'File berhasil di upload']);
    }

    public function uploadPemenang(Request $request)
    {

        $request->validate([
            'pemenang' => 'required|file'
        ], [
            'pemenang.required' => 'Pilih File terlebih Dahulu'
        ]);



        // cek apakah sudah ada file pemenang
        $pemenang = Pengumuman::where('jenis', 'pemenang')->first();
        if ($pemenang) {
            if (getenv('APP_DEBUG')) {
                $pemenangPath = public_path('pengumuman/' . $pemenang->file);
            } else {
                $pemenangPath = '/pengumuman/' . $pemenang->file;
            }
            if (file_exists($pemenangPath)) {
                unlink($pemenangPath);
            }
        }

        Pengumuman::where('jenis', 'pemenang')->delete();
        $file = $request->file('pemenang');
        if (getenv('APP_DEBUG')) {
            $directory = public_path('pengumuman');
        } else {
            $directory = 'pengumuman';
        }
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }


        $filename = $file->getClientOriginalName();
        $file->move($directory, $filename);

        $formData = [
            'file' => $filename,
            'jenis' => 'pemenang',
        ];

        Pengumuman::create($formData);
        return redirect()->back()->with(['pesan' => 'File berhasil di upload']);
    }

    public function export()
    {
        // Get motocross value
        $motocross = collect(Motocross::all());
        $participants = collect(Participant::with('motor')->get());

        $data = array(
            array('no', 'nama lengkap', 'no kis', 'tanggal lahir', 'no star', 'team', 'kota asal', 'no wa', 'biaya pendaftaran')
        );

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        // Add header row to worksheet
        $worksheet->fromArray($data);

        // Merge cells in header row
        $lastColumn = $worksheet->getHighestColumn();
        $lastColumnIndex = Coordinate::columnIndexFromString($lastColumn);
        for ($i = 1; $i <= $lastColumnIndex; $i++) {
            $columnLetter = Coordinate::stringFromColumnIndex($i);
            $worksheet->mergeCells($columnLetter . '1:' . $columnLetter . '2');
        }

        // Center align header cells vertically and horizontally
        $headerStyle = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];



        // motocross header
        $motocrossRange = range('J', 'Q');
        $GrassRange     = range('R', 'U');
        $ExecutiveRange = range('V', 'Y');

        //-- set Header center
        $worksheet->mergeCells("J1:Q1")->setCellValue("J1", "Motocross");
        $worksheet->mergeCells("R1:U1")->setCellValue("R1", "Grass Track");
        $worksheet->mergeCells("V1:Y1")->setCellValue("V1", "Executive");


        foreach ($motocross->where('kelas', 'Utama Motocross')->values() as $kelasIndex => $kelas) {
            $worksheet->setCellValue($motocrossRange[$kelasIndex] . '2', $kelas->nama);
        }

        foreach ($motocross->where('kelas', 'Grass Track')->values() as $kelasIndex => $kelas) {
            $worksheet->setCellValue($GrassRange[$kelasIndex] . '2', $kelas->nama);
        }

        foreach ($motocross->where('kelas', 'Executive')->values() as $kelasIndex => $kelas) {
            $worksheet->setCellValue($ExecutiveRange[$kelasIndex] . '2', $kelas->nama);
        }




        $startFromRow = 3;
        $keys = ['id', 'nama', 'KIS', 'tanggal_lahir', 'start', 'tim', 'kota', 'telepon', 'telepon'];
        foreach ($participants as $participant) {


            // --- set participant column value
            $motor = collect($participant['motor']);
            $totalBiaya = $motor->sum('biaya');
            foreach (range('A', 'H') as $index => $column) {
                $worksheet->setCellValue($column . strval($startFromRow), $participant[$keys[$index]]);
            }
            $worksheet->setCellValue('I' . $startFromRow, $this->format_rupiah($totalBiaya));


            // Check participant class registered 
            foreach ($motocross->where('kelas', 'Utama Motocross')->values() as $kelasIndex => $kelas) {
                $cekkelas = $motor->where('kategori', $kelas->nama);
                if (sizeof($cekkelas->toArray()) > 0) {
                    $worksheet->setCellValue($motocrossRange[$kelasIndex] . $startFromRow, 'V');
                }
            }

            foreach ($motocross->where('kelas', 'Grass Track')->values() as $kelasIndex => $kelas) {
                $cekkelas = $motor->where('kategori', $kelas->nama);
                if (sizeof($cekkelas->toArray()) > 0) {
                    $worksheet->setCellValue($GrassRange[$kelasIndex] . $startFromRow, 'V');
                }
            }


            foreach ($motocross->where('kelas', 'Executive')->values() as $kelasIndex => $kelas) {
                $cekkelas = $motor->where('kategori', $kelas->nama);
                if (sizeof($cekkelas->toArray()) > 0) {
                    $worksheet->setCellValue($ExecutiveRange[$kelasIndex] . $startFromRow, 'V');
                }
            }
            $startFromRow++;
        }


        $headerRange = 'A1:Z2';
        $worksheet->getStyle($headerRange)->applyFromArray($headerStyle);


        // Autofit column width
        foreach (range('A', 'Z') as $column) {
            $worksheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        // Set the file name and extension
        $filename = 'honda-mps-recap-' . time() . '.xlsx';

        // Send the appropriate headers to initiate the download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Output the Excel file contents
        $writer->save('php://output');
    }


    function format_rupiah($angka)
    {
        $rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $rupiah;
    }

    public function logout()
    {
        session()->flush();
        return redirect()->to('/admin/login');
    }
}

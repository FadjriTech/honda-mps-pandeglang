<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran</title>
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body style="overflow-x: hidden; margin: 0; padding: 0">
    <header class="container-fluid bg-black text-white m-0">
        <div class="row">
            <div class="col-12 py-2 text-center">
                <a class="navbar-brand" href="/">
                    <img src="/assets/images/logo.png" alt="Bootstrap" height="70">
                </a>
            </div>
        </div>
    </header>
    <main class="w-100 py-5">
        <div class="row align-items-center justify-center">
            <div class="col text-white align-items-center d-flex justify-content-center flex-column">

                <div class="card main-card">
                    @if (Session::has('pesan'))
                        <div class="alert alert-success m-2" role="alert">
                            <h4 class="alert-heading m-0">Selamat!</h4>
                            <hr>
                            <p class="m-0">{{ Session::get('pesan') }}</p>
                        </div>
                    @endif
                    @if (Session::has('errors'))
                        <div class="alert alert-warning m-2" role="alert">
                            <h4 class="alert-heading m-0">Oops sorry! 😟</h4>
                            <hr>
                            <p class="m-0">{{ Session::get('errors')->first() }}</p>
                        </div>
                    @endif


                    <img src="/assets/images/QRIS.jpeg" class="card-img-top" alt="QRIS - Image">
                    <form action="/upload-bukti-pembayaran" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="participantId" value="{{ $data['id'] }}">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="alert {{ $data['konfirmasi'] == 'Belum Di Konfirmasi' ? 'alert-warning' : 'alert-success' }}"
                                    role="alert">
                                    {{ $data['konfirmasi'] == 'Belum Di Konfirmasi' ? 'Tunggu Verifikasi 😇' : 'Sudah Di Konfirmasi 😀' }}
                                </div>
                                <table class="table">
                                    <tr>
                                        <th>Nama</th>
                                        <td>: {{ $data['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telp.</th>
                                        <td>: {{ $data['telepon'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Team</th>
                                        <td>: {{ $data['tim'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kota</th>
                                        <td>: {{ $data['kota'] }}</td>
                                    </tr>
                                </table>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <h6>Daftar Kelas yang di ikuti :</h6>

                                        <ol class="list-group">
                                            @foreach ($data['motor'] as $motor)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <p class="m-0">
                                                        {{ $motor['kelas'] }}
                                                    </p>
                                                    <p class="m-0">
                                                        {{ 'Rp ' . number_format($motor['biaya'], 0, ',', '.') }}
                                                    </p>
                                                </li>
                                            @endforeach
                                            <li
                                                class="list-group-item d-flex justify-content-between bg-success text-white fw-semibold">
                                                <p class="m-0">Total Biaya</p>
                                                <p class="m-0">
                                                    {{ 'Rp ' . number_format($data['total_biaya'], 0, ',', '.') }}
                                                </p>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <label for="bukti_pembayaran" class="form-text my-3 fst-italic">
                                    Bukti Screenshot Pembayaran 👇🏼 <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control" id="bukti_pembayaran"
                                    name="bukti_pembayaran">
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-100 d-flex align-items-center gap-2 justify-content-center">
                                Upload Bukti Pembayaran <i class="bi bi-upload"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <br><br><br>

        <a class="floating-whatsapp d-flex align-items-center gap-3 fw-semibold fst-italic"
            style="text-decoration: none; color: black" href="https://wa.me/+6287772851984" target="_blank">
            <div class="d-flex align-items-end flex-column">
                <p class="m-0 form-text">Contact Us</p>
                <p class="m-0">0877 7285 1984</p>
            </div>
            <img src="https://1.bp.blogspot.com/-PM8_Rig8V0M/XxFkv-2f3hI/AAAAAAAACSU/vB1BqbuhFCMyJ8OGCVstFiMLFmavCLqrwCPcBGAYYCw/s1600/whatsapp-logo-1.png"
                alt="whatsapp-icon" style="height: 50px; width: 50px">
        </a>
    </main>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <style>
        .floating-whatsapp {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .main-card {
            width: 100%
        }

        @media (width > 760px) {
            .main-card {
                width: 30rem
            }
        }
    </style>
</body>

</html>

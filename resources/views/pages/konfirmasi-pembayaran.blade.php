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
                    <form action="/upload-bukti-pembayaran" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="participantId" value="{{ $data['id'] }}">
                        <div class="card-body">
                            <img src="https://img.freepik.com/premium-vector/adult-cheerful-office-employee-man-formal-clothes-jump-with-raised-hands-happy-male-character-wearing-suit-celebrate-victory-win-isolated-white-background-cartoon-people-vector-illustration_1016-11696.jpg"
                                alt="illustration" style="width: 100%; max-height: 200px;object-fit: contain">
                            <h5 class="card-title"><strong>Selamat!</strong> pendaftaran berhasil</h5>
                            <p class="card-text fst-italic">
                                Terimakasih sudah mendaftar, tunggu konfirmasi dari admin, jika terjadi masalah silahkan
                                konfirmasi ke admin
                            </p>
                            <a href="https://wa.me/+6287772851984" target="_blank"
                                class="btn btn-outline-success w-100">Contact Admin
                            </a>
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

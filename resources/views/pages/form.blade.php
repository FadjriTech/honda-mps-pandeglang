<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>OMPS 2023</title>


    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <!-- Bootstrap CS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Jquery Link -->

    <style type='text/css'>
        .content-inner {
            margin-top: -30px !important;
        }
    </style>

</head>

<body>
    <header class="container-fluid bg-black text-white">
        <div class="row">
            <div class="col-12 py-2 text-center">
                <a class="navbar-brand" href="/">
                    <img src="/assets/images/logo.png" alt="Bootstrap" height="70">
                </a>
            </div>
        </div>
    </header>



    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
        </ul>
    </div><!-- /.navbar-collapse -->
    </nav>
    </div>


    <html lang="en">

    <body>

        <div class="container py-5">
            <div class="row" style="margin-left:0;margin-right:0;">



                <div class="col-md-12">
                    <div class="jumbotron daftar">
                        <div class="header">
                            <h3>
                                <center>Formulir Pendaftaran Honda MPS Motocross</center>
                            </h3>
                        </div>
                        <hr style="border:1px solid black">

                        <form action="/form" method="post">
                            @csrf
                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control mb-2"
                                    placeholder="ex. Antonio Cairoli" required>
                            </div>


                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">No Whatsapp</label>
                                <input type="number" name="telepon" class="form-control mb-2"
                                    placeholder="ex. 081129314xxx" required>
                            </div>


                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">No. KIS</label>
                                <input type="text" name="KIS" class="form-control mb-2"
                                    placeholder="ex. 796-C2/xx/xxxx" required>
                            </div>

                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control mb-2" placeholder=""
                                    required>
                            </div>


                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">Nomor Start</label>
                                <input type="number" name="start" min="0" max="999"
                                    class="form-control mb-2" placeholder="ex. 222" required>
                            </div>

                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">Team</label>
                                <input type="text" name="tim" class="form-control mb-2"
                                    placeholder="ex. KTM Racing Team" required>
                            </div>

                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1">Kota Asal</label>
                                <input type="text" name="kota" class="form-control mb-2"
                                    placeholder="ex. Jakarta / Kab. Malang" required>
                            </div>

                            <div class="mb-3 d-flex gap-2 flex-column">
                                <label for="exampleInputEmail1"></label></br>
                                <h4><strong>KELAS YANG DILOMBAKAN DI HONDA MPS MOTOCROSS</strong></h4>
                                <br>

                                <h5 class="fw-bold">Kelas Utama Motocross</h5>
                                @foreach ($motocross->where('kelas', 'Utama Motocross') as $index => $motor)
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" id={{ $motor }} class="motor-checkbox">
                                            <p class="m-0">{{ $motor->nama }}</p>
                                        </div>
                                        <div class="d-flex flex-column gap-2 newform d-none">
                                            <input type="hidden" name="motor[{{ $index }}][kategori]"
                                                value="{{ $motor->nama }}">
                                            <input type="hidden" name="motor[{{ $index }}][kelas]"
                                                value="{{ $motor->kelas }}">
                                            <input type="text" placeholder="Nama Merk" class="form-control"
                                                name="motor[{{ $index }}][merk]" list="merk">
                                            <input type="text" placeholder="No. Mesin" class="form-control"
                                                name="motor[{{ $index }}][mesin]">
                                            <input type="text" placeholder="No. Rangka" class="form-control"
                                                name="motor[{{ $index }}][rangka]">
                                            <input type="hidden" placeholder="Biaya" class="form-control"
                                                name="motor[{{ $index }}][biaya]" readonly
                                                value={{ $motor->biaya }}>
                                        </div>
                                    </div>
                                @endforeach

                                <h5 class="fw-bold">Kelas Grass Track</h5>
                                @foreach ($motocross->where('kelas', 'Grass Track') as $index => $motor)
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" id={{ $motor }} class="motor-checkbox">
                                            <p class="m-0">{{ $motor->nama }}</p>
                                        </div>
                                        <div class="d-flex flex-column gap-2 newform d-none">
                                            <input type="hidden" name="motor[{{ $index }}][kategori]"
                                                value="{{ $motor->nama }}">
                                            <input type="hidden" name="motor[{{ $index }}][kelas]"
                                                value="{{ $motor->kelas }}">
                                            <input type="text" placeholder="Nama Merk" class="form-control"
                                                name="motor[{{ $index }}][merk]" list="merk">
                                            <input type="text" placeholder="No. Mesin" class="form-control"
                                                name="motor[{{ $index }}][mesin]">
                                            <input type="text" placeholder="No. Rangka" class="form-control"
                                                name="motor[{{ $index }}][rangka]">
                                            <input type="hidden" placeholder="Biaya" class="form-control"
                                                name="motor[{{ $index }}][biaya]" readonly
                                                value={{ $motor->biaya }}>
                                        </div>
                                    </div>
                                @endforeach
                                <h5 class="fw-bold">Kelas Executive</h5>
                                @foreach ($motocross->where('kelas', 'Executive') as $index => $motor)
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" id={{ $motor }} class="motor-checkbox">
                                            <p class="m-0">{{ $motor->nama }}</p>
                                        </div>
                                        <div class="d-flex flex-column gap-2 newform d-none">
                                            <input type="hidden" name="motor[{{ $index }}][kategori]"
                                                value="{{ $motor->nama }}">
                                            <input type="hidden" name="motor[{{ $index }}][kelas]"
                                                value="{{ $motor->kelas }}">
                                            <input type="text" placeholder="Nama Merk" class="form-control"
                                                name="motor[{{ $index }}][merk]" list="merk">
                                            <input type="text" placeholder="No. Mesin" class="form-control"
                                                name="motor[{{ $index }}][mesin]">
                                            <input type="text" placeholder="No. Rangka" class="form-control"
                                                name="motor[{{ $index }}][rangka]">
                                            <input type="hidden" placeholder="Biaya" class="form-control"
                                                name="motor[{{ $index }}][biaya]" readonly
                                                value={{ $motor->biaya }}>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-grid gap-2 col-6 mx-auto">
                                <input type="submit" name="submit" href="#" class="btn btn-primary"
                                    value="Daftar">
                            </div>
                            <datalist id="merk">
                                <option value="YAMAHA">
                                <option value="HONDA">
                                <option value="KAWASAKI">
                                <option value="KTM">
                                <option value="HUSQVARNA">
                                <option value="HUSABERG">
                                <option value="SUZUKI">
                                <option value="SHERCO">
                                <option value="BETA">
                                <option value="GAZGAS">
                                <option value="GASGAS">
                                <option value="MONTESA">
                                <option value="MONSTRAC">
                                <option value="VIAR">
                                <option value="KAYO">
                                <option value="DIABLO">
                                <option value="SND">
                                <option value="GPX">
                                <option value="CUSTOM">
                            </datalist>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
            integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
            integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
        </script>

        <script>
            $(document).ready(function() {
                $('.motor-checkbox').change(function(e) {
                    if ($(this).prop('checked')) {
                        $(this).parent().parent().find('.newform').removeClass('d-none');
                    } else {
                        $(this).parent().parent().find('.newform').addClass('d-none');
                    }
                });

            });
        </script>

    </body>

    </html>



    <script src="/js/bootstrap.min.js"></script>
</body>

</html>

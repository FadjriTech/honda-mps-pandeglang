<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Honda MPS Motor Pandeglang</title>

    <!-- Bootstrap CS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">

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
                <a class="navbar-brand" href="/index.php">
                    <img src="/assets/images/logo.png" alt="Bootstrap" height="80">
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


    <link rel="stylesheet" type="text/css" href="dt/css/dataTables.bootstrap.css">
    <style type="text/css">
        .satu {
            font-size: 100%;
        }

        .dua {
            font-size: 16px;
        }

        .tiga {
            font-size: 30%;
        }
    </style>
    <hr>
    </hr>
    <div class="mx-3" style="overflow-y: auto">

        <form method="GET">
            <select name="kelas" id="kelas" class="form-control mb-2">
                @foreach ($classList->pluck('kelas')->unique() as $class)
                    <option value="{{ $class }}"
                        @if (isset($queries['kelas'])) @if ($queries['kelas'] == $class)
                            selected @endif
                        @endif>Kelas {{ $class }}</option>
                @endforeach
            </select>
            <select name="kategori" id="kategori" class="form-control">
                @foreach ($classList->pluck('nama')->unique() as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary w-100 mt-2">Filter</button>
                </div>
                <div class="col-12">
                    <a href="/daftar-peserta" class="btn btn-secondary w-100 mt-2">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered table-responsive" style="font-size:12px;">
            <thead>
                <tr class="table-info">
                    <th width="2%">No</th>
                    <th width="25%">Nama</th>
                    <th width="8%">Merk</th>
                    <th width="10%">Team</th>
                    <th width="30%">Kategori</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($participant as $index => $item)
                    <tr>
                        <td class="table-info">{{ $index + 1 }}</td>
                        <td>#{{ $item->id }}{{ $item->participant->nama }}<br>
                            <span class="badge rounded-pill text-bg-danger">{{ $item->participant->kota }}</span>
                        </td>
                        <td>{{ $item->merk }}</td>
                        <td>{{ $item->participant->tim }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->participant->konfirmasi }}</td>
                    </tr>
                @endforeach
            </tbody>
            </thead>
        </table>

    </div>


    <script>
        $(document).ready(function() {
            $('#pendaftar').DataTable({
                responsive: true
            });
        });
    </script>
    </head>
</body>

</html>

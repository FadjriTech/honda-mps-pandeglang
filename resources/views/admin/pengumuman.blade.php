@extends('admin.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h4 class="card-title">Upload PDF Informasi</h4>
            </div>


            <div class="col">
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
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Peraturan Pelengkap Perlombaan PUP</h5>
                        <h6 class="card-subtitle mb-3 text-muted">Upload file PDF sesuai judul di atas</h6>
                        <form action="/upload-pengumuman" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="file" class="input-file">
                                <span id="label">Browse File</span>
                                <input type="file" id="file" class="d-none" name="peraturan">
                            </label>
                            <button class="btn btn-primary mb-2" style="width: 100%">Upload</button>
                            <a class="btn btn-outline-primary" style="width: 100%">Download File Pengumuman</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#file').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $('#label').text(fileName);
            });
            // Limit file types to PDF only
            $('#file').attr('accept', 'application/pdf');
        });
    </script>
@endsection

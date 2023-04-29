@extends('admin.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (Session::has('pesan'))
                    <div class="alert alert-success m-2" role="alert">
                        <p class="m-0">{{ Session::get('pesan') }}</p>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-warning m-2" role="alert">
                        <h4 class="alert-heading m-0">Oops sorry! 😟</h4>
                        <hr>
                        <p class="m-0">{{ Session::get('error') }}</p>
                    </div>
                @endif
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Participant</h4>
                        <div class="table-responsive">
                            <table class="table" id="participant-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kota</th>
                                        <th>Tim</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.detailModal')
@endsection

@section('script')
    <script>
        $(function() {
            $('#participant-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/load-table',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kota',
                        name: 'kota'
                    },
                    {
                        data: 'tim',
                        name: 'tim'
                    },
                    {
                        data: 'konfirmasi',
                        name: 'konfirmasi'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]
            });
        });

        $(document).on('click', '.detail-button', function(e) {
            const participantId = $(this).attr('data-id');
            // Show detail modal
            $("#detailModal").modal('show');


            $.ajax({
                type: "POST",
                url: "{{ route('participant.detail') }}",
                data: {
                    participantId: participantId
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const data = response.data;
                    const keys = Object.keys(data);
                    keys.forEach((key, index) => {
                        $(`#${key}`).val(data[key]);
                    });


                    const motor = data['motor'];
                    let total = 0;
                    if (motor.length > 0) {
                        let list = '';
                        motor.forEach((key, index) => {
                            total += key.biaya
                            list += ` <tr>
                                            <th scope="row">${index + 1}</th>
                                            <td>${key.kelas}</td>
                                            <td>${key.kategori}</td>
                                            <td>${key.rangka}</td>
                                            <td>${key.mesin}</td>
                                            <td>${formatRupiah(key.biaya)}</td>
                                        </tr>`;
                        });

                        list += `<tr>
                            <td colspan="5">Total Biaya Pendaftaran</td>    
                            <td>${formatRupiah(total)}</td>    
                        </tr>`

                        $("#motorList").html(list)
                    }
                    if (data['bukti_pembayaran'] != null && data['bukti_pembayaran'] != '') {
                        const buktiGambar = `/bukti/${data['bukti_pembayaran']}`;
                        $("#card-bukti-pembayaran").removeClass('d-none')
                        $("#gambar-bukti-pembayaran").attr('src', buktiGambar);
                        $("#buka-gambar").attr('href', buktiGambar)
                        $("#updated_at").html(data['updated_at_formatted'])
                    } else {
                        $("#card-bukti-pembayaran").addClass('d-none');
                    }
                }
            });


            function formatRupiah(number) {
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });

                return formatter.format(number);
            }

        })
    </script>
@endsection

<div class="modal fade" tabindex="-1" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Participant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/konfirmasi-pembayaran" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            @foreach ($participantField as $field)
                                <div class="col-3 {{ $field == 'id' ? 'd-none' : '' }}">
                                    <div class="form-group">
                                        <label for="{{ $field }}"
                                            class="form-label">{{ str_replace('_', ' ', ucfirst($field)) }}</label>
                                        <input type="{{ $field == 'tanggal_lahir' ? 'date' : 'text' }}"
                                            class="form-control" id="{{ $field }}" name="{{ $field }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-normal">Kelas Yang Di ikuti</h6>
                            </div>
                            <div class="col-12" style="overflow-x: auto">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kelas</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">No. Rangka</th>
                                            <th scope="col">No. Mesin</th>
                                            <th scope="col">Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody id="motorList">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 my-3 d-none" id="card-bukti-pembayaran">
                                <h6 class="font-weight-normal mb-2">Bukti Pembayaran</h6>
                                <div class="card">
                                    <img class="card-img-top"
                                        src="https://th.bing.com/th/id/R.5ff2db7e8e4d19944c2f069cffe2f383?rik=fOlt%2f%2f7B7hTQhg&riu=http%3a%2f%2f4.bp.blogspot.com%2f-UVaMJtH1H_8%2fT2W_uMohthI%2fAAAAAAAAAZQ%2fyvC-RN7cjY4%2fs1600%2fLake%2bBled%2c%2bSlovenia%2b8.jpg&ehk=lJXA96rlgJoJwrTRvkqyvxAuxQ3z9%2bCs77UO912xoug%3d&risl=&pid=ImgRaw&r=0"
                                        alt="Card image cap" id="gambar-bukti-pembayaran"
                                        style="max-height: 250px; object-fit: contain">
                                    <div class="card-body">
                                        <p class="card-text mb-2">
                                            Gambar di upload pada <span id="updated_at"></span>
                                        </p>
                                        <a href="" id="buka-gambar" class="btn btn-primary">Buka Gambar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

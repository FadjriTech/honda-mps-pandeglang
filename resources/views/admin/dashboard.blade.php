@extends('admin.app')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome Admin</h3>
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card tale-bg">
                <div class="card-people mt-auto">
                    <img src="https://th.bing.com/th/id/OIP.ZSg194ds1zIJF9CwtL1y-wHaFL?pid=ImgDet&rs=1" alt="people">
                    <div class="weather-info">
                        <div class="d-flex">
                            <div class="ml-2">
                                <h4 class="location font-weight-normal">Honda MPS Pandeglang</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Total Participant</p>
                            <h3 class="fs-1 mb-2">
                                {{ $total }} Participant
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Confirmed Participant</p>
                            <h3 class="fs-1 mb-2">
                                {{ $confirmed }} Participant
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Unconfirmed Participant</p>
                            <h3 class="fs-1 mb-2">
                                {{ $unconfirmed }} Participant
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

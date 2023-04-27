<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Honda MPS Admin</title>
    <link rel="stylesheet" href="/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/skydash/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/skydash/css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="/skydash/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="/skydash/images/logo.svg" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>

                            @if ($errors->any())
                                <div class="alert alert-primary mt-2 border-0" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <form class="pt-3" method="POST" action="/post-login">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                        placeholder="Username" name="username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" name="password">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        href="/skydash/index.html">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/skydash/vendors/js/vendor.bundle.base.js"></script>
    <script src="/skydash/js/off-canvas.js"></script>
    <script src="/skydash/js/hoverable-collapse.js"></script>
    <script src="/skydash/js/template.js"></script>
    <script src="/skydash/js/settings.js"></script>
    <script src="/skydash/js/todolist.js"></script>
</body>

</html>

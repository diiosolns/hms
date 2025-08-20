<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Multi-purpose admin dashboard template that especially build for programmers.">
    <title>HMS</title>
    <link rel="shortcut icon" href="./images/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1.1.1') }}">
</head>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <!-- Root  -->
    <div class="nk-app-root">
        <!-- main  -->
        <div class="nk-main">
            <div class="nk-wrap align-items-center justify-content-center has-mask">
                <div class="mask mask-3"></div><!-- .mask-->
                <div class="container p-2 p-sm-4">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-6">
                            <div class="card card-gutter-lg rounded-4 card-auth">
                                <div class="card-body">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title mb-1">Create New Account</h3>
                                            <p class="small">Use your email to create a new account for the Hospital Management System (HMS)</p>
                                        </div>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row gy-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <div class="form-control-wrap">
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">Phone No.</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Eg. 07XX XXX XXX">
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="form-control-wrap">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                    <div class="form-control-wrap">
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                                                    </div>
                                                </div><!-- .form-group -->
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="1" id="iAgree" required>
                                                    <label class="form-check-label" for="iAgree"> I agree to <a href="#">privacy policy</a> & <a href="#">terms</a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <input type="hidden" name="role" value="owner">
                                                    <button class="btn btn-primary" type="submit">Sign up</button>
                                                </div>
                                            </div>
                                        </div><!-- .row -->
                                    </form>
                                    <div class="text-center mt-4">
                                        <p class="small">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                                    </div>
                                </div><!-- .card-body -->
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-6 align-self-center">
                            <div class="card-body is-theme ps-lg-4 pt-5 pt-lg-0">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="h1 title mb-3">Welcome to <br> HMS.</div>
                                        <p>Discover how to manage Two-Factor Authentication in Joomla. The two-factor authentication in Joomla is a very popular security practice.</p>
                                    </div>
                                </div><!-- .row -->
                                <div class="mt-5 pt-4">
                                    <div class="media-group media-group-overlap">
                                        <div class="media media-sm media-circle media-border border-white">
                                            <img src="./images/avatar/a.jpg" alt="">
                                        </div>
                                        <div class="media media-sm media-circle media-border border-white">
                                            <img src="./images/avatar/b.jpg" alt="">
                                        </div>
                                        <div class="media media-sm media-circle media-border border-white">
                                            <img src="./images/avatar/c.jpg" alt="">
                                        </div>
                                        <div class="media media-sm media-circle media-border border-white">
                                            <img src="./images/avatar/d.jpg" alt="">
                                        </div>
                                    </div>
                                    <p class="small mt-2">More than 2k people joined us, it's your turn</p>
                                </div>
                            </div><!-- .card-body -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div>
        </div> <!-- .nk-main -->
    </div> <!-- .nk-app-root -->
</body>
<!-- JavaScript -->
<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>

</html>

@extends('layout.master')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="profile-bg-picture"
                 style="background-image:url('assets/images/bg-profile.jpg')">
                <span class="picture-bg-overlay"></span>
                <!-- overlay -->
            </div>
            <!-- meta -->
            <div class="profile-user-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="">
                            <h4 class="mt-4 fs-17 ellipsis">{{ $user->name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ meta -->
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">{{ __('home.settings') }}</a></li>

                        </ul>

                        <div class="tab-content m-0 p-4">

                            <!-- settings -->
                            <div id="edit-profile" class="tab-pane active">
                                <div class="user-profile-content">
                                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="row row-cols-sm-2 row-cols-1">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">{{ __('home.Name') }}</label>
                                                <input type="text" value="{{ $user->name }}" id="name" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="Email">Email</label>
                                                <input type="email" value="{{ $user->email }}" id="Email" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="Password">{{ __('auth.Password') }}</label>
                                                <input type="password" placeholder="6 - 15 Characters" id="Password" name="password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="RePassword">{{ __('auth.Re-Password') }}</label>
                                                <input type="password" placeholder="6 - 15 Characters" id="RePassword" name="repassword" class="form-control">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" id="submitButton"><i class="ri-save-line me-1 fs-16 lh-1"></i> {{ __('auth.Save') }}</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Profile Demo App js -->
    <script src="assets/js/pages/profile.init.js"></script>

    <script>
        $(document).ready(function () {
            $('#profileForm').submit(function (e) {
                var password = $('#Password').val();
                var repassword = $('#RePassword').val();


                if (password !== repassword) {
                    e.preventDefault();
                    $('#Password').addClass('is-invalid');
                    $('#RePassword').addClass('is-invalid');
                } else {
                    $('#Password').removeClass('is-invalid');
                    $('#RePassword').removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection

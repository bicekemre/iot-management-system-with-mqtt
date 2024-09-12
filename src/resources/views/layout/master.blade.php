<!DOCTYPE html>
<html lang="en" data-layout="topnav" data-topbar-color="dark" data-menu-color="light">

<head>
    <meta charset="utf-8" />
    <title>Horizontal Layout | Velonic - Bootstrap 5 Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">



    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    @yield('head')

</head>

<body>
<!-- Begin page -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    <div class="navbar-custom">
        <div class="topbar container-fluid">
            <div class="d-flex align-items-center gap-1">

                <!-- Topbar Brand Logo -->
                <div class="logo-topbar">
                    <!-- Logo light -->
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('logo.png') }}"  alt="logo">
                            </span>
                        <span class="logo-sm">
                                <img src="{{ asset('logo.png') }}" alt="small logo">
                            </span>
                    </a>

                    <!-- Logo Dark -->
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('logo.png') }}" alt="dark logo">
                            </span>
                        <span class="logo-sm">
                                <img src="{{ asset('logo.png') }}" alt="small logo">
                            </span>
                    </a>


                </div>
                <div class="topbar-menu d-flex justify-content-center">
                    <a href="tel: +90 216 484 2222" class="mx-3 d-flex align-items-center">
                        <i class="ri-phone-fill me-2"></i>+90 216 484 2222
                    </a>

                    <a href="mailto: info@canovate.com" class="mx-3 d-flex align-items-center">
                        <i class="ri-mail-line me-2"></i>info@canovate.com
                    </a>

                    <a href="#" class="mx-3 d-flex align-items-center">
                        <i class="ri-home-2-fill me-2"></i><strong>Headquarters: </strong>
                        İstanbul-TÜRKİYE
                    </a>
                </div>
                <!-- Sidebar Menu Toggle Button -->
                <button class="button-toggle-menu">
                    <i class="ri-phone-fill"></i>
                </button>

                <!-- Horizontal Menu Toggle Button -->
                <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>


            </div>

            <ul class="topbar-menu d-flex align-items-center gap-3">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <span class="align-middle d-none d-lg-inline-block">{{ strtoupper(app()->getLocale())   }}</span>
                        <i class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                        <a href="{{ route(request()->route()->getName(), ['locale' => 'en',]) }}" class="dropdown-item">
                            <span class="align-middle">{{ __('EN') }}</span>
                        </a>

                        <a href="{{ route(request()->route()->getName(), ['locale' => 'tr',]) }}" class="dropdown-item">
                            <span class="align-middle">{{ __('TR') }}</span>
                        </a>

                    </div>
                </li>


                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        <i class="ri-notification-3-line fs-22"></i>
                        <span class="noti-icon-badge badge text-bg-pink">{{ $notifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                        <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> {{ __('layout.Notification') }}</h6>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('clear.notifies') }}" class="text-dark text-decoration-underline">
                                        <small>{{ __('layout.Clear All') }}</small>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div style="max-height: 300px;" data-simplebar>
                            @foreach($notifications->take(5) as $notification)
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary-subtle">
                                    <i class="mdi mdi-comment-account-outline text-primary"></i>
                                </div>
                                <p class="notify-details">{{ $notification->data }}
                                    <small class="noti-time">{{ $notification->created_at }}</small>
                                </p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </li>


                <li class="d-none d-sm-inline-block">
                    <div class="nav-link" id="light-dark-mode">
                        <i class="ri-moon-line fs-22"></i>
                    </div>
                </li>

                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="user-image" width="32" class="rounded-circle">
                            </span>
                        <span class="d-lg-block d-none">
                                <h5 class="my-0 fw-normal">{{ auth()->user()->name ?? '' }} <i
                                        class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                            </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">{{ __('layout.Welcome') }} !</h6>
                        </div>

                        <!-- item-->
                        <a href="{{ route('profile', ['locale' => app()->getLocale()]) }}" class="dropdown-item">
                            <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                            <span>{{ __('layout.My Account') }}</span>
                        </a>

{{--                        <!-- item-->--}}
{{--                        <a href="pages-profile.html" class="dropdown-item">--}}
{{--                            <i class="ri-settings-4-line fs-18 align-middle me-1"></i>--}}
{{--                            <span>Settings</span>--}}
{{--                        </a>--}}

                        <!-- item-->
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                            <span>{{ __('layout.Logout') }}</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- ========== Topbar End ========== -->

    <!-- ========== Horizontal Menu Start ========== -->
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="/{{  app()->getLocale() }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-dashboard-3-line"></i>{{ __('layout.Dashboard') }}
                            </a>
                        </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('users', ['locale' => app()->getLocale()]) }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-user-fill">{{ __('layout.Users') }}</i>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('roles', ['locale' => app()->getLocale()]) }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ __('layout.Roles') }}
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('organizations', ['locale' => app()->getLocale()]) }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ __('layout.Organizations') }}
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('devices', ['locale' => app()->getLocale()]) }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ __('layout.Devices') }}
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('types', ['locale' => app()->getLocale()]) }}" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ __('layout.Device Type') }}
                                </a>
                            </li>

                    </ul>


                </div>
                <div>
                    @if(Cookie::get('organization_id'))
                        {{ \App\Models\Organization::query()->findOrFail(Cookie::get('organization_id'))->name }}
                        <button type="button" class="btn btn-link p-0" onclick="removeCookie()">  <i class="bi bi-x-circle"></i></button>
                    @else
                        <select id="organization" onchange="setCookie()" name="organization" class="form-control">
                            <option value="NULL">{{ __('users.Select Organization') }}</option>
                            @foreach(\App\Models\Organization::all() as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </nav>
        </div>
    </div>
    <!-- ========== Horizontal Menu End ========== -->
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                            <h4 class="page-title">@yield('title')</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @yield('content')

                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>document.write(new Date().getFullYear())</script> ©  <b>Canovate</b>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Theme Settings -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
    <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
        <h5 class="text-white m-0">Theme Settings</h5>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="p-3">
                <h5 class="mb-3 fs-16 fw-bold">Color Scheme</h5>

                <div class="row">
                    <div class="col-4">
                        <div class="form-check form-switch card-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-light" value="light">
                            <label class="form-check-label" for="layout-color-light">
                                <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check form-switch card-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="data-bs-theme" id="layout-color-dark" value="dark">
                            <label class="form-check-label" for="layout-color-dark">
                                <img src="assets/images/layouts/dark.png" alt="" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                    </div>
                </div>

                <div id="layout-width">
                    <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-fluid" value="fluid">
                                <label class="form-check-label" for="layout-mode-fluid">
                                    <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Fluid</h5>
                        </div>

                        <div class="col-4">
                            <div id="layout-boxed">
                                <div class="form-check form-switch card-switch mb-1">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode" id="layout-mode-boxed" value="boxed">
                                    <label class="form-check-label" for="layout-mode-boxed">
                                        <img src="assets/images/layouts/boxed.png" alt="" class="img-fluid">
                                    </label>
                                </div>
                                <h5 class="font-14 text-center text-muted mt-2">Boxed</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                <div class="row">
                    <div class="col-4">
                        <div class="form-check form-switch card-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-light" value="light">
                            <label class="form-check-label" for="topbar-color-light">
                                <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check form-switch card-switch mb-1">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color" id="topbar-color-dark" value="dark">
                            <label class="form-check-label" for="topbar-color-dark">
                                <img src="assets/images/layouts/topbar-dark.png" alt="" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                    </div>
                </div>

                <div>
                    <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-light" value="light">
                                <label class="form-check-label" for="leftbar-color-light">
                                    <img src="assets/images/layouts/sidebar-light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-menu-color" id="leftbar-color-dark" value="dark">
                                <label class="form-check-label" for="leftbar-color-dark">
                                    <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>
                </div>

                <div id="sidebar-size">
                    <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-default" value="default">
                                <label class="form-check-label" for="leftbar-size-default">
                                    <img src="assets/images/layouts/light.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Default</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-compact" value="compact">
                                <label class="form-check-label" for="leftbar-size-compact">
                                    <img src="assets/images/layouts/compact.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Compact</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-small" value="condensed">
                                <label class="form-check-label" for="leftbar-size-small">
                                    <img src="assets/images/layouts/sm.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Condensed</h5>
                        </div>


                        <div class="col-4">
                            <div class="form-check form-switch card-switch mb-1">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size" id="leftbar-size-full" value="full">
                                <label class="form-check-label" for="leftbar-size-full">
                                    <img src="assets/images/layouts/full.png" alt="" class="img-fluid">
                                </label>
                            </div>
                            <h5 class="font-14 text-center text-muted mt-2">Full Layout</h5>
                        </div>
                    </div>
                </div>

                <div id="layout-position">
                    <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                    <div class="btn-group checkbox" role="group">
                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed">
                        <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                        <label class="btn btn-soft-primary w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
            </div>
            <div class="col-6">
                <a href="https://1.envato.market/velonic" target="_blank" role="button" class="btn btn-primary w-100">Buy Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"> </script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Daterangepicker js -->
<script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

<!-- Apex Charts js -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector Map js -->
<script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- Dashboard App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
@yield('script')
<script>
    function removeCookie()
    {
        $.ajax({
            url: '/organization/removecookie',
            method: 'post',
            success: function (  ){
                window.location.reload();
            }
        });
    }
    function setCookie()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var organization = $('#organization').val();

        $.ajax({
            url: '/organization/setcookie',
            method: 'post',
            data: {organization: organization },
            success: function (data){
                window.location.reload();
                console.log(data);
            }
        });
    }



    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>


</body>
</html>

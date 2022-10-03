<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/ionicons/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/typicons/src/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('icons/favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    @yield('css')
    <!-- End-CSS -->

</head>

<body>
    <div class="container-scroller">
        <!-- TopNav -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo" href="{{ url('/dashboard') }}">
                    <img src="{{ asset('icons/1.png') }}" alt="logo" /> </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <img class="img-xs rounded-circle" src="{{ asset('pictures/' . auth()->user()->foto) }}"
                                alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="{{ asset('pictures/' . auth()->user()->foto) }}"
                                    alt="Profile image">
                                <p class="mb-1 mt-3 font-weight-semibold">{{ auth()->user()->nama }}</p>
                                <p class="font-weight-light text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                            <!-- <a href="{{ url('/profile') }}" class="dropdown-item">Profil</a> -->
                            <a href="{{ url('/logout') }}" class="dropdown-item">Sign Out</a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- End-TopNav -->

        <div class="container-fluid page-body-wrapper">
            <!-- SideNav -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#kelola_barang" aria-expanded="false"
                            aria-controls="kelola_barang">
                            <span class="menu-title">Data Master</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="kelola_barang">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/product') }}">Data Item</a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/transaction') }}">
                            <span class="menu-title">Transaksi</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#kelola_laporan" aria-expanded="false"
                            aria-controls="kelola_laporan">
                            <span class="menu-title">Kelola Laporan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="kelola_laporan">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/report/transaction') }}">Laporan Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logout') }}">
                            <span class="menu-title">Sign Out</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End-SideNav -->

            <div class="main-panel">

                <div class="content-wrapper" id="content-web-page">
                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('assets/js/shared/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/shared/misc.js') }}"></script>
    <script src="{{ asset('plugins/js/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('plugins/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/templates/script.js') }}"></script>
    <script type="text/javascript">
    $(document).on('input', 'input[name=search_page]', function() {
        if ($(this).val() != '') {
            $('#content-web-page').prop('hidden', true);
            $('#content-web-search').prop('hidden', false);
            var search_word = $(this).val();
            $.ajax({
                url: "{{ url('/search') }}/" + search_word,
                method: "GET",
                success: function(response) {
                    $('.result-1').html(response.length + ' Hasil Pencarian');
                    $('.result-2').html('dari "' + search_word + '"');
                    var lengthLoop = response.length - 1;
                    var searchResultList = '';
                    for (var i = 0; i <= lengthLoop; i++) {
                        var page_url = "{{ url('/', ':id') }}";
                        page_url = page_url.replace('%3Aid', response[i].page_url);
                        searchResultList += '<a href="' + page_url +
                            '" class="page-result-child mb-4 w-100"><div class="col-12"><div class="card card-noborder b-radius"><div class="card-body"><div class="row"><div class="col-12"><h5 class="d-block page_url">' +
                            response[i].page_name +
                            '</h5><p class="align-items-center d-flex justify-content-start"><span class="icon-in-search mr-2"><i class="mdi mdi-chevron-double-right"></i></span> <span class="breadcrumbs-search page_url">' +
                            response[i].page_title +
                            '</span></p><div class="search-description"><p class="m-0 p-0 page_url">' +
                            response[i].page_content.substring(0, 500) +
                            '...</p></div></div></div></div></div></div></a>';
                    }
                    $('#page-result-parent').html(searchResultList);
                    $('.page_url:contains("' + search_word + '")').each(function() {
                        var regex = new RegExp(search_word, 'gi');
                        $(this).html($(this).text().replace(regex,
                            '<span style="background-color: #607df3;">' +
                            search_word + '</span>'));
                    });
                }
            });
        } else {
            $('#content-web-page').prop('hidden', false);
            $('#content-web-search').prop('hidden', true);
        }
    });
    </script>
    @yield('script')
    <!-- End-Javascript -->
</body>

</html>
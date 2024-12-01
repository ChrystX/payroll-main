<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <title>@yield('title')</title>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <h1>Payroll BCA</h1>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/crudperusahaan">
                            <i class="bi bi-building"></i> Perusahaan Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/divisi">
                            <i class="bi bi-diagram-2"></i> Divisi Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/workerdata">
                            <i class="bi bi-person"></i> Worker Data
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/paymentaccount">
                            <i class="bi bi-wallet2"></i> Payment Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transaction">
                            <i class="bi bi-currency-dollar"></i> Transaction
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logbook">
                            <i class="bi bi-journal-text"></i> Payment Logbook
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                            <i class="bi bi-person-plus"></i> Create New Admin
                        </a>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content">
            <!-- Header section with Dashboard title and user dropdown -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
                <h1>@yield('title')</h1>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> user
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item">{{ Auth::user()->name ?? 'Guest' }}</a>
                    </div>
                </div>
            </div>

            <!-- Content section where child templates can inject content -->
            <div class="main-content">
                @yield('content')
            </div>
        </main>

    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Plotly JS for chart -->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</body>
</html>

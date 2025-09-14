<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-hospital"></i>
                            Hospital
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}" href="{{ route('patients.index') }}">
                                        <i class="fas fa-users me-2"></i>
                                        Patients
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}" href="{{ route('doctors.index') }}">
                                        <i class="fas fa-user-md me-2"></i>
                                        Doctors
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Appointments
                                    </a>
                                </li>
                            @elseif(auth()->user()->isDoctor())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}" href="{{ route('doctor.appointments') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        My Appointments
                                    </a>
                                </li>
                            @elseif(auth()->user()->isPatient())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        My Appointments
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <div class="mt-auto pt-3">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>
                                {{ auth()->user()->name ?? 'User' }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ auth()->user()->isPatient() ? route('patient.logout') : route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @include('components.confirm-modal')
    
    <!-- Chat Widget -->
    @include('components.chat-widget')
    
    @yield('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-delete').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = btn.closest('form');
                const msg = btn.getAttribute('data-message') || 'Apakah Anda yakin ingin menghapus data ini?';
                window.confirmModal(msg, function() {
                    form.submit();
                });
            });
        });
    });
    </script>
</body>
</html>

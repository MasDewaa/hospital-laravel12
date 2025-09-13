<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
            <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .welcome-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }
        .btn-outline-primary:hover {
            background-color: #667eea;
            border-color: #667eea;
        }
            </style>
    </head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="welcome-card p-5">
                    <div class="text-center mb-5">
                        <h1 class="display-4 text-primary mb-3">
                            <i class="fas fa-hospital"></i>
                            Hospital Management System
                        </h1>
                        <p class="lead text-muted">Comprehensive healthcare management solution</p>
                    </div>

                    <div class="row">
                        <!-- Staff/Doctor Login -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-user-md fa-4x text-primary"></i>
                                    </div>
                                    <h4 class="card-title">Staff & Doctor Portal</h4>
                                    <p class="card-text text-muted">
                                        Access for hospital staff, administrators, and doctors.
                                    </p>
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Staff Login
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Login -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-4">
                                        <i class="fas fa-user-injured fa-4x text-success"></i>
                                    </div>
                                    <h4 class="card-title">Patient Portal</h4>
                                    <p class="card-text text-muted">
                                        Patients can view their appointments and medical history.
                                    </p>
                                    <a href="{{ route('patient.login') }}" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                        <i class="fas fa-sign-in-alt me-2"></i>Patient Login
                                    </a>
                                    <a href="{{ route('patient.register') }}" class="btn btn-outline-success btn-sm w-100">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>Demo Credentials
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Staff/Doctor:</h6>
                                    <ul class="list-unstyled">
                                        <li>admin@hospital.com / password</li>
                                        <li>john.smith@hospital.com / password</li>
                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success">Patient:</h6>
                                    <ul class="list-unstyled">
                                        <li>alice.johnson@email.com / password</li>
                                        <li>bob.smith@email.com / password</li>
                    </ul>
                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>

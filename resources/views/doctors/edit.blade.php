@extends('layouts.app')

@section('title', 'Edit Doctor')
@section('page-title', 'Edit Doctor Information')

@section('page-actions')
    <div class="btn-group" role="group">
        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-info">
            <i class="fas fa-eye me-2"></i>View Doctor
        </a>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Doctors
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Edit Doctor Information
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('doctors.update', $doctor) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>Doctor Name *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $doctor->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialization" class="form-label">
                                    <i class="fas fa-stethoscope me-1"></i>Specialization *
                                </label>
                                <input type="text" 
                                       class="form-control @error('specialization') is-invalid @enderror" 
                                       id="specialization" 
                                       name="specialization" 
                                       value="{{ old('specialization', $doctor->specialization) }}" 
                                       required>
                                @error('specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Phone Number *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $doctor->phone) }}" 
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Email Address *
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $doctor->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">
                                    <i class="fas fa-user-circle me-1"></i>User Account
                                </label>
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" 
                                        name="user_id">
                                    <option value="">Select User Account</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                                {{ old('user_id', $doctor->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Select the user account that this doctor will use to log in.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Doctor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Information
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>Important Notes
                    </h6>
                    <ul class="mb-0">
                        <li><strong>User Account:</strong> The doctor must have a user account with role 'doctor' to log in.</li>
                        <li><strong>Email:</strong> Must be unique and valid email address.</li>
                        <li><strong>Phone:</strong> Contact number for the doctor.</li>
                        <li><strong>Specialization:</strong> Medical field of expertise.</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>Warning
                    </h6>
                    <p class="mb-0">
                        Changing the user account will affect the doctor's login credentials. 
                        Make sure the selected user has the 'doctor' role.
                    </p>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Current Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $doctor->appointments->count() }}</h4>
                            <p class="text-muted mb-0">Total Appointments</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $doctor->appointments->where('status', 'completed')->count() }}</h4>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-warning">{{ $doctor->appointments->where('status', 'scheduled')->count() }}</h4>
                            <p class="text-muted mb-0">Scheduled</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-danger">{{ $doctor->appointments->where('status', 'cancelled')->count() }}</h4>
                        <p class="text-muted mb-0">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

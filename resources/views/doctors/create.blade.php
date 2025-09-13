@extends('layouts.app')

@section('title', 'Add New Doctor')
@section('page-title', 'Add New Doctor')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus me-2"></i>Doctor Registration Form
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('doctors.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Doctor Name *
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialization" class="form-label">
                                    <i class="fas fa-stethoscope me-2"></i>Specialization *
                                </label>
                                <select class="form-select @error('specialization') is-invalid @enderror" 
                                        id="specialization" name="specialization" required>
                                    <option value="">Select specialization...</option>
                                    <option value="General Medicine" {{ old('specialization') == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                                    <option value="Cardiology" {{ old('specialization') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                    <option value="Dermatology" {{ old('specialization') == 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                                    <option value="Neurology" {{ old('specialization') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                                    <option value="Orthopedics" {{ old('specialization') == 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                    <option value="Pediatrics" {{ old('specialization') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                    <option value="Psychiatry" {{ old('specialization') == 'Psychiatry' ? 'selected' : '' }}>Psychiatry</option>
                                    <option value="Radiology" {{ old('specialization') == 'Radiology' ? 'selected' : '' }}>Radiology</option>
                                    <option value="Surgery" {{ old('specialization') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                                </select>
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
                                    <i class="fas fa-phone me-2"></i>Phone Number *
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address *
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">
                            <i class="fas fa-user-circle me-2"></i>Link to User Account *
                        </label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id" required>
                            <option value="">Select user account...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Select the user account that this doctor will use to log in.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Doctors
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Add Doctor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Information
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    <strong>User Account:</strong> The doctor must have a user account with role 'doctor' to log in.
                </p>
                <p class="text-muted">
                    <strong>Specialization:</strong> Choose from the available medical specializations.
                </p>
                <p class="text-muted">
                    <strong>Contact Info:</strong> Phone and email are required for communication.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

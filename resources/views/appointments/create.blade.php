@extends('layouts.app')

@section('title', 'Schedule Appointment')
@section('page-title', 'Schedule New Appointment')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-plus me-2"></i>Appointment Scheduling Form
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">
                                    <i class="fas fa-user me-2"></i>Select Patient *
                                </label>
                                <select class="form-select @error('patient_id') is-invalid @enderror" 
                                        id="patient_id" name="patient_id" required>
                                    <option value="">Choose a patient...</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" 
                                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->patient_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">
                                    <i class="fas fa-user-md me-2"></i>Select Doctor *
                                </label>
                                <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                        id="doctor_id" name="doctor_id" required>
                                    <option value="">Choose a doctor...</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" 
                                                {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }} - {{ $doctor->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Appointment Date *
                                </label>
                                <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                       id="appointment_date" name="appointment_date" 
                                       value="{{ old('appointment_date') }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">
                                    <i class="fas fa-clock me-2"></i>Appointment Time *
                                </label>
                                <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" 
                                       id="appointment_time" name="appointment_time" 
                                       value="{{ old('appointment_time') }}" required>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="fas fa-sticky-note me-2"></i>Notes
                        </label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optional notes about the appointment.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Appointments
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-2"></i>Schedule Appointment
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
                    <i class="fas fa-info-circle me-2"></i>Scheduling Guidelines
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Select a patient from the registered patients list
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Choose an available doctor and specialization
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Pick a date (today or future dates only)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Select an appropriate time slot
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Add any relevant notes (optional)
                    </li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <small>
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tip:</strong> The system will automatically check for scheduling conflicts.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

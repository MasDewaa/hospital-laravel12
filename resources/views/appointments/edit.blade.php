@extends('layouts.app')

@section('title', 'Edit Appointment')
@section('page-title', 'Edit Appointment')

@section('page-actions')
    <div class="btn-group" role="group">
        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info">
            <i class="fas fa-eye me-2"></i>View Appointment
        </a>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Appointments
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Edit Appointment
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.update', $appointment) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">
                                    <i class="fas fa-user me-1"></i>Patient *
                                </label>
                                <select class="form-select @error('patient_id') is-invalid @enderror" 
                                        id="patient_id" 
                                        name="patient_id" 
                                        required>
                                    <option value="">Select Patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" 
                                                {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
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
                                    <i class="fas fa-user-md me-1"></i>Doctor *
                                </label>
                                <select class="form-select @error('doctor_id') is-invalid @enderror" 
                                        id="doctor_id" 
                                        name="doctor_id" 
                                        required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" 
                                                {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                                    <i class="fas fa-calendar me-1"></i>Appointment Date *
                                </label>
                                <input type="date" 
                                       class="form-control @error('appointment_date') is-invalid @enderror" 
                                       id="appointment_date" 
                                       name="appointment_date" 
                                       value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}" 
                                       required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Appointment Time *
                                </label>
                                <input type="time" 
                                       class="form-control @error('appointment_time') is-invalid @enderror" 
                                       id="appointment_time" 
                                       name="appointment_time" 
                                       value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" 
                                       required>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Status *
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>
                                        Scheduled
                                    </option>
                                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check me-1"></i>Current Appointment
                                </label>
                                <div class="form-control-plaintext bg-light p-2 rounded">
                                    <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong> at 
                                    <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i>Notes
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="4" 
                                          placeholder="Add any additional notes about this appointment...">{{ old('notes', $appointment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Current Appointment Info -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Current Information
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Patient:</label>
                    <p class="form-control-plaintext">{{ $appointment->patient->name }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Doctor:</label>
                    <p class="form-control-plaintext">{{ $appointment->doctor->name }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Date & Time:</label>
                    <p class="form-control-plaintext">
                        {{ $appointment->appointment_date->format('M d, Y') }} at 
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p class="form-control-plaintext">
                        <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->status === 'scheduled')
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                            <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                            <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}">
                            <input type="hidden" name="appointment_time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}">
                            <input type="hidden" name="status" value="completed">
                            <input type="hidden" name="notes" value="{{ $appointment->notes }}">
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Mark this appointment as completed?')">
                                <i class="fas fa-check me-2"></i>Mark as Completed
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                            <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                            <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}">
                            <input type="hidden" name="appointment_time" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}">
                            <input type="hidden" name="status" value="cancelled">
                            <input type="hidden" name="notes" value="{{ $appointment->notes }}">
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Cancel this appointment?')">
                                <i class="fas fa-times me-2"></i>Cancel Appointment
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Patient History -->
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Patient History
                </h6>
            </div>
            <div class="card-body">
                @php
                    $patientAppointments = \App\Models\Appointment::where('patient_id', $appointment->patient_id)
                        ->where('id', '!=', $appointment->id)
                        ->orderBy('appointment_date', 'desc')
                        ->take(5)
                        ->get();
                @endphp
                
                @if($patientAppointments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($patientAppointments as $history)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $history->doctor->name }}</h6>
                                    <small class="text-muted">
                                        {{ $history->appointment_date->format('M d, Y') }} at 
                                        {{ \Carbon\Carbon::parse($history->appointment_time)->format('H:i') }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $history->status === 'scheduled' ? 'primary' : ($history->status === 'completed' ? 'success' : 'danger') }}">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No previous appointments</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Auto-update time slots based on selected date
document.getElementById('appointment_date').addEventListener('change', function() {
    const selectedDate = this.value;
    const today = new Date().toISOString().split('T')[0];
    
    if (selectedDate === today) {
        // If today is selected, set minimum time to current time + 1 hour
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const minTime = now.toTimeString().slice(0, 5);
        document.getElementById('appointment_time').min = minTime;
    } else {
        // For future dates, allow any time
        document.getElementById('appointment_time').min = '08:00';
    }
});
</script>
@endsection

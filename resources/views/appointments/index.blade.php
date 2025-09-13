@extends('layouts.app')

@section('title', 'Appointments')
@section('page-title', 'Appointment Management')

@section('page-actions')
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Schedule Appointment
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>All Appointments
                </h6>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('appointments.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="doctor_id" class="form-label">Filter by Doctor</label>
                            <select class="form-select" name="doctor_id" id="doctor_id">
                                <option value="">All Doctors</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" 
                                            {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $doctor->specialization }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="date" class="form-label">Filter by Date</label>
                            <input type="date" class="form-control" name="date" id="date" 
                                   value="{{ request('date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                @if($appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Patient</th>
                                    <th>Patient ID</th>
                                    <th>Doctor</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td><span class="badge bg-secondary">{{ $appointment->patient->patient_id }}</span></td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->doctor->specialization }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('appointments.show', $appointment) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('appointments.edit', $appointment) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $appointments->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No appointments found</h5>
                        <p class="text-muted">
                            @if(request('doctor_id') || request('date'))
                                No appointments match your filter criteria.
                            @else
                                Start by scheduling your first appointment.
                            @endif
                        </p>
                        @if(!request('doctor_id') && !request('date'))
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Schedule First Appointment
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

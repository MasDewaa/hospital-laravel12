@extends('layouts.app')

@section('title', 'Patient Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-injured me-2"></i>Welcome, {{ $patient->name }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Patient ID:</strong> <span class="badge bg-primary">{{ $patient->patient_id }}</span></p>
                        <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth->format('M d, Y') }}</p>
                        <p><strong>Age:</strong> {{ $patient->date_of_birth->age }} years old</p>
                        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $patient->email }}</p>
                        <p><strong>Today's Appointments:</strong> {{ $todayAppointments->count() }}</p>
                        <p><strong>Upcoming Appointments:</strong> {{ $upcomingAppointments->count() }}</p>
                        <p><strong>Address:</strong> {{ $patient->address }}</p>
                    </div>
                </div>
                
                @if($patient->medical_history)
                    <div class="mt-3">
                        <h6><i class="fas fa-file-medical me-2"></i>Medical History</h6>
                        <p class="text-muted">{{ $patient->medical_history }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Appointments -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-day me-2"></i>Today's Appointments
                </h6>
            </div>
            <div class="card-body">
                @if($todayAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->doctor->specialization }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No appointments scheduled for today.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Appointments
                </h6>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Specialization</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->doctor->specialization }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No upcoming appointments.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Past Appointments -->
@if($pastAppointments->count() > 0)
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Recent Appointments
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->doctor->specialization }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : ($appointment->status === 'completed' ? 'success' : 'danger') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $appointment->notes ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.text-primary {
    color: #4e73df !important;
}
</style>
@endsection

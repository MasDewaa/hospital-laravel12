@extends('layouts.app')

@section('title', 'Doctor Dashboard')
@section('page-title', 'Doctor Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md me-2"></i>Welcome, {{ $doctor->name }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                        <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Today's Appointments:</strong> {{ $todayAppointments->count() }}</p>
                        <p><strong>Upcoming Appointments:</strong> {{ $upcomingAppointments->count() }}</p>
                    </div>
                </div>
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
                                    <th>Patient</th>
                                    <th>Patient ID</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td>{{ $appointment->patient->patient_id }}</td>
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
                                    <th>Patient</th>
                                    <th>Patient ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td>{{ $appointment->patient->patient_id }}</td>
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

<style>
.text-primary {
    color: #4e73df !important;
}
</style>
@endsection

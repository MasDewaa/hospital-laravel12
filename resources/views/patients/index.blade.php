@extends('layouts.app')

@section('title', 'Patients')
@section('page-title', 'Patient Management')

@section('page-actions')
    <a href="{{ route('patients.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Patient
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users me-2"></i>All Patients
                </h6>
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <form method="GET" action="{{ route('patients.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search by name, patient ID, or phone...">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                @if($patients->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td><span class="badge bg-primary">{{ $patient->patient_id }}</span></td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->date_of_birth->format('M d, Y') }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->email ?? 'N/A' }}</td>
                                        <td>{{ $patient->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('patients.show', $patient) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('patients.edit', $patient) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-message="Apakah Anda yakin ingin menghapus pasien ini?">
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
                        {{ $patients->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No patients found</h5>
                        <p class="text-muted">
                            @if(request('search'))
                                No patients match your search criteria.
                            @else
                                Start by adding your first patient.
                            @endif
                        </p>
                        @if(!request('search'))
                            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Patient
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

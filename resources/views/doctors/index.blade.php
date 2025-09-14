@extends('layouts.app')

@section('title', 'Doctors')
@section('page-title', 'Doctor Management')

@section('page-actions')
    <a href="{{ route('doctors.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Doctor
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-md me-2"></i>All Doctors
                </h6>
            </div>
            <div class="card-body">
                @if($doctors->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>User Account</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{ $doctor->name }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $doctor->specialization }}</span>
                                        </td>
                                        <td>{{ $doctor->phone }}</td>
                                        <td>{{ $doctor->email }}</td>
                                        <td>
                                            @if($doctor->user)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>No Account
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('doctors.show', $doctor) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('doctors.edit', $doctor) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('doctors.destroy', $doctor) }}" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-message="Apakah Anda yakin ingin menghapus dokter ini?">
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
                        {{ $doctors->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No doctors found</h5>
                        <p class="text-muted">Start by adding your first doctor.</p>
                        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Doctor
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

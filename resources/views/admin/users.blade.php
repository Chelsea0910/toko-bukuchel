@extends('layouts.app')

@section('title', 'Kelola User - Admin Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelola User</li>
            </ol>
        </nav> -->
        <h2 class="fw-bold"><i class="fas fa-users me-2"></i>Kelola User</h2>
        <p class="text-muted">Kelola data pengguna dan administrator sistem</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-pastel-purple shadow h-100 py-2" style="border-left: 4px solid #b19cd9;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-pastel-purple text-uppercase mb-1">
                            Total User
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-pastel-purple"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-pastel-pink shadow h-100 py-2" style="border-left: 4px solid #ffafcc;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-pastel-pink text-uppercase mb-1">
                            Administrator
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-pastel-pink"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-pastel-blue shadow h-100 py-2" style="border-left: 4px solid #a2d2ff;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-pastel-blue text-uppercase mb-1">
                            User Biasa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'user')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-pastel-blue"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-pastel-lavender shadow h-100 py-2" style="border-left: 4px solid #cdb4db;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-pastel-lavender text-uppercase mb-1">
                            User Baru (Bulan Ini)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('created_at', '>=', now()->subMonth())->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-pastel-lavender"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #b19cd9 0%, #cdb4db 100%);">
                <h5 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-list me-2"></i>Daftar User
                </h5>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-white" style="background: linear-gradient(135deg, #ffafcc 0%, #ffc8dd 100%);">
                                <tr>
                                    <th width="50px">#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background: linear-gradient(45deg, #b19cd9, #ffafcc);">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->id == auth()->id())
                                                    <span class="badge bg-pastel-blue ms-1">Anda</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role == 'admin' ? 'bg-pastel-pink' : 'bg-pastel-blue' }}">
                                            <i class="fas fa-{{ $user->role == 'admin' ? 'user-shield' : 'user' }} me-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada user terdaftar</h5>
                        <p class="text-muted">User akan muncul di sini setelah mendaftar di sistem</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Card -->

    
    
</div>
@endsection

@section('styles')
<style>
:root {
    --pastel-purple: #b19cd9;
    --pastel-pink: #ffafcc;
    --pastel-blue: #a2d2ff;
    --pastel-lavender: #cdb4db;
    --pastel-light-purple: #dfb8e6;
    --pastel-light-pink: #ffc8dd;
    --pastel-light-blue: #bde0fe;
}

.text-pastel-purple { color: var(--pastel-purple); }
.text-pastel-pink { color: var(--pastel-pink); }
.text-pastel-blue { color: var(--pastel-blue); }
.text-pastel-lavender { color: var(--pastel-lavender); }

.bg-pastel-purple { background-color: var(--pastel-purple); }
.bg-pastel-pink { background-color: var(--pastel-pink); }
.bg-pastel-blue { background-color: var(--pastel-blue); }
.bg-pastel-lavender { background-color: var(--pastel-lavender); }

.btn-pastel-purple {
    background: linear-gradient(45deg, var(--pastel-purple), var(--pastel-lavender));
    border: none;
    color: white;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-pastel-pink {
    background: linear-gradient(45deg, var(--pastel-pink), var(--pastel-light-pink));
    border: none;
    color: white;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-pastel-blue {
    background: linear-gradient(45deg, var(--pastel-blue), var(--pastel-light-blue));
    border: none;
    color: #333;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-pastel-info {
    background: linear-gradient(45deg, #a2d2ff, #bde0fe);
    border: none;
    color: #333;
    border-radius: 5px;
    padding: 5px 10px;
}

.btn-pastel-warning {
    background: linear-gradient(45deg, #ffafcc, #ffc8dd);
    border: none;
    color: #333;
    border-radius: 5px;
    padding: 5px 10px;
}

.btn-pastel-danger {
    background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
    border: none;
    color: white;
    border-radius: 5px;
    padding: 5px 10px;
}

.card {
    border: none;
    border-radius: 15px;
}

.table-hover tbody tr:hover {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    transform: translateY(-1px);
    transition: all 0.3s ease;
}

.badge {
    border-radius: 10px;
    padding: 6px 12px;
    font-weight: 600;
}

.bg-pastel-blue {
    background: linear-gradient(45deg, var(--pastel-blue), var(--pastel-light-blue)) !important;
    color: #333;
}

.bg-pastel-pink {
    background: linear-gradient(45deg, var(--pastel-pink), var(--pastel-light-pink)) !important;
    color: #333;
}
</style>
@endsection

@section('scripts')
<script>
function confirmDelete(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\nTindakan ini tidak dapat dibatalkan.`)) {
        // Implement delete functionality here
        alert(`User ${userName} akan dihapus (ID: ${userId})`);
        // You can add AJAX delete request here
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection
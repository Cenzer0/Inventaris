@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
            Manajemen Pengguna
        </h4>
        <p class="text-muted small mb-0">Kelola akun pengguna dan peran sistem</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('users.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pengguna
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.875rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">NAMA</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">USERNAME</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">PERAN</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem;letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3 fw-medium">{{ $user->name }}</td>
                        <td class="py-3 text-muted">{{ $user->username }}</td>
                        <td class="py-3">
                            @if($user->role === 'superadmin')
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(239,68,68,0.1);color:#dc2626">Superadmin</span>
                            @elseif($user->role === 'admin_gudang')
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(15,59,115,0.1);color:#0f3b73">Admin Gudang</span>
                            @elseif($user->role === 'pimpinan')
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,0.1);color:#059669">Pimpinan</span>
                            @else
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(100,116,139,0.1);color:#64748b">User Biasa</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-light rounded-2 text-primary me-1" title="Edit" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                <svg style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            </a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-2 text-danger" title="Hapus" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <svg style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <svg class="text-muted opacity-25 mb-3" style="width:48px;height:48px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                            <p class="text-muted mb-0">Belum ada data pengguna.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

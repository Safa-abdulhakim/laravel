@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users Management')
@section('content')
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-auto"><button type="submit" class="btn btn-primary btn-sm px-3">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a></div>@endif
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-4">User</th><th>Role</th><th>Verified</th><th>Joined</th><th class="pe-4">Actions</th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px;font-size:.85rem;background:#6366f1!important;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <div>
                                        <div class="fw-semibold small">{{ $user->name }}</div>
                                        <div class="text-muted" style="font-size:.78rem;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge {{ $user->isAdmin() ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">{{ $user->role }}</span></td>
                            <td>
                                @if($user->email_verified_at)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle text-muted"></i>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                    @if(!$user->isAdmin() || auth()->user()->id != $user->id)
                                        <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-outline-warning" title="{{ $user->isAdmin() ? 'Make User' : 'Make Admin' }}">
                                                <i class="bi bi-{{ $user->isAdmin() ? 'person-x' : 'shield-check' }}"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if(!$user->isAdmin())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $users->links() }}</div>
</div>
@endsection

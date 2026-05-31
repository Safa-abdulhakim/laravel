@extends('layouts.admin')
@section('title', 'Learning Resources')
@section('page-title', 'Learning Resources')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.resources.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>New Resource</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-4">Resource</th><th>Type</th><th>Skill</th><th>Provider</th><th class="pe-4">Actions</th></tr></thead>
                <tbody>
                    @forelse($resources as $res)
                        <tr>
                            <td class="ps-4 py-3"><div class="fw-semibold small">{{ $res->title }}</div></td>
                            <td><span class="badge bg-{{ $res->type_color }}-subtle text-{{ $res->type_color }}"><i class="{{ $res->type_icon }} me-1"></i>{{ $res->type }}</span></td>
                            <td><small class="text-muted">{{ $res->skill->title }}</small></td>
                            <td><small class="text-muted">{{ $res->provider ?? '-' }}</small></td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ $res->url }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-box-arrow-up-right"></i></a>
                                    <a href="{{ route('admin.resources.edit', $res) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.resources.destroy', $res) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No resources yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $resources->links() }}</div>
</div>
@endsection

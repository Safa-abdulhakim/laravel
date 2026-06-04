@extends('layouts.dashboard')
@section('title', __('dashboard.manage_certificates'))
@section('page-title', __('dashboard.manage_certificates'))
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.certificates.create') }}" class="btn-primary"><i class="fas fa-plus"></i> {{ __('dashboard.add_new') }}</a>
</div>
<div class="admin-card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Certificate</th>
                <th>{{ __('dashboard.issuer') }}</th>
                <th>{{ __('dashboard.issue_date') }}</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificates as $cert)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        @if($cert->image)
                        <img src="{{ Storage::url($cert->image) }}" class="w-12 h-12 rounded-xl object-cover">
                        @else
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                            <i class="fas fa-certificate text-white"></i>
                        </div>
                        @endif
                        <div>
                            <div class="font-semibold" style="color: var(--color-heading);">{{ $cert->title }}</div>
                            @if($cert->title_ar)<div class="text-xs" style="color: var(--color-muted);">{{ $cert->title_ar }}</div>@endif
                        </div>
                    </div>
                </td>
                <td style="color: var(--color-body);">{{ $cert->issuer }}</td>
                <td class="text-sm" style="color: var(--color-muted);">{{ $cert->issue_date->format('M d, Y') }}</td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.certificates.edit', $cert) }}" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);"><i class="fas fa-edit"></i> {{ __('dashboard.edit') }}</a>
                        <form method="POST" action="{{ route('admin.certificates.destroy', $cert) }}" x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-12" style="color: var(--color-muted);">{{ __('dashboard.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

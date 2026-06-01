@extends('layouts.app')
@section('title', 'إضافة عميل')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <h4 class="fw-bold mb-0">إضافة عميل جديد <small class="text-muted fs-6 fw-normal">New Customer</small></h4>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-body p-4">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الاسم الكامل <span class="text-danger">*</span> <small class="text-muted">Full Name</small></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="اسم العميل">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">رقم الهاتف <small class="text-muted">Phone</small></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="+966-5xx-xxxxxxx">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">البريد الإلكتروني <small class="text-muted">Email</small></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="customer@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">العنوان <small class="text-muted">Address</small></label>
                        <textarea name="address" class="form-control" rows="3" placeholder="العنوان الكامل...">{{ old('address') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-check-lg me-1"></i>إنشاء العميل</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-light">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

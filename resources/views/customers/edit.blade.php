@extends('layouts.app')
@section('title', 'تعديل العميل')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <h4 class="fw-bold mb-0">تعديل العميل <small class="text-muted fs-6 fw-normal">Edit Customer</small></h4>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-body p-4">
                <form action="{{ route('customers.update', $customer) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">رقم الهاتف <small class="text-muted">Phone</small></label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">البريد الإلكتروني <small class="text-muted">Email</small></label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">العنوان <small class="text-muted">Address</small></label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-check-lg me-1"></i>تحديث البيانات</button>
                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-light">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Order #' . $order->id)
@section('page-title', 'Order #' . $order->id)
@section('page-subtitle', 'Placed on ' . $order->created_at->format('M d, Y H:i'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <span class="badge bg-{{ $order->status_badge }} fs-6">{{ ucfirst($order->status) }}</span>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
</div>

<div class="row g-4">
    <!-- Items -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3"><h5 class="mb-0 fw-bold">Order Items</h5></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Product</th><th class="text-center">Qty</th><th class="text-end">Unit Price</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                @if($item->product)
                                    <small class="text-muted">{{ $item->product->category }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->product_price, 2) }}</td>
                            <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr><td colspan="3" class="text-end fw-bold">Order Total</td><td class="text-end fw-bold text-primary fs-5">${{ number_format($order->total_amount, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Side Info -->
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-person me-2"></i>Customer Info</h6></div>
            <div class="card-body">
                <p class="mb-2"><span class="text-muted small">Name</span><br><strong>{{ $order->customer_name }}</strong></p>
                <p class="mb-2"><span class="text-muted small">Phone</span><br>{{ $order->customer_phone }}</p>
                <p class="mb-2"><span class="text-muted small">Address</span><br>{{ $order->customer_address }}</p>
                @if($order->notes)
                    <p class="mb-0"><span class="text-muted small">Notes</span><br>{{ $order->notes }}</p>
                @endif
                @if($order->user)
                    <hr>
                    <p class="mb-0 small text-muted"><i class="bi bi-person-circle me-1"></i>Account: {{ $order->user->email }}</p>
                @else
                    <hr>
                    <p class="mb-0 small text-muted"><i class="bi bi-person-x me-1"></i>Guest order</p>
                @endif
            </div>
        </div>

        <!-- Update Status -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3"><h6 class="mb-0 fw-bold"><i class="bi bi-arrow-repeat me-2"></i>Update Status</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach($statusList as $s)
                                <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check2 me-2"></i>Update Status
                    </button>
                </form>
                <hr>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                      onsubmit="return confirm('Permanently delete this order?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Delete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

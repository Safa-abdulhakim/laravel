@extends('layouts.app')
@section('title', __('app.new_sale'))

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i></a>
    <div>
        <h4 class="fw-bold mb-0">{{ __('app.new_sale') }}</h4>
        <p class="text-muted mb-0 small">{{ app()->getLocale()==='ar' ? 'إنشاء فاتورة بيع جديدة' : 'Create a new sales invoice' }}</p>
    </div>
</div>

<form action="{{ route('sales.store') }}" method="POST" id="saleForm">
    @csrf
    <div class="row g-3">
        {{-- Products --}}
        <div class="col-lg-8">
            <div class="card table-card mb-3">
                <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>{{ app()->getLocale()==='ar' ? 'المنتجات' : 'Products' }}</h6>
                    <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                        <i class="bi bi-plus me-1"></i>{{ __('app.add_item') }}
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0" id="itemsTable">
                        <thead>
                            <tr>
                                <th class="px-4">{{ __('app.product') }}</th>
                                <th style="width:110px;">{{ __('app.qty') }}</th>
                                <th style="width:130px;">{{ __('app.unit_price') }}</th>
                                <th style="width:130px;">{{ __('app.subtotal') }}</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-cart-plus fs-2 d-block mb-2 opacity-30"></i>
                                    {{ app()->getLocale()==='ar' ? 'اضغط "+ إضافة منتج" لإضافة المنتجات' : 'Click "+ Add Product" to add items' }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-semibold px-4">{{ __('app.subtotal') }}</td>
                                <td class="fw-semibold" id="subtotalDisplay">$0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">{{ app()->getLocale()==='ar' ? 'ملاحظات' : 'Notes' }}</h6></div>
                <div class="card-body">
                    <textarea name="notes" class="form-control" rows="2" placeholder="{{ app()->getLocale()==='ar' ? 'ملاحظات إضافية...' : 'Additional notes...' }}"></textarea>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="col-lg-4">
            <div class="card table-card mb-3">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">{{ app()->getLocale()==='ar' ? 'بيانات البيع' : 'Sale Details' }}</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.customer') }}</label>
                        <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                            <option value="">{{ __('app.optional_customer') }}</option>
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id')==$c->id || request('customer')==$c->id ? 'selected':'' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.payment_method') }} <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                            <option value="cash"          {{ old('payment_method','cash')==='cash'          ? 'selected':'' }}>💵 {{ __('app.cash') }}</option>
                            <option value="card"          {{ old('payment_method')==='card'                 ? 'selected':'' }}>💳 {{ __('app.card') }}</option>
                            <option value="bank_transfer" {{ old('payment_method')==='bank_transfer'        ? 'selected':'' }}>🏦 {{ __('app.bank_transfer') }}</option>
                            <option value="other"         {{ old('payment_method')==='other'                ? 'selected':'' }}>📦 {{ __('app.other') }}</option>
                        </select>
                        @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.discount') }} ($)</label>
                        <input type="number" name="discount" id="discountInput" value="{{ old('discount', 0) }}" class="form-control" step="0.01" min="0" placeholder="0.00">
                    </div>
                </div>
            </div>

            <div class="card table-card" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color:white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="opacity:0.8;">{{ __('app.subtotal') }}</span>
                        <span id="summarySubtotal" class="fw-semibold">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="opacity:0.8;">{{ __('app.discount') }}</span>
                        <span id="summaryDiscount" class="fw-semibold">-$0.00</span>
                    </div>
                    <hr style="border-color:rgba(255,255,255,0.3);">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-6">{{ __('app.total') }}</span>
                        <span id="summaryTotal" class="fw-bold fs-5">$0.00</span>
                    </div>
                    <button type="submit" class="btn w-100 mt-3 fw-bold" style="background:white;color:#4f46e5;" id="submitBtn" disabled>
                        <i class="bi bi-check-circle me-2"></i>{{ __('app.create_sale') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Product data for JS --}}
<script>
const products = @json($products->map(fn($p) => ['id'=>$p->id,'name'=>$p->name,'price'=>$p->price,'qty'=>$p->quantity,'sku'=>$p->sku]));
const lang = {
    select_product: '{{ __('app.select_product') }}',
    available: '{{ __('app.available') }}',
    add_item: '{{ __('app.add_item') }}',
};
</script>
@endsection

@push('scripts')
<script>
let itemIndex = 0;

function calcTotals() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        subtotal += parseFloat(row.querySelector('.line-subtotal').dataset.val || 0);
    });
    const discount = parseFloat(document.getElementById('discountInput').value) || 0;
    const total = Math.max(0, subtotal - discount);

    document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('summarySubtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('summaryDiscount').textContent = '-$' + discount.toFixed(2);
    document.getElementById('summaryTotal').textContent = '$' + total.toFixed(2);
    document.getElementById('submitBtn').disabled = document.querySelectorAll('.item-row').length === 0;
}

function addItem() {
    document.getElementById('emptyRow').remove();
    const idx = itemIndex++;
    const options = products.map(p =>
        `<option value="${p.id}" data-price="${p.price}" data-qty="${p.qty}">${p.name} (${lang.available}: ${p.qty})</option>`
    ).join('');

    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td class="px-4">
            <select name="items[${idx}][product_id]" class="form-select form-select-sm product-select" required onchange="updatePrice(this, ${idx})">
                <option value="">${lang.select_product}</option>
                ${options}
            </select>
        </td>
        <td>
            <input type="number" name="items[${idx}][quantity]" class="form-control form-control-sm qty-input" value="1" min="1" onchange="updateLineTotal(${idx})" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm price-input" id="price_${idx}" readonly placeholder="-">
        </td>
        <td>
            <span class="fw-semibold small line-subtotal" id="lineTotal_${idx}" data-val="0">$0.00</span>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-light text-danger" onclick="removeItem(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>`;
    document.getElementById('itemsBody').appendChild(row);
    calcTotals();
}

function updatePrice(select, idx) {
    const opt = select.options[select.selectedIndex];
    const price = parseFloat(opt.dataset.price) || 0;
    document.getElementById(`price_${idx}`).value = price > 0 ? '$' + price.toFixed(2) : '';
    updateLineTotal(idx);
}

function updateLineTotal(idx) {
    const row = document.querySelectorAll('.item-row')[idx] || document.querySelector(`.item-row:nth-child(${idx+1})`);
    // Find by matching elements
    const allRows = document.querySelectorAll('.item-row');
    allRows.forEach((r, i) => {
        const sel = r.querySelector('.product-select');
        const opt = sel?.options[sel.selectedIndex];
        const price = parseFloat(opt?.dataset?.price || 0);
        const qty = parseInt(r.querySelector('.qty-input')?.value || 0);
        const sub = price * qty;
        const span = r.querySelector('.line-subtotal');
        if (span) { span.textContent = '$' + sub.toFixed(2); span.dataset.val = sub; }
    });
    calcTotals();
}

function removeItem(btn) {
    btn.closest('tr').remove();
    if (document.querySelectorAll('.item-row').length === 0) {
        const empty = `<tr id="emptyRow"><td colspan="5" class="text-center py-5 text-muted">
            <i class="bi bi-cart-plus fs-2 d-block mb-2 opacity-30"></i>
            ${lang.add_item}
        </td></tr>`;
        document.getElementById('itemsBody').innerHTML = empty;
    }
    calcTotals();
}

document.getElementById('addItemBtn').addEventListener('click', addItem);
document.getElementById('discountInput').addEventListener('input', calcTotals);
</script>
@endpush

@extends('layouts.hostelWardenBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Inventory</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelWarden.inventory.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $inventory ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form
                            action="{{ $inventory ? route('hostelWarden.inventory.update', $inventory->slug) : route('hostelWarden.inventory.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($inventory)
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="block_id">
                                        <h6>Hostel Block</h6>
                                    </label>
                                    <select name="block_id" id="block_id"
                                        class="form-control @error('block_id') is-invalid @enderror">
                                        <option value="" disabled
                                            {{ old('block_id', $inventory->block_id ?? '') == '' ? 'selected' : '' }}>
                                            Please Choose One</option>

                                        @foreach ($blocks as $block)
                                            <option value="{{ $block->id }}"
                                                {{ old('block_id', $inventory->block_id ?? '') == $block->id ? 'selected' : '' }}>
                                                {{ $block->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('block_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="type">
                                        <h6>Transaction Type</h6>
                                    </label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type"
                                        name="type">
                                        <option value="" disabled selected>
                                            -- Please select --
                                        </option>
                                        <option
                                            value="Buy"{{ old('type', $inventory->type ?? '') == 'Buy' ? 'selected' : '' }}>
                                            Buy
                                        </option>
                                        <option
                                            value="Sell"{{ old('type', $inventory->type ?? '') == 'Sell' ? 'selected' : '' }}>
                                            Sell
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group" id="billNumberWrapper">
                                    <label for="bill_number">
                                        <h6>Bill Number</h6>
                                    </label>
                                    <input class="form-control @error('bill_number') is-invalid @enderror" id="bill_number"
                                        name="bill_number" type="number" placeholder="Enter number"
                                        value="{{ old('bill_number', $inventory->bill_number ?? '') }}" />
                                    @error('bill_number')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <h5 class="text-center mt-5">ITEMS</h5>
                            <div class="separator-breadcrumb border-top"></div>
                            <div id="itemContainer">
                                @if (isset($inventory->items))
                                    @if (old('item'))
                                        @foreach (old('item') as $key => $item)
                                            <div class="inventory-item">
                                                <div class="row">
                                                    <input type="hidden" name="item[{{ $key }}][id]"
                                                        value="{{ $item['id'] ?? '' }}" />

                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="item_name">
                                                            <h6>Item Name</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $key . '.item_name') is-invalid @enderror"
                                                            id="item_name" name="item[{{ $key }}][item_name]"
                                                            type="text" placeholder="Enter name"
                                                            value="{{ $item['item_name'] ?? '' }}" />
                                                        @error('item.' . $key . '.item_name')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3">
                                                        <label for="quantity">
                                                            <h6>Quantity</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $key . '.quantity') is-invalid @enderror"
                                                            id="quantity" name="item[{{ $key }}][quantity]"
                                                            type="number" placeholder="Enter name"
                                                            value="{{ $item['quantity'] ?? '' }}" />
                                                        @error('item.' . $key . '.quantity')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="unit_price">
                                                            <h6>Unit Price</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $key . '.unit_price') is-invalid @enderror"
                                                            id="unit_price" name="item[{{ $key }}][unit_price]"
                                                            type="number" placeholder="Enter name"
                                                            value="{{ $item['unit_price'] ?? '' }}" />
                                                        @error('item.' . $key . '.unit_price')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="total">
                                                            <h6>Total<code>*</code></h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $key . '.total') is-invalid @enderror"
                                                            id="total" name="item[{{ $key }}][total]"
                                                            type="number" placeholder="Enter total"
                                                            value="{{ $item['total'] ?? '' }}" />
                                                        @error('item.' . $key . '.total')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif (isset($inventory->items))
                                        @foreach ($inventory->items->where('is_deleted', false) as $item)
                                            <div class="inventory-item mt-2">
                                                <div class="row">
                                                    <input type="hidden" name="item[{{ $item->id }}][id]"
                                                        value="{{ $item->id }}" />

                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="item_name">
                                                            <h6>Item Name</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $item->id . '.item_name') is-invalid @enderror"
                                                            id="item_name" name="item[{{ $item->id }}][item_name]"
                                                            type="text" placeholder="Enter item_name"
                                                            value="{{ $item->item_name }}" />
                                                        @error('item.' . $item->id . '.item_name')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3">
                                                        <label for="quantity">
                                                            <h6>Quantity</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $item->id . '.quantity') is-invalid @enderror"
                                                            id="quantity" name="item[{{ $item->id }}][quantity]"
                                                            type="number" placeholder="Enter quantity"
                                                            value="{{ $item->quantity }}" />
                                                        @error('item.' . $item->id . '.quantity')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="unit_price">
                                                            <h6>Unit Price</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $item->id . '.unit_price') is-invalid @enderror"
                                                            id="unit_price" name="item[{{ $item->id }}][unit_price]"
                                                            type="number" placeholder="Enter unit_price"
                                                            value="{{ $item->unit_price }}" />
                                                        @error('item.' . $item->id . '.unit_price')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 form-group mb-3">
                                                        <label for="total">
                                                            <h6>Total</h6>
                                                        </label>
                                                        <input
                                                            class="form-control @error('item.' . $item->id . '.total') is-invalid @enderror"
                                                            id="total" name="item[{{ $item->id }}][total]"
                                                            type="number" placeholder="Enter total"
                                                            value="{{ $item->total }}" />
                                                        @error('item.' . $item->id . '.total')
                                                            <div class="text-danger">*{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1 form-group d-flex align-items-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm mt-2 remove-item">✖</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @else
                                    @foreach (old('item', []) as $key => $item)
                                        <div class="inventory-item">
                                            <div class="row">
                                                <input type="hidden" name="item[{{ $key }}][id]"
                                                    value="{{ $key }}" />
                                                <div class="col-md-3 form-group mb-3">
                                                    <label for="item_name">
                                                        <h6>Item Name</h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('item.' . $key . '.item_name') is-invalid @enderror"
                                                        id="item_name" name="item[{{ $key }}][item_name]"
                                                        type="text" placeholder="Enter item_name"
                                                        value="{{ old('item.' . $key . '.item_name') }}" />
                                                    @error('item.' . $key . '.item_name')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 form-group mb-3">
                                                    <label for="quantity">
                                                        <h6>Quantity</h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('item.' . $key . '.quantity') is-invalid @enderror"
                                                        id="quantity" name="item[{{ $key }}][quantity]"
                                                        type="number" placeholder="Enter quantity"
                                                        value="{{ old('item.' . $key . '.quantity') }}" />
                                                    @error('item.' . $key . '.quantity')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group mb-3">
                                                    <label for="unit_price">
                                                        <h6>Unit Price</h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('item.' . $key . '.unit_price') is-invalid @enderror"
                                                        id="unit_price" name="item[{{ $key }}][unit_price]"
                                                        type="number" placeholder="Enter price"
                                                        value="{{ old('item.' . $key . '.unit_price') }}" />
                                                    @error('item.' . $key . '.unit_price')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group mb-3">
                                                    <label for="total">
                                                        <h6>Total</h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('item.' . $key . '.total') is-invalid @enderror"
                                                        id="total" name="item[{{ $key }}][total]"
                                                        type="number" placeholder="Enter total"
                                                        value="{{ old('item.' . $key . '.total') }}" />
                                                    @error('item.' . $key . '.total')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary btn-sm ms-2 mt-2 mb-2" id="add-item">+
                                New
                            </button>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success float-right"><i class="far fa-hand-point-up"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // --- hide bill number input field ---
            function toggleBillNumber() {
                const selectedType = $('#type').val();
                if (selectedType === 'Sell') {
                    $('#billNumberWrapper').hide();
                    $('#bill_number').val('');
                } else {
                    $('#billNumberWrapper').show();
                }
            }

            toggleBillNumber();
            $('#type').on('change', function() {
                toggleBillNumber();
            });

            // --- jQuery to add multiple fields
            let newItemCount = 0;

            function addItem() {
                const newIndex = `new_${newItemCount++}`;
                let invItem = `
                    <div class="inventory-item" data-index="${newIndex}">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label><h6>Item Name</h6></label>
                                <input class="form-control" name="item[${newIndex}][item_name]" type="text" placeholder="Enter name" />
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label><h6>Quantity</h6></label>
                                <input class="form-control quantity" data-index="${newIndex}" name="item[${newIndex}][quantity]" type="number" placeholder="Enter quantity" />
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label><h6>Unit Price</h6></label>
                                <input class="form-control unit-price" data-index="${newIndex}" name="item[${newIndex}][unit_price]" type="number" placeholder="Enter price" />
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label><h6>Total</h6></label>
                                <input class="form-control total" readonly name="item[${newIndex}][total]" type="number" placeholder="Total" />
                            </div>
                            <div class="col-md-1 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-3 remove-item">✖</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#itemContainer').append(invItem);
            }


            if ($(".inventory-item").length === 0) {
                addItem();
            }

            $('#add-item').on('click', function() {
                addItem();
            });

            $(document).on('click', '.remove-item', function() {
                $(this).closest('.inventory-item').remove();
            });

            // --- calculate total ---
            $(document).on('input', '.quantity, .unit-price', function() {
                const index = $(this).data('index');
                const quantity = $(`input.quantity[data-index="${index}"]`).val();
                const unitPrice = $(`input.unit-price[data-index="${index}"]`).val();

                let total = 0;
                if (quantity && unitPrice) {
                    total = parseFloat(quantity) * parseFloat(unitPrice);
                }

                $(`input.total[name="item[${index}][total]"]`).val(total.toFixed(2));
            });
        });
    </script>
@endsection

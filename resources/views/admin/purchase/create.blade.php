@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid my-2">
        <!-- Add any additional content header elements if needed -->
    </div>
    <!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Purchase Information</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchaseNumber">Purchase Number <span class="text-danger">*</span></label>
                                <input type="text" name="purchaseNumber" id="purchaseNumber" class="form-control" placeholder="Enter Purchase Number">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" required>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div><br></div>

        <div class="card">
            <div class="card-head">
                <h5>Item Details</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="userForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_id">Item Name <span class="text-danger">*</span></label>
                                <select name="item_id" id="item_id" class="form-control" required>
                                    <option value="">Select an Item </option>
                                    @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_unit_id">Unit <span class="text-danger">*</span></label>
                                <select name="item_unit_id" id="item_unit_id" class="form-control" required>
                                    <option value="">Select a Unit </option>
                                    @foreach ($itemUnits as $itemUnit)
                                    <option value="{{ $itemUnit->id }}">{{ $itemUnit->unit_name }}</option>
                                    @endforeach
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Req Qty <span class="text-danger">*</span></label>
                                <input type="text" name="qty" id="qty" class="form-control" placeholder="Enter Total Quantity">
                                <p class="error"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit_price">Unit Price <span class="text-danger">*</span></label>
                                <input type="text" name="unit_price" id="unit_price" class="form-control" placeholder="Enter each Unit Price">
                                <p class="error"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                    <div class="form-group">
                        <label for="total_price">Total Price</label>
                        <input type="text" name="total_price" id="total_price" class="form-control" placeholder="Total Price" readonly>
                        <p class="error"></p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="founding_source_id">Available Fund <span class="text-danger">*</span></label>
                        <select name="founding_source_id" id="founding_source_id" class="form-control" required>
                            <option value="">Select any Fund </option>
                            @foreach ($foundingSources as $foundingSource)
                                <option value="{{ $foundingSource->id }}" data-current-fund="{{ $foundingSource->current_fund }}">
                                    {{ $foundingSource->source }} [Tk. {{ $foundingSource->current_fund }}]
                                </option>
                            @endforeach
                        </select>
                        <p class="error"></p>
                    </div>
                </div>
            </div>
            <button type="button" id="addToCartBtn" class="btn btn-primary">Add to Cart</button>
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        </form>
    </div>
    <table id="cartTable" class="table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Req Qty</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Available Fund</th>
            </tr>
        </thead>
        <tbody>
            <!-- Cart items will be dynamically added here -->
        </tbody>
    </table>
    
</div>
<button type="button" id="addToCartBtn" class="btn btn-primary">Add to Cart</button>
    </div>
   
</section>

@endsection

<script>
     document.addEventListener('DOMContentLoaded', function () {
        // Calculate total price dynamically based on qty and unit price
        const qtyInput = document.getElementById('qty');
        const unitPriceInput = document.getElementById('unit_price');
        const totalPriceInput = document.getElementById('total_price');
        const foundingSourceSelect = document.getElementById('founding_source_id');

        [qtyInput, unitPriceInput].forEach(input => {
            input.addEventListener('input', function () {
                calculateTotalPrice();
            });
        });

        function calculateTotalPrice() {
            const qty = parseFloat(qtyInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const totalPrice = qty * unitPrice;

            totalPriceInput.value = totalPrice.toFixed(2);
            validateAvailableFund(totalPrice);
        }

        function validateAvailableFund(totalPrice) {
            const selectedOptions = Array.from(foundingSourceSelect.options).filter(option => {
                const currentFund = parseFloat(option.dataset.currentFund) || 0;
                return totalPrice <= currentFund;
            });

            // Show/hide options based on the total price
            Array.from(foundingSourceSelect.options).forEach(option => {
                option.style.display = 'none';
            });

            selectedOptions.forEach(option => {
                option.style.display = '';
            });
        }
    });
</script>
@section('customJs')
<script>
    $(document).ready(function(){
        $('#addToCartBtn').click(function(){
            // Get values from form fields
            var itemName = $('#item_id option:selected').text();
            var unitName = $('#item_unit_id option:selected').text();
            var qty = $('#qty').val();
            var unitPrice = $('#unit_price').val();
            var totalPrice = parseFloat(qty) * parseFloat(unitPrice);
            var fundName = $('#founding_source_id option:selected').text().split('[')[0].trim();
    
            // Append new row to the table with added item details
            $('#cartTable tbody').append('<tr><td>' + itemName + '</td><td>' + unitName + '</td><td>' + qty + '</td><td>' + unitPrice + '</td><td>' + totalPrice.toFixed(2) + '</td><td>' + fundName + '</td></tr>');
    
            // Clear form fields after adding to cart
            $('#qty').val('');
            $('#unit_price').val('');
        });
    });
    </script>
    @endsection
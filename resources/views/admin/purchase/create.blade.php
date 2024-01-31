@extends('admin.layouts.app')

@section('content')

<section class="content-headers">
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
                                <input type="text" name="purchaseNumber" id="purchaseNumber" class="form-control" value="{{$generatedCode}}" required>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                <p class="error"></p>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

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
                                    <input type="text" name="item_unit" id="item_unit" value="" class="form-control" readonly required>
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
                    </div>
                    <button type="button" id="addToCartBtn" class="btn btn-primary">Add to Cart</button>
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-bordered" id="cartTable">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Req Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cart items will be dynamically added here -->
                        </tbody>
                        <tfoot>
                            <tr id="grandTotalRow">
                                <td colspan="5"></td>
                                <td><strong>Grand Total: <span id="grandTotal">0.00</span></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
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
        </div>

        <div class="row mt-3">
            <div class="col-md-12 text-right">
                <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <div><br></div>


</section>

@endsection
@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#item_id').on('change', function () {
            var item_id = $(this).val();

            if (item_id) {
                $.ajax({
                    url: '{{ route("purchases.getUnitId", ":item_id") }}'.replace(':item_id', item_id),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            // Assuming the response is a single item unit
                            var itemUnit = data;

                            // Update the value of the item_unit input field
                            $('#item_unit').val(itemUnit.unit_name);
                            
                        } else {
                            // Optionally handle the case when no data is returned
                            $('#item_unit').val('');
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            } else {
                $('#item_unit_id').empty();
                // Optionally show a default option or handle the case when no item is selected
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate total price dynamically based on qty and unit price
        const qtyInput = document.getElementById('qty');
        const unitPriceInput = document.getElementById('unit_price');
        const totalPriceInput = document.getElementById('total_price');
        const foundingSourceSelect = document.getElementById('founding_source_id');

        [qtyInput, unitPriceInput].forEach(input => {
            input.addEventListener('input', function() {
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

        // Initialize grand total
        var grandTotal = 0;

        $('#addToCartBtn').click(function() {
            // Get values from form fields
            var selectedItemId = $('#item_id').val();
            var itemName = $('#item_id option:selected').text();
            var unitName = $('#item_unit_id option:selected').text();
            var itemUnitId = $('#item_unit_id').val();
            var qty = $('#qty').val();
            var unitPrice = $('#unit_price').val();
            var totalPrice = parseFloat(qty) * parseFloat(unitPrice);

            // Update grand total
            grandTotal += totalPrice;

            // Append new row to the table with added item details and remove button
            var newRow = '<tr data-item_id="' + selectedItemId + '" data-item_unit_id="' + itemUnitId + '"><td>' + itemName + '</td><td>' + unitName + '</td><td>' + qty + '</td><td>' + unitPrice + '</td><td>' + totalPrice.toFixed(2) + '</td><td><i class="fas fa-times text-danger remove-item"></i></td></tr>';
            $('#cartTable tbody').append(newRow);

            // Clear form fields after adding to cart
            $('#qty').val('');
            $('#unit_price').val('');

            // Update the grand total display
            updateGrandTotal();

            // Call the function to validate available funds
            validateAvailableFund();
        });

        // Event handler for removing an item
        $('#cartTable').on('click', '.remove-item', function() {
            var row = $(this).closest('tr');
            var totalPrice = parseFloat(row.find('td:eq(4)').text());

            // Update grand total by subtracting the removed item's total price
            grandTotal -= totalPrice;

            // Remove the row from the table
            row.remove();

            // Update the grand total display
            updateGrandTotal();

            // Call the function to validate available funds
            validateAvailableFund();
        });

        function updateGrandTotal() {
            $('#grandTotal').text(grandTotal.toFixed(2));
        }

        var fundingSourceSelect = $('#founding_source_id')[0];

        function validateAvailableFund() {
            const selectedOptions = Array.from(foundingSourceSelect.options).filter(option => {
                const currentFund = parseFloat(option.dataset.currentFund) || 0;
                return grandTotal <= currentFund;
            });

            // Show/hide options based on the total price
            Array.from(foundingSourceSelect.options).forEach(option => {
                option.style.display = 'none';
            });

            if (selectedOptions.length > 0) {
                selectedOptions.forEach(option => {
                    option.style.display = '';
                });
            } else {
                alert("Sorry! No funds are available.");
            }
        }

        $('#submitBtn').click(function() {
            // Extract data from the form
            var formData = $('#userForm').serializeArray();

            // Extract data from the cart table
            var cartItems = [];
            var selectedFundingSource = $('#founding_source_id').val(); // Get the selected funding source
            $('#cartTable tbody tr').each(function() {
                var itemData = {
                    item_id: $(this).data('item_id'),
                    item_unit_id: $(this).data('item_unit_id'),
                    qty: $(this).find('td:eq(2)').text(),
                    unit_price: $(this).find('td:eq(3)').text(),
                    total_price: $(this).find('td:eq(4)').text(),
                    founding_source_id: selectedFundingSource, // Add the selected funding source to itemData
                };
                cartItems.push(itemData);
            });

            // Add cart items data to the form data
            formData.push({
                name: 'cartItems',
                value: JSON.stringify(cartItems)
            });

            // Make sure CSRF token is included
            formData.push({
                name: '_token',
                value: '{{ csrf_token() }}'
            });

            // Make an AJAX request to store the data
            $.ajax({
                url: '{{ route("purchases.store") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response.message);

                    if (response["status"] == true) {
                        window.location.href = '{{ route("purchases.index") }}';
                    } else {
                        var errors = response['errors'];
                        $(".error").removeClass('is-invalid').html('');
                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid');
                            $(`#${key}`).next('p').addClass('invalid-feedback').html(value);
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });
    });
</script>
@endsection

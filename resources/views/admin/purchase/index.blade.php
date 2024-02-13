@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Purchases list</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Add Purchase
                </a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">
            <form action="{{ route('purchases.index') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("purchases.index") }}'" class="btn btn-default btn-sm">Reset</button>
                    </div>

                    <div class="card-tools">
                        <!-- <div class="row">
           
           <div class="col-md-3">
                               <div class="mb-3">
                                   <label for="date">start Dates</label>
                                   <input type="datetime-local" name="fromDate" id="fromDate" class="form-control" value="{{ Request::get('toDate') }}"  required>
                                   <p class="error"></p>
                                 
                               </div>
           </div>
           <div class="col-md-3">

                               <div class="mb-3">
                                   <label for="date"> end Dates</label>
                                   <input type="date-local" name="toDate" id="toDate" class="form-control" required>
                                   <p class="error"></p>
                               </div>
                           </div>
            <button type="submit" class="btn btn-primary">Submit</button>

           </div> -->
                    </div>
                </div>

            </form>
            <div class="card-body text-right">
                <form action="{{ route('purchases.index') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="date">From Date</label>

                                <p class="error"></p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">

                                <input type="datetime-local" name="fromDate" id="fromDate" class="form-control" value="{{ Request::get('toDate') }}" required>
                                <p class="error"></p>

                            </div>
                        </div>
                        <div class="col-md-2">

                            <div class="mb-2">
                                <label for="date">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></span> To Date</label>

                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="mb-2">

                                <input type="date-local" name="toDate" id="toDate" class="form-control" required>
                                <p class="error"></p>
                            </div>
                        </div>

                        <div class="col-2 text-right">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Purchase Number</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Funding Source</th>
                            <th>Total Price</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if ($purchases->isNotEmpty())
                        @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->purchase_number }}</td>
                            <td>{{ $purchase->date }}</td>
                            <td>{{ $purchase->item->item_name }}</td>
                            <td>{{ $purchase->qty }}</td>
                            <td>{{ $purchase->unit_price }}</td>
                            
                            <td><a href="{{route('purchases.fundlist', $purchase->date)}}">{{ $purchase->foundingSource->source }}</a></td>
                            
                            <td>{{ $purchase->grand_total }}</td>
                            
                        </tr>
                        @endforeach
                        <tr>
                            <!-- <th colspan="7" align="right">Subtotal:</th> -->
                            <td colspan="7" align="right">Subtotal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></span></td>
                            <td>{{number_format($purchasesAmount,2)}}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="8">No purchases available.</td>
                        </tr>
                        @endif

                    </tbody>

                </table>
            </div>
            <tr>



                <div class="card-footer clearfix">
                    {{ $purchases->links() }}
                </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {

        // Example dates from the controller
        var startDate = @json($startDate);
        config = {

            dateFormat: "Y-m-d",

            defaultDate: startDate,
            // Pre-select dates from the controller
        };
        var endDate = @json($endDate);

        flatpickr("input[type=datetime-local]", config);
        config = {

            dateFormat: "Y-m-d",

            defaultDate: endDate,
            // Pre-select dates from the controller
        };
        flatpickr("input[type=date-local]", config);

        $("#userForm").submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '',
                type: 'POST',
                data: new FormData(element[0]),
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response.status == true) {
                        window.location.href = '';
                    } else {
                        var errors = response.errors;
                        $(".error").removeClass('is-invalid').html('');
                        $("input[type='text'], input[type='password'], input[type='file']").removeClass('is-invalid');
                        $.each(errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key).next('p').addClass('invalid-feedback').html(value);
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
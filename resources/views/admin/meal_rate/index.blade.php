@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Meal Rate list</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('meal.downloadPDF') }}" class="btn btn-primary">
                    Download 
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
            <form action="{{ route('meal.rate.index') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("meal.rate.index") }}'" class="btn btn-default btn-sm">Reset</button>
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
                <form action="{{ route('meal.rate.index') }}" method="GET">
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
                            
                            <th>Date</th>
                            <th>rate</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if ($mealRates->isNotEmpty())
                        @foreach ($mealRates as $mealRate)
                        <tr>
                            <td>{{ $mealRate->id }}</td>
                            <td>{{ $mealRate->date }}</td>
                             <td>{{ $mealRate->rate }}</td>
                            
                        </tr>
                        @endforeach
                       
                        @else
                        <tr>
                            <td colspan="8">No purchases available.</td>
                        </tr>
                        @endif
                        
                    </tbody>

                </table>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    
                    <tbody>
                        
                        <div class="card-footer clearfix">
                        <tr>
                            <th>start date</th>
                            <th>end date</th>
                             <th>total amount</th>
                             <th>Total Booked</th>
                             <th>Rate</th>
                            
                        </tr>
                        <tr>
                            <td>{{ $startDate }}</td>
                            <td>{{ $endDate }}</td>
                             <td>{{ $totalAmount }}</td>
                             <td>{{ $userNumber}}</td>
                             <td>{{ number_format($rate, 2) }}</td>
                            
                        </tr>
                        </div>
                    </tbody>

                </table>
            </div>
            <tr>



                <div class="card-footer clearfix">
                    {{ $mealRates->links() }}
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
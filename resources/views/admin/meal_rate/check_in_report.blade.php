@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CheckedIn list</h1>
            </div>
            <div class="col-sm-6 text-right">
                @if($date !='--/--/--')
                <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('j F, Y')  }}</p>
                
                @endif
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content-header">
    <!-- ... Your existing content ... -->
</section>

<section class="content">
    <div class="container-fluid">
        @include('admin.message')
      
        
        <div class="col-12">
            <div class="input-group-append justify-content-end">
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route("admin.pdf") }}'">Download</button>
            </div>
        </div>
        <div>
            <br>
        </div>
    
      
    
        <div class="card">
            <form action="{{ route('checkin.report') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("checkin.report") }}'" class="btn btn-default btn-sm">Reset</button>
                    </div>
                    <div class="card-tools">
                  
            
         
                    <div class="row">

                   
                        <div class="col-md-4">

                            <div class="mb-3">
                                <label for="date"><span></span>Date</label>

                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="mb-4">

                                <input type="date-local" name="date" id="date" class="form-control" value={{$date}} required>
                                <p class="error"></p>
                            </div>
                        </div>

                        <div class="col-3 text-right">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    search
                                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                               
                            <br></div>
                        </div>
                       
              
            </div>
                    </div>
                </div>
            </form>

         
                <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Roll</th>
                            <th>Bp_num</th>
                            <th>Name</th>
                            <th>Breakfast</th>
                            <th>Lunch</th>
                            <th>Dinner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->bp_num }}</td>
                            <td>{{ $user->name }}</td>
                            @php
                            $userBooking = $bookings->where('user_id', $user->id)->first();
                            @endphp
                            <td>
                                @if ($userBooking && $userBooking->breakfast == 2)
                                <i class="fas fa-check text-success"></i>
                                @else
                                <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if ($userBooking && $userBooking->lunch == 2)
                                <i class="fas fa-check text-success"></i>
                                @else
                                <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if ($userBooking && $userBooking->dinner == 2)
                                <i class="fas fa-check text-success"></i>
                                @else
                                <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$users->links()}}
            </div>
        </div>

   
    </div>
</section>
@endsection

@section('customJs')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {

        // Example dates from the controller

        var endDate = @json($date);

        config = {

            dateFormat: "Y-m-d",

            defaultDate: endDate,
            // Pre-select dates from the controller
        };
        flatpickr("input[type=date-local]", config);

       
    });
</script>

@endsection
@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Today's Lunch list</h1>
            </div>
            <div class="col-sm-6 text-right">
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        @include('admin.message')
        <div class="text-right">
            <label class="toggle-container">
                <input type="checkbox" id="selectAll" class="toggle-input">
                <span class="toggle-slider"></span>
                Select All
            </label>
        </div>
        <div class="card">
            <form action="{{ route('bookings.lunch-list') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("bookings.lunch-list") }}'" class="btn btn-default btn-sm">Reset</button> &nbsp;
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" value="{{ Request::get('keyword') }}" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-title">
                        <button type="button" class="btn btn-success btn-sm" id="checkInBtn">Check In</button>
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
                            <th>Booked</th>
                            <th>Checked In</th>
                            <th>Action</th>
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
                                @if ($userBooking && $userBooking->lunch)
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
                                <label class="toggle-container">
                                    <input type="checkbox" class="toggle-input" data-user-id="{{ $user->id }}">
                                    <span class="toggle-slider"></span>
                                </label>
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
</section>
@endsection
@section('customJs')
<script>
    // Add event listener to the "Select All" checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        // Select all checkboxes in the table based on the "Select All" checkbox state
        let checkboxes = document.querySelectorAll('.toggle-input');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

     // Add event listener to the "Check In" button
     document.getElementById('checkInBtn').addEventListener('click', function () {
        // Get all checked checkboxes
        let checkboxes = document.querySelectorAll('.toggle-input:checked');

        // Extract user IDs from data attributes
        let userIds = Array.from(checkboxes).map(checkbox => checkbox.getAttribute('data-user-id'));

        // Perform AJAX request
        if (userIds.length > 0) {
            $.ajax({
                url: '{{ route("bookings.lunch") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_ids: userIds
                },
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = '{{ route("bookings.lunch-list") }}';
                    }
                    // Handle the response as needed
                    console.log(response);
                },
                error: function (error) {
                    // Handle errors
                    console.error(error);
                }
            });
        } else {
            alert('No users selected for Check In.');
        }
    });
</script>
@endsection

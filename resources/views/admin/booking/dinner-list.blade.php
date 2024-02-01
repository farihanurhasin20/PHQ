@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Today's Dinner list</h1>
            </div>
            <div class="col-sm-6 text-right">
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
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
        <div class="text-right">
            <label class="toggle-container">
                <input type="checkbox" id="selectAll" class="toggle-input">
                <span class="toggle-slider"></span>
                Select All
            </label>
        </div>
        <div class="card">
            <form action="{{ route('bookings.dinner-list') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("bookings.dinner-list") }}'" class="btn btn-default btn-sm">Reset</button>
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
                                @if ($userBooking && $userBooking->dinner)
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
                            <td>
                                <label class="toggle-container">
                                    <input type="checkbox" class="toggle-input">
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
</script>
@endsection

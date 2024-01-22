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
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Bp_num</th>
                                <th>Name</th>
                                <th>Booked</th>
                                <th>Checked In</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
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
                    {{-- {{$users->links()}} --}}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <!-- Your custom JavaScript, if any -->
@endsection

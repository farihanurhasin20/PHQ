@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Booked For Today</h1>
            </div>
            <div class="col-sm-6">
                <!-- Add any additional content for the right side if needed -->
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

        
            <!-- Breakfast -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="header text-center" style="color: #3498db;">
                        <h5>Breakfast</h5>
                    </div>
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-6 col-6 text-left pl-4">
                                <h3>{{$totalBreakfastCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$totalBreakfastBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('bookings.list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Lunch -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="header text-center" style="color: #e74c3c;">
                        <h5>Lunch</h5>
                    </div>
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-6 col-6 text-left pl-4">
                                <h3>{{$totalLunchCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$totalLunchBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('bookings.list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Dinner -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="header text-center" style="color: #2ecc71;">
                        <h5>Dinner</h5>
                    </div>
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-6 col-6 text-left pl-4">
                                <h3>{{$totalDinnerCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right  pr-4">
                                <h3>{{$totalDinnerBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('bookings.list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('customJs')
<script>
    console.log('hello world')
</script>
@endsection

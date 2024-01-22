@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Booked For Today</h1>
            </div>
            
            <div class="col-sm-6 text-right">
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
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
                                <h3>{{$todayBreakfastCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$todayBreakfastBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('bookings.breakfast-list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                                <h3>{{$todayLunchCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$todayLunchBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('bookings.lunch-list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                                <h3>{{$todayDinnerCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right  pr-4">
                                <h3>{{$todayDinnerBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('bookings.dinner-list') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</section>

<div>
    <br> <br> <br> <br>
</div>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Booked For Tomorroww</h1>
            </div>
            
            <div class="col-sm-6 text-right">
                <p>{{ \Carbon\Carbon::now()->addDay()->format('l, F j, Y') }}</p>
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
                                <h3>{{$tomorrowBreakfastCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$tomorrowBreakfastBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    
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
                                <h3>{{$tomorrowLunchCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right pr-4">
                                <h3>{{$tomorrowLunchBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                   
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
                                <h3>{{$tomorrowDinnerCheckin}}</h3>
                                <p>Checked</p>
                            </div>
                            <div class="col-lg-6 col-6 text-right  pr-4">
                                <h3>{{$tomorrowDinnerBooking}}</h3>
                                <p>Booked</p>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    
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

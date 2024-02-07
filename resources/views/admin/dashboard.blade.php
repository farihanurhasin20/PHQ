@extends('admin.layouts.app')

@section('content')

<div class="row">


        <section class="content-header">
            <div class="container-fluid">
            <div class="col-sm-12 text-right"> 
                      
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#calendarModal" id="openCalendarButton">
                    Open Calendar
                </button>
                       
                    </div>
                    
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5>Today's meal information</h5>
                    </div>

                    <div class="col-sm-6 text-right"> 
                        <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#calendarModal" id="openCalendarButton">
                    Open Calendar
                </button> -->
                       
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
                                        <h3>{{$todayBreakfastBooking}}</h3>
                                        <p>Booked</p>
                                    </div>
                                    <div class="col-lg-6 col-6 text-right pr-4">
                                        <h3>{{$todayBreakfastCheckin}}</h3>
                                        <p>Checked</p>
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
                            <div class="header text-center" style="color: #3498db;">
                                <h5>Lunch</h5>
                            </div>
                            <div class="inner">
                                <div class="row">
                                    <div class="col-lg-6 col-6 text-left pl-4">
                                        <h3>{{$todayLunchBooking}}</h3>
                                        <p>Booked</p>
                                    </div>
                                    <div class="col-lg-6 col-6 text-right pr-4">
                                        <h3>{{$todayLunchCheckin}}</h3>
                                        <p>Checked</p>
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
                            <div class="header text-center" style="color: #3498db;">
                                <h5>Dinner</h5>
                            </div>
                            <div class="inner">
                                <div class="row">
                                    <div class="col-lg-6 col-6 text-left  pl-4">
                                        <h3>{{$todayDinnerBooking}}</h3>
                                        <p>Booked</p>
                                    </div>
                                    <div class="col-lg-6 col-6 text-right pr-4">
                                        <h3>{{$todayDinnerCheckin}}</h3>
                                        <p>Checked</p>
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
                        <h5> Reservation Details for Tomorrow</h5>
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

                                    <div class="col-lg-12 col-12 text-center">
                                        <h3>{{$tomorrowBreakfastBooking}}</h3>
                                        <p>Registered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('bookings.reserved') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Lunch -->

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="small-box card" style="padding-top: 20px;">
                            <div class="header text-center" style="color: #3498db;">
                                <h5>Lunch</h5>
                            </div>
                            <div class="inner">
                                <div class="row">

                                    <div class="col-lg-12 col-12 text-center">
                                        <h3>{{$tomorrowLunchBooking}}</h3>
                                        <p>Registered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('bookings.reserved') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Dinner -->

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="small-box card" style="padding-top: 20px;">
                            <div class="header text-center" style="color: #3498db;">
                                <h5>Dinner</h5>
                            </div>
                            <div class="inner">
                                <div class="row">

                                    <div class="col-lg-12 col-12 text-center">

                                        <h3>{{$tomorrowDinnerBooking}}</h3>
                                        <p>Registered</p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('bookings.reserved') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>



    
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5> Reservation Details Calendar</h5>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Booking title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" id="title">
                                <span id="titleError" class="text-danger"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#calendarModal" id="openCalendarButton">
                    Open Calendar
                </button>
                <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Calendar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="container">
                    <div class="row">
            <div class="col-12">
                <div id="calendar">
                    <!-- FullCalendar will be appended here -->
                </div>
            </div>
            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
                <!-- <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div id="calendar">
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>
   
</div>
@endsection

@section('customJs')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

    
        var booking = @json($events);
        var calendar =$('#calendar').fullCalendar({
            events: booking,
            selectable: true,
            selectHelper: true,
            eventRender: function(event, element) {
                element.attr('title', event.title);
            },
            select: function(start, end, allDays) {
                console.log('selecting.', start);
                console.log('Start time:', start.format());
                var date = start.format();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('admin.listByDate') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        date
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Including CSRF token in headers
                    },
                    success: function(response) {
                        console.log(response.message);

                        if (response["status"] == true) {
                            var users = response["users"];
                            console.log(users);
                            // Redirect to the "purchases.index" route and pass the users data as a query parameter
                            window.location.href = '{{ route("admin.userListByDate") }}' + '?users=' + encodeURIComponent(JSON.stringify(users));
                        } else {
                            var errors = response['errors'];
                            $(".error").removeClass('is-invalid').html(''); // Remove error classes and clear error messages
                            $("input[type='text'], select").removeClass('is-invalid');
                            $.each(errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid'); // Add the 'is-invalid' class to the input
                                $(`#${key}`).next('p').addClass('invalid-feedback').html(value); // Add the error message
                            });

                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log("Something went wrong");
                    },
                });
            },
            eventClick: function(event) {
                console.log('Start time:', event.start.format());
                var date = event.start.format();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('admin.listByDate') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        date
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Including CSRF token in headers
                    },
                    success: function(response) {
                        console.log(response.message);

                        if (response["status"] == true) {
                            var users = response["users"];
                            console.log(users);
                            // Redirect to the "purchases.index" route and pass the users data as a query parameter
                            window.location.href = '{{ route("admin.userListByDate") }}' + '?users=' + encodeURIComponent(JSON.stringify(users));
                        } else {
                            var errors = response['errors'];
                            $(".error").removeClass('is-invalid').html(''); // Remove error classes and clear error messages
                            $("input[type='text'], select").removeClass('is-invalid');
                            $.each(errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid'); // Add the 'is-invalid' class to the input
                                $(`#${key}`).next('p').addClass('invalid-feedback').html(value); // Add the error message
                            });

                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log("Something went wrong");
                    },
                });
            }
        });
        $('#openCalendarButton').click(function() {
        // Delay the click on the "today" button by 200 milliseconds
        console.log('clicked modal');
        setTimeout(function() {
            calendar.fullCalendar('today');
        }, 200);
    });
    });

</script>
@endsection
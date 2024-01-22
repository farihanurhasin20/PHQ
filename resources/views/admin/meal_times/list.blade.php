
@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Meal Times</h1>
                </div>
                <div class="col-sm-6 text-right">
                    
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
                <!-- Add a form for search if needed -->

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Meal Type</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($mealTimes->isNotEmpty())
                                @foreach ($mealTimes as $mealTime)
                                    <tr>
                                        <td>{{ $mealTime->id }}</td>
                                        <td>{{ $mealTime->meal_type }}</td>
                                        <td>{{ $mealTime->start_time }}</td>
                                        <td>{{ $mealTime->end_time }}</td>
                                        <td>
                                        <a href="{{ route('meal-times.edit', $mealTime->id) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </a>
                                            <!-- Add your delete function here -->
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- Handle case when no meal times are found -->
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <!-- Add your pagination links here if needed -->
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        // Add your custom JavaScript if needed
    </script>
@endsection

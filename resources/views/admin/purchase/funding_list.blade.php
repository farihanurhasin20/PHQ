@extends('admin.layouts.app')
@section('content')
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Funding History</h1>
            </div>
            <div class="col-sm-6 text-right">
                <!-- <a href="{{ route('fund_history.create') }}" class="btn btn-primary">New Funding</a> -->
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
            <form action="" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("fund_history.index") }}'" class="btn btn-default btn-sm">reset</button>
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
                            <th width="60">ID</th>
                            <th>Funding Source</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($availableFundings->isNotEmpty())
                        @foreach ($availableFundings as $funding)
                        <tr>
                            <td>{{ $funding->id }}</td>
                            <td>{{ $funding->source }}</td>
                            <td>{{ $funding->date }}</td>
                            <td>{{ $funding->amount }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">No data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
              
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')

@endsection

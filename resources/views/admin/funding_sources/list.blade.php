@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Funding Sources</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('funding_sources.create') }}" class="btn btn-primary">New source</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <!-- Similar search form as in the categories view -->
                <form action="" method="GET">
                    <!-- ... (your search form content) ... -->
                </form>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Source</th>
                                <th>Available Fund</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fundingSources as $fundingSource)
                                <tr>
                                    <td><a href="{{route('fund_history.index', ['id' => $fundingSource->id])}}">{{ $fundingSource->id }}</a></td>
                                    <td>{{ $fundingSource->source }}</td>
                                    <td>৳ {{ $fundingSource->current_fund }}</td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5">No funding sources found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
               
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
@endsection

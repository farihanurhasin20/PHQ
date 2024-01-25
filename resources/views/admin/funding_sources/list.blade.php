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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fundingSources as $fundingSource)
                                <tr>
                                    <td>{{ $fundingSource->id }}</td>
                                    <td>{{ $fundingSource->source }}</td>
                                    <td>
                                       
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        </a>
                                    </td>
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

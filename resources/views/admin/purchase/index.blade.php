@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchases list</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Add Purchase
                    </a>
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

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Purchase Number</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Funding Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($purchases->isNotEmpty())
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->id }}</td>
                                        <td>{{ $purchase->purchase_number }}</td>
                                        <td>{{ $purchase->date }}</td>
                                        <td>{{ $purchase->item->item_name }}</td>
                                        <td>{{ $purchase->qty }}</td>
                                        <td>{{ $purchase->unit_price }}</td>
                                        <td>{{ $purchase->foundingSource->source }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">No purchases available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $purchases->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        // Your custom JavaScript code here
    </script>
@endsection

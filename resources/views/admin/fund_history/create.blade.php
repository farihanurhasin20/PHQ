@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Available Funding</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{ route("fund_history.index") }}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('fund_history.store') }}" method="POST" id="availableFundingForm">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="funding_source">Funding Source</label>
                                    <select name="funding_source" id="funding_source" class="form-control" required>
                                        <option value="">Select a Funding Source</option>
                                        @if($fundingSources->isNotempty())
                                            @foreach($fundingSources as $fundingSource)
                                                <option value="{{ $fundingSource->id }}">{{ $fundingSource->source }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href='{{ route("fund_history.create") }}' class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $("#availableFundingForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);

            // Add the CSRF token to the form data
            element.serializeArray().push({name: "_token", value: "{{ csrf_token() }}"});

            $.ajax({
                url: '{{ route("fund_history.store") }}',
                type: 'POST',
                data: element.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = '{{ route("fund_history.index") }}';
                    } else {
                        var errors = response.errors;
                        $(".error").removeClass('is-invalid').html('');
                        $("input[type='text'], select").removeClass('is-invalid');
                        $.each(errors, function (key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key).next('p').addClass('invalid-feedback').html(value);
                        });
                    }
                },
                error: function (jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });
    </script>
@endsection

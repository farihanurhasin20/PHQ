@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Funding Source</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('funding_sources.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="POST" id="fundingSourceForm" name="fundingSourceForm">
         @csrf 

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="source">Source</label>
                                    <input type="text" name="source" id="source" class="form-control" placeholder="Source">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('funding_sources.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>

        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $("#fundingSourceForm").submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("funding_sources.store") }}',
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response["status"] == true) {
                        window.location.href = "{{ route('funding_sources.index') }}";
                    } else {
                        var errors = response['errors'];
                        $(".error").removeClass('is-invalid').html('');
                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid');
                            $(`#${key}`).next('p').addClass('invalid-feedback').html(value);
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });
    </script>
@endsection

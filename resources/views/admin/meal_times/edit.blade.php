@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Meal Time</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('meal-times.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('meal-times.update', $mealTime->id) }}" method="POST" id="mealForm" name="mealForm">
            @csrf
            @method('PUT')

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="meal_type">Meal Type</label>
                                    <input type="text" name="meal_type" id="meal_type" class="form-control" value="{{ $mealTime->meal_type }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_time">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $mealTime->start_time }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_time">End Time</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $mealTime->end_time }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('meal-times.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
<script>
    $("#mealForm").submit(function (event) {
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("meal-times.update", $mealTime->id) }}',
            type: 'PUT',
            data: element.serialize(),  // Use serialize() instead of serializeArray()
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);
                if (response.status == true) {
                    window.location.href = "{{ route('meal-times.index') }}";
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
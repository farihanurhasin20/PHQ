@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Book meal</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('users.list') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="POST" enctype="multipart/form-data" id="userForm">
            @csrf

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">ID</label>
                                    <input type="text" name="id" id="id" class="form-control" value="" readonly>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $("#userForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '',
                type: 'POST',
                data: new FormData(element[0]),
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response.status == true) {
                        window.location.href = '{{ route("users.list") }}';
                    } else {
                        var errors = response.errors;
                        $(".error").removeClass('is-invalid').html('');
                        $("input[type='text'], input[type='password'], input[type='file']").removeClass('is-invalid');
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

    <script>
        function updateFileName(input) {
            var fileName = input.files[0].name;
            $(input).next('.custom-file-label').html(fileName);
        }
    </script>
@endsection


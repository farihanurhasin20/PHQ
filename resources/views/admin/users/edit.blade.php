@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('users.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="POST" id="userForm" name="userForm">
        {{-- @csrf --}}

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value={{$users->name}}>
                            <p class="error"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Email</label>
                            <input type="text"  name="email" id="email" class="form-control" placeholder="Email" value={{$users->email}}>
                            <p class="error"></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Password</label>
                            <input type="password"  name="password" id="password" class="form-control" placeholder="password">
                            <span>To change the password you have to enter a value, otherwise leave it blank</span>
                            <p class="error"></p>
                        </div>
                    </div>
 
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Phone</label>
                            <input type="text"  name="phone" id="phone" class="form-control" placeholder="phone" value={{$users->phone}}>
                            <p class="error"></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-1">
                            <label for="status">status</label>
                            <select  name="status" id="status" class="form-control" >
                                <option {{($users->status ==1)? 'selected' : ''}} value="1">Active</option>
                                <option {{($users->status ==0)? 'selected' : ''}} value="0">Deactive</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary" >Update</button>
            <a href="{{route('users.create')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>

    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')

    <script>
    $("#userForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
            url: '{{ route("users.update", $users->id) }}',
            type: 'Put',
            data: element.serializeArray(),  // Fixed typo: 'data' instead of 'date'
            dataType: 'json',
            headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function(response) {  // Fixed typo: 'function' instead of 'funtion'
                // Handle success response here
                $("button[type=submit]").prop('disabled',false);
                if(response["status"] == true){
                    if(response["role"] == 1) {
                        window.location.href = "{{ route('users.index') }}";
                    } else if (response["role"] == 2) {
                        window.location.href = "{{ route('users.admin_index') }}";
                    } else {
                        window.location.href = "{{ route('users.vendor_index') }}";
                    }
                } else{
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
            }
        })
    });

   $("#name").change(function(){
    element = $(this);
    $("button[type=submit]").prop('disabled',true);
    $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},  // Fixed typo: 'data' instead of 'date'
            dataType: 'json',
            headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function(response) {  // Fixed typo: 'function' instead of 'funtion'
                // Handle success response here
                $("button[type=submit]").prop('disabled',false);
                if(response["status"]== true){
                    $("#slug").val(response["slug"])
                }
    }
});
   });


   Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
     success: function(file, response){
        $("#image_id").val(response.image_id);
        console.log(response)
    }
});

</script>


@endsection

@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users list</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content-header">
    <!-- ... Your existing content ... -->
</section>

<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">

            <form action="{{ route('users.list') }}" method="GET">
                @csrf
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("users.list") }}'" class="btn btn-default btn-sm">Reset</button>
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
                            <th width="60">Roll</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Rank</th>
                            <th>Mobile</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                        @foreach ($users as $user)
                        @php
                        // Check if $user->image is a string (base64 image data)
                        $isBase64String = is_string($user->image);
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                @if ($isBase64String && !empty($user->image))
                                <?php
                                $imageData = $user->image;
                                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                                ?>
                                <img src="{{ $imageSrc }}" class="img-thumbnail" alt="{{ $user->title }}" width="50">
                                @else
                                <img src="{{ asset('admin-assets/img/default.png') }}" class="img-thumbnail" alt="default image" width="50">
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>
                                {{ $user->rank }}
                            </td>

                            <td>{{$user->mobile}}</td>

                            <td>
                                @if ($user->status == 1)
                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @else
                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif

                            </td>
                            <td>
                                <a href="{{route('users.edit',$user->id)}}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <a href="#"  class="open-password-modal" data-toggle="modal" data-target="#passwordmodal" data-user-id="{{ $user->id }}">
                                <g fill="none" stroke="yellow" stroke-width="2">
                                    <svg class="meal-book-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!-- Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. -->
                                        <path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/>
                                    </svg>
                                </g>
                                  
                                </a>
                    
                                <a href="{{route('booking.create',$user->id)}}">
                                <svg class="meal-book-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <g fill="none" stroke="green" stroke-width="2">
                                            <rect width="14" height="14" x="3" y="3" rx="2" ry="2"></rect>
                                            <path d="M6 3V1h8v2M6 18v-2h8v2M10 1v6M6 6h8"></path>
                                        </g>
                                    </svg>
                                </a>
                                <a href="{{route('booking.cancel.show',$user->id)}}">
                                <svg class="meal-book-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <g fill="none" stroke="red" stroke-width="2">
                                            <rect width="14" height="14" x="3" y="3" rx="2" ry="2"></rect>
                                            <path d="M6 3V1h8v2M6 18v-2h8v2M10 1v6M6 6h8"></path>
                                        </g>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{$users->links()}}
            </div>
        </div>
    </div>
    <div class="modal fade" id="passwordmodal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Password Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="userForm">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                            <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">ID</label>
                                <input type="text" name="user_id" id="user_id" class="form-control">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">New Password</label>
                                <input type="text" name="new_password" id="new_password" class="form-control" >
                                <p class="error"></p>
                            </div>
                        </div><div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Confirm Password</label>
                                <input type="text" name="confirm_password" id="confirm_password" class="form-control" >
                                <p class="error"></p>
                            </div>
                        </div>   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')

<script>
   $(document).ready(function(){
        $('#passwordmodal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('user-id'); // Extract user ID from data-* attributes
            var modal = $(this);

            // Set the user ID in the input field
            modal.find('#user_id').val(userId);
        });
    });
    $("#userForm").submit(function (event) {
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("users.password.update") }}',
            type: 'POST',
            data: element.serialize(),  // Use serialize() instead of serializeArray()
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);
                if (response.status == true) {
                    window.location.href = "{{ route('users.list') }}";
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


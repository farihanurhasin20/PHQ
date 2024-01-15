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
                <a href="{{route('users.list')}}" class="btn btn-primary">Back</a>
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
                            <label for="slug">Mobile</label>
                            <input type="text"  name="email" id="email" class="form-control" placeholder="Email" value={{$users->Mobile}}>
                            <p class="error"></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Rank</label>
                            <input type="password"  name="rank" id="rank" class="form-control" placeholder="rank" value={{$users->rank}}>
                           
                        </div>
                    </div>
 
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Phone</label>
                            <input type="text"  name="mobile" id="mobile" class="form-control" placeholder="mobile" value={{$users->mobile}}>
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
            {{-- <a href="{{route('users.create')}}" class="btn btn-outline-dark ml-3">Cancel</a> --}}
        </div>
    </div>
</form>

    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')

    <script>
   
</script>


@endsection

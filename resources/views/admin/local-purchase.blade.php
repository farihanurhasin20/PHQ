@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Dinner -->
            <!-- <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{ route('users.create') }}" class="card-link">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="inner d-flex align-items-center justify-content-center">
                        <div class="col-lg-6 col-6 text-center">
                            <h3><i class="fas fa-plus" ></i></h3>
                            <p>Add Users</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
                </a>
            </div> -->

         <!-- Dinner -->
       
      
            
            <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{ route('purchases.create') }}" class="card-link">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="inner d-flex align-items-center justify-content-center">
                        <div class="col-lg-6 col-6 text-center">
                            <h3><i class="fas fa-plus"></i></h3>
                            <p>Add Purchase</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
                </a>
            </div>

         
            <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{ route('purchases.index') }}" class="card-link">
                <div class="small-box card" style="padding-top: 20px;">
                    <div class="inner d-flex align-items-center justify-content-center">
                        <div class="col-lg-6 col-6 text-center">
                            <h3><i class="nav-icon fas fa-list-ul"></i></h3>
                            <p>Purchase List</p>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@section('customJs')
<script>
    console.log('hello world')
</script>
@endsection

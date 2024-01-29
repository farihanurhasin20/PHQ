@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Item - {{ $item->item_name }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('items.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('items.update', $item->id) }}" method="POST" id="itemForm">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_units_id">Item Unit</label>
                                    <select name="item_units_id" id="item_units_id" class="form-control" required>
                                        <option value="">Select an Item Unit</option>
                                        @if($itemUnits->isNotempty())
                                            @foreach($itemUnits as $unit)
                                                <option value="{{ $unit->id }}" {{ $unit->id == $item->item_units_id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_code">Item Code</label>
                                    <input type="text" name="item_code" id="item_code" class="form-control" placeholder="Item Code" value="{{ $item->item_code }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_name">Item Name</label>
                                    <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Item Name" required value="{{ $item->item_name }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $("#itemForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);

            // Add the CSRF token to the form data
            element.serializeArray().push({name: "_token", value: "{{ csrf_token() }}"});

            $.ajax({
                url: '{{ route("items.update", $item->id) }}',
                type: 'POST',
                data: element.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = '{{ route("items.index") }}';
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

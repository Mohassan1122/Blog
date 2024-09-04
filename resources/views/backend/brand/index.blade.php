@extends('backend.layout.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a> Brand <a href="{{ route('brand.create') }}" class="btn btn-sm btn-outline-secondary" > <i class="icon-plus"></i> Create Brand</a> </h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Brand</li>
                    </ul>

                    <p class="float-right">Total Brands:{{ App\Models\Brand::count() }}</p>


                </div>

            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layout.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Brand</strong> List</h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Photo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $item)
                                    <tr role="row" class="odd">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->slug }}</td>

                                        <td>
                                            <img src="{{ asset($item->photo) }}" alt=""
                                                style="width: 60px; height:60px;">
                                        </td>


                                        <td>
                                            <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                data-toggle="switchbutton" {{ $item->status=="active" ? "checked" : ""
                                            }}
                                            data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>

                                        <td>
                                            {{-- edit --}}
                                            <a href="{{ route('brand.edit', $item->id) }}" data-toggle="tooltip"
                                                title="edit" data-placement="bottom"
                                                class="btn btn-sm btn-outline-warning float-left "><i
                                                    class="fas fa-edit"></i></a>

                                            {{-- delete --}}


                                            <form action="{{ route('brand.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="" data-toggle="tooltip" data-id="{{ $item->id }}"
                                                    title="delete" data-placement="bottom"
                                                    class="dltbtn btn btn-sm btn-outline-danger float-left ml-2 "><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </form>


                                            {{-- <a href="{{ route('banner.destroy', $item->id) }}"
                                                data-toggle="tooltip" title="delete" data-placement="bottom"
                                                class="btn btn-sm btn-outline-danger"><i
                                                    class="fas fa-trash-alt"></i></a> --}}

                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripte')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $.ajaxSetup({
  headers: {
    'X-CSRF_TOKEN': $('meta[name="csrf-token"]')
  }
});
$('.dltbtn').click(function (e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var dataID = $(this).data('id');

    swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    form.submit();
    swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your imaginary file is safe!");
  }
});
});


</script>

<script>
    setTimeout(() => {
      $("#alert").slideUp();
    }, 4000);
</script>

<script>
    $('input[name=toogle]').change(function() {

        var mode = $(this).prop('checked');
        var id = $(this).val();
        //alert($id);

        $.ajax({
            url: "{{ route('brand.status') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                mode:mode,
                id:id,
            },
            success: function(response) {
                if (response.status) {
                    alert(response.msg)
                } else {
                    alert("hello");
                };
            }
        });

    });
</script>

@endsection

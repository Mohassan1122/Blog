@extends('backend.layout.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a> Product <a href="{{ route('product.create') }}"
                            class="btn btn-sm btn-outline-secondary"> <i class="icon-plus"></i> Create Product</a> </h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ul>

                    <p class="float-right">Total Categorys:{{ App\Models\Product::count() }}</p>


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
                        <h2><strong>Product</strong> List</h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Photo</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Size</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)

                                    @php
                                        $product = explode(',',$item->photo);
                                    @endphp


                                    <tr role="row" class="odd">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <img src="{{ $product[0] }}" alt=""
                                                style="width: 60px; height:60px;">
                                        </td>
                                        <td>{{ number_format($item->price,2) }}</td>
                                        <td>{{ $item->discount }}%</td>
                                        <td>{{ $item->size }}</td>



                                        {{-- <td>{{ $item->is_parent ===1 ? 'Yes' : 'NO'}}</td>
                                        <td>{{ \App\Models\Category::where('id', $item->parent_id)->value('title')}}
                                        </td> --}}
                                        <td>
                                            @if ($item->condition == 'new')
                                            <span class="badge badge-success">{{$item->condition}}</span>

                                            @elseif ($item->condition == 'popular')
                                            <span class="badge badge-primary">{{$item->condition}}</span>

                                            @else
                                            <span class="badge badge-warning">{{$item->condition}}</span>
                                            @endif

                                        </td>

                                        <td>
                                            <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                data-toggle="switchbutton" {{ $item->status=="active" ? "checked" : ""
                                            }}
                                            data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>

                                        <td>
                                               {{-- Modal --}}
                                               <a href="javascript:void(0);" data-toggle="modal"
                                               data-target="#productID{{ $item->id }}" title="view"
                                               data-placement="bottom"
                                               class="btn btn-sm btn-outline-secondary mr-2 float-left "><i
                                                   class="fas fa-eye"></i></a>
                                            {{-- edit --}}
                                            <a href="{{ route('product.edit', $item->id) }}" data-toggle="tooltip"
                                                title="edit" data-placement="bottom"
                                                class="btn btn-sm btn-outline-warning float-left "><i
                                                    class="fas fa-edit"></i></a>
                                            {{-- delete --}}


                                            <form action="{{ route('product.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="" data-toggle="tooltip" data-id="{{ $item->id }}"
                                                    title="delete" data-placement="bottom"
                                                    class="dltbtn btn btn-sm btn-outline-danger float-left mt-2 "><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </form>

                                        </td>


                                        <!-- Modal -->
                                        <div class="modal fade" id="productID{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    @php
                                                    $product = App\Models\Product::where('id', $item->id)->first();
                                                    @endphp

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{
                                                            \Illuminate\Support\Str::upper($product->title) }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong>Summary</strong>
                                                        <p>{!! html_entity_decode($product->summary)  !!}</p>
                                                        <strong>description</strong>
                                                        <p>{!! html_entity_decode($product->description) !!}</p>
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <strong>Price:</strong>
                                                                <p>{{ number_format($product->price ) }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Offer Price:</strong>
                                                                <p>{{ number_format($product->offer_price ) }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Stock:</strong>
                                                                <p>{{ $product->stock }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <strong>Catrgory:</strong>
                                                                <p>{{ App\Models\Category::where('id', $product->cat_id)->value('title') }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Child Category:</strong>
                                                                <p>{{  App\Models\Category::where('id', $product->child_cat_id)->value('title') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-4">
                                                                <strong>Brand:</strong>
                                                                <p>{{ App\Models\Brand::where('id', $product->brand_id)->value('title') }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Size:</strong>
                                                                <p class="badge badge-warning">{{ $product->size }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Vendor:</strong>
                                                                <p>{{ App\Models\User::where('id', $product->vendor_id)->value('fullname') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <strong>Condition:</strong>
                                                                <p class="badge badge-primary">{{ $product->condition }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Status:</strong>
                                                                <p class="badge badge-info">{{ $product->status }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
            url: "{{ route('product.status') }}",
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

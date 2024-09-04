@extends('backend.layout.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a>Edit Product</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Product</li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

                @endif

                <div class="card">

                    <div class="body">

                        <form class="form-auth-small" method="POST" action="{{ route('product.update', $product->id) }}">
                            @csrf
                            @method('patch')

                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title"
                                            value="{{ $product->title }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Summary</label>
                                        <textarea id="summary" class="form-control" name="summary"
                                            placeholder="write something">{{
                                            $product->summary }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Despription</label>
                                        <textarea id="description" class="form-control" name="description"
                                            placeholder="write something">{{
                                            $product->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Stock</label>
                                        <input type="number" class="form-control" placeholder="stock" name="stock"
                                            value="{{ $product->stock  }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="number" step="any" class="form-control" placeholder="price"
                                            name="price" value="{{ $product->price  }}">
                                    </div>
                                </div>

                                {{-- offer_price will be added from the backend using price and discount --}}


                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Discount</label>
                                        <input min="0" max="100" type="number" step="any" class="form-control" placeholder="discount"
                                            name="discount" value="{{ $product->discount  }}">
                                    </div>
                                </div>




                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label class="mr-2" for="">Photo</label>
                                        <div class="input-group">

                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $product->photo  }}">
                                        </div>
                                    </div>
                                    <div id="holder" style="margin:15px 0;max-height:100px;"></div>
                                </div>



                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Brands</label>
                                    <select class="form-control show-tick" name="brand_id">
                                        <option value="">-- Brands --</option>
                                        @foreach (App\Models\Brand::get() as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id==$product->brand_id ? 'selected'
                                            : ''}}>{{ $brand->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Category</label>
                                    <select id="cat_id" class="form-control show-tick" name="cat_id">
                                        <option value="">-- Category --</option>
                                        @foreach (App\Models\Category::where('is_parent',1)->get() as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id==$product->cat_id ? 'selected'
                                            : ''}} >{{ $cat->title }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="child_cat_div">
                                    <label for="">Child Category</label>
                                    <select id="child_cat_id" class="form-control show-tick" name="child_cat_id">
                                        <option value="">-- Category --</option>
                                        @foreach (App\Models\Category::where('is_parent',0)->get() as $child_cat)
                                        <option value="{{ $child_cat->id }}" {{ $child_cat->id==$product->child_cat_id ? 'selected'
                                            : ''}} >{{ $child_cat->title }} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">size</label>
                                    <select class="form-control show-tick" name="size">
                                        <option value="">-- Size --</option>
                                        <option value="S" {{ $product->size=='S' ? 'selected' : '' }}>Small
                                        </option>
                                        <option value="M" {{ $product->size=='M' ? 'selected' : '' }}>
                                            Meduim</option>
                                        <option value="L" {{ $product->size=='L' ? 'selected' : '' }}>
                                            Large</option>
                                    </select>
                                </div>


                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Condition</label>
                                    <select class="form-control show-tick" name="condition">
                                        <option value="">-- Condition --</option>
                                        <option value="new" {{ $product->condition=='new' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="popular" {{ $product->condition=='popular' ? 'selected' : '' }}>
                                            Popular</option>
                                        <option value="winter" {{ $product->condition=='winter' ? 'selected' : '' }}>
                                            Winter</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Vendor</label>
                                    <select class="form-control show-tick" name="vendor_id">
                                        <option value="">-- Vendor --</option>
                                        @foreach (App\Models\User::where('role','vendor')->get() as $vendor)
                                        <option value="{{ $vendor->id }}" {{ $vendor->id==$product->vendor_id ? 'selected'
                                            : ''}}>{{ $vendor->fullname }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <select class="form-control show-tick" name="status">
                                        <option value="">-- Status --</option>
                                        <option value="active" {{ $product->status=='active' ? 'selected' : '' }}>active
                                        </option>
                                        <option value="inactive" {{ $product->status=='inactive' ? 'selected' : '' }}>
                                            inactive</option>
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="submit" class="btn btn-outline-secondary">Cancel</
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

@endsection

@section('scripte')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
<script>
    $(document).ready(function() {
        $('#summary').summernote();
    });
    $(document).ready(function() {
        $('#description').summernote();
    });
</script>

<script>
    var child_cat_id = {{ $product->child_cat_id }}
    $('#cat_id').change(function () {
        var cat_id = $(this).val();


        if (cat_id !=null) {


            $.ajax({
                type: "POST",
                url: "/admin/category/"+cat_id+"/child",
                data: {
                _token: '{{ csrf_token() }}',
                cat_id:cat_id,
            },
            success: function(response) {
                var html_option = "<option value=''>title</option>";
                if (response.status) {
                    $('#child_cat_div').removeClass('d-none');
                    $.each(response.data, function (title) {
                        html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected' : '')+">"+title+"</option>"
                    });
                }else{
                    $('$child_cat_div').addClass('d-none');
                }
                $('$child_cat_id').html(html_option);
            }
            });


        }


   });

   if (child_cat_id != null) {
        $('#cat_id').change();
   }
</script>
@endsection

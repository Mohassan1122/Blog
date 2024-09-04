@extends('backend.layout.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a>Add Category</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Category</li>
                        <li class="breadcrumb-item active">Add Category</li>
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

                        <form class="form-auth-small" method="POST" action="{{ route('category.store') }}">
                            @csrf

                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" name="title"
                                            value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Summary</label>
                                        <textarea id="summary" class="form-control" name="summary"
                                            placeholder="write something">{{
                                            old('summary') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Is Parent : </label>
                                        <input type="checkbox" name="is_parent" id="is_parent" value="1" id="" checked>
                                        YES
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 d-none " id="parent_cat_id">
                                    <label for="">Parent Category</label>
                                    <select class="form-control show-tick" name="parent_id">
                                        <option value="">-- Parent Category --</option>
                                        @foreach ($parent_carts as $item)
                                        <option value="{{ $item->id }}" {{
                                            old('parent_id')==$item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
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
                                            <input id="thumbnail" class="form-control" type="text" name="photo">
                                        </div>
                                    </div>
                                    <div id="holder" style="margin:15px 0;max-height:100px;"></div>
                                </div>


                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <select class="form-control show-tick" name="status">
                                        <option value="">-- Status --</option>
                                        <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>active
                                        </option>
                                        <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>
                                            inactive</option>
                                    </select>
                                </div>


                                {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Condition</label>
                                    <select class="form-control show-tick" name="condition">
                                        <option value="">-- Condition --</option>
                                        <option value="banner" {{ old('condition')=='banner' ? 'selected' : '' }}>Banner
                                        </option>
                                        <option value="promo" {{ old('condition')=='promo' ? 'selected' : '' }}>
                                            Promotion</option>
                                    </select>
                                </div> --}}
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                                </div>
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
</script>

<script>
    $('#is_parent').change(function (e) {
    e.preventDefault();
    var is_check = $('#is_parent').prop('checked');

    if (is_check) {
        $('#parent_cat_id').addClass('d-none');
        $('#parent_cat_id').val('');
    } else {
        $('#parent_cat_id').removeClass('d-none');
    }
   });
</script>
@endsection

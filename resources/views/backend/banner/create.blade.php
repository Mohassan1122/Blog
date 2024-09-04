@extends('backend.layout.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                                class="fa fa-arrow-left"></i></a>Add Banner</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">Banner</li>
                        <li class="breadcrumb-item active">Add Banner</li>
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

                        <form class="form-auth-small" method="POST" action="{{ route('banner.store') }}">
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
                                        <label for="">Slug</label>
                                        <input type="text" class="form-control" placeholder="Title" name="slug"
                                            value="{{ old('slug') }}">
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
                                        <input id="thumbnail" class="form-control" type="text" name="photo">
                                    </div>
                                    <div id="holder" style="margin:15px 0;max-height:100px;"></div>
                                </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea id="description" class="form-control" name="description"
                                            placeholder="Last Name">{{
                                            old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Satus</label>
                                    <select class="form-control show-tick" name="status">
                                        <option value="">-- Status --</option>
                                        <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>active
                                        </option>
                                        <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>
                                            inactive</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Condition</label>
                                    <select class="form-control show-tick" name="condition">
                                        <option value="">-- Condition --</option>
                                        <option value="banner" {{ old('condition')=='banner' ? 'selected' : '' }}>Banner
                                        </option>
                                        <option value="promo" {{ old('condition')=='promo' ? 'selected' : '' }}>
                                            Promotion</option>
                                    </select>
                                </div>
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
        $('#description').summernote();
    });
</script>
@endsection

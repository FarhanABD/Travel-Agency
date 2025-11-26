@extends('admin.layout.master')

@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')

        <div class="main-content">
              <section class="section">
                <div class="section-header justify-content-between">
                    <h1>Create Slider</h1>
                    <div class="ml-auto">
                        <a href="{{ route('admin_slider_create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>

                    </div>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                   <form action="{{ route('admin_slider_create_submit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label>Photo</label>
            <input type="file" name="photo">
        </div>

        <div class="col-12 mb-3">
            <label>Heading</label>
            <input type="text" class="form-control" name="heading">
        </div>

        <div class="col-12 mb-3">
            <label>Text</label>
            <textarea class="form-control" name="text"></textarea>
        </div>

        <div class="col-12 mb-3">
            <label>Button Text</label>
            <textarea class="form-control" name="button_text"></textarea>
        </div>

        <div class="col-12 mb-3">
            <label>Button URL</label>
            <textarea class="form-control" name="button_url"></textarea>
        </div>

        <div class="col-12 mb-3">
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </div>
</form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
@extends('component::components.layout.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">aaaa</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">1111</a></li>
                        <li class="breadcrumb-item active">2222</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<h1>ádsadsd</h1>
    <x-component::input.ckeditor name="aaaa" value=""/>
</div>
@endsection()

@section('script')
@stack('c-script')
@endsection()

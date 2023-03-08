@extends('core::layout.admin')
@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>

                

            </div>
            
        </div>
        
    </div>


   
    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
        @csrf
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach(__language() as $index=>$ln)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link{{($index == 0) ? ' active': ''}}" data-bs-toggle="tab" href="#{{$ln->code}}" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">{{$ln->name}}</span>    
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content p-3 text-muted">
                    @foreach(__language() as $index=>$ln)
                    
                    <div class="tab-pane{{($index == 0) ? ' active show': ''}}" id="{{$ln->code}}" role="tabpanel">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-9">  
                                    <x-component::form.text name="name[{{$ln->code}}]" default="Name" value="{{json($item->name)[$ln->code]}}" id="name" key="all.name" placeholder="All.enter_name" defaultplaceholder="Enter your name"/>
                                    <x-component::input.ckeditor name="description[{{$ln->code}}]" default="Description" value="{{json($item->description)[$ln->code]}}" id="description" key="All.description" placeholder="All.enter_description" defaultplaceholder="Enter your description"/>
                                </div>
                                <div class="col-3">  
                                    <x-component::input.ckfinder name="image[{{$ln->code}}]" value="{{json($item->image)[$ln->code]}}" key="all.image" default="Image" id="ckfinder_{{$ln->code}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Save"  key="all.save"/>   
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>
@endsection()
@section('script')
@stack('c-script')
<script>
$(document).ready(function(){
   
})
</script>
@endsection()

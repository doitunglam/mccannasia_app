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


   
   

                <div class="row">
                    @foreach($items as $item)
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="{!! env('APP_URL').__transItem($item->image) !!}" onerror="this.src='{{asset('upload/no-image.png')}}'"alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">{{ __transItem($item->name) }}</h4>
                            <p class="card-text">{{ __transItem($item->short_content) }}</p>
                            <a href="{{route('campain.resuft', $item->id)}}" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.resuft', 'Resuft')}}</a>
                            
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

        
</div>
@endsection()
@section('script')
@stack('c-script')
<script>

</script>
@endsection()

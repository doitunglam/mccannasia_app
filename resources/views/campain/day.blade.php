<?php
    use App\Models\Banner;
    use App\Models\CampainItem;
    $bannes = Banner::all();
?>
@extends('core::layout.admin')
@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>

                

            </div>
            <div class="cat-slider border-bottom" style="margin-top: -28px;">
            @foreach($bannes as $b)
            <div class="cat-item px-1 py-3">
                <a class="bg-white rounded d-block p-2 text-center shadow" href="{{$b->link_}}">
                    <img style="width: 100%" src="{{asset($b->image)}}" class="img-fluid mb-2">
                </a>
            </div>	   
            @endforeach

            </div>
        </div>
        
    </div>


   
    <div class="card search_page">
        <div class="card-body">
            <form method="GET">
            <div class="d-flex flex-wrap gap-2">
                <div class="col-sm-2">
                    <x-component::form.text name="s_name" default="Name" value="{{request()->s_name}}" id="name" key="all.name" placeholder="all.enter_name" defaultplaceholder="Enter your name"/>
                </div>
                <button type="submit" class="btn btn-danger waves-effect waves-light add-new" style="height: 36px;margin-top: 26px;">Search</button>      
            </div>
            </form>
        </div>
    
    </div>

                <div class="row">

                    @foreach($items as $item)
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="{!! env('APP_URL').__transItem($item->image) !!}" onerror="this.src='{{asset('upload/no-image.png')}}'" alt="add alternative text here">
                        <div class="card-body">
						<?php
					
						$count = count(CampainItem::where('cid', $item->id)->get());
						?>
                            <h4 class="card-title">{{ __transItem($item->name) }}</h4>
                            <p class="card-text">{{__trans($language, 'All.registration_fee', 'Registration fee')}}: {{currency_format($item->registration_fee, 'đ')}}</p>
							<p class="card-text">{{__trans($language, 'All.subscriber_number', 'Subscriber number')}}: {{$count}}</p>
                            <a href="{{route('campain.register', $item->id)}}" class="btn btn-primary waves-effect waves-light">{{__trans($language, 'All.register', 'Register')}}</a>
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
$(document).ready(function(){

$('.cat-slider').not('.slick-slider').slick({
      centerMode: true,
      slidesToShow: 1,
      arrows: false,
      responsive: [{
              breakpoint: 768,
              settings: {
                  arrows: false,
                  centerMode: true,
                  slidesToShow: 1
              }
          },
          {
              breakpoint: 480,
              settings: {
                  arrows: false,
                  centerMode: true,
                  slidesToShow: 1
              }
          }
      ]
  });
});
</script>
@endsection()

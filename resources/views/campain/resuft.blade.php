@extends('core::layout.admin')
@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}} : {{__transItem($item->name)}}</h4>

                

            </div>
            
        </div>
        
    </div>

    <div class="card">
        <div class="card-body">
            <h5>{{__trans($language, 'All.description', 'Description')}}</h5>
                {!!__transItem($item->description)!!}
            <h5 style="margin-top: 20px;">{{__trans($language, 'All.Reason_for_cancellation', 'Reason for cancellation')}}</h5>
                {!!__transItem($item->reson_cancel)!!}
            <h5 style="margin-top: 20px;">{{__trans($language, 'All.registration_fee', 'Registration Fee')}}</h5>
            <p>
                {!!__transItem($item->registration_fee)!!}đ
            </p>
            <h5 style="margin-top: 20px;">{{__trans($language, 'All.price', 'Price')}}</h5>
            <p>
                {!!__transItem($item->price)!!}đ/ {{__trans($language, 'All.day', 'Day')}}
            </p>
            <h5 style="margin-top: 20px;">{{__trans($language, 'All.link', 'Link')}}</h5>
            <p>
                {{route('campain.link',['campain' => $info->code, 'use_' => $info->url])}}
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>{{__trans($language, 'All.resuft', 'resuft')}}
            
                
            </h5>
            @foreach($resuft  as $r)
                <h6>{{__trans($language, 'All.resuft', 'resuft')}}: {{$r->date}}
                
                    @if($r->status == 1)
                    <span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.appect', 'Appect')}}</span>
                    @elseif($r->status == 2)
                    <span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.not_appect', 'Not Appect')}}</span>
                    @else
                    <span class="badge rounded-pill badge-soft-primary">{{__trans($language, 'All.waiting', 'Waiting')}}</span>
                    @endif</h6>
                <div class="imgArrList">
                    <?php
                        $value = json_decode($r->resuft, true);
                    ?>
                    @foreach($value[0] as $v)
                    <img id="img_arr_prev" style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;" src="{{ $v }}" class="mx-auto h-auto w-full object-cover" alt="">
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
        @csrf
        <?php
            $tasks = json_decode($item->list_task, true);
        ?>
        @foreach($tasks as $index=>$task)
        @if($task)
        <?php 
            $value = '';
        ?>
        <div class="card">
            <div class="card-body">
                <h5>{{__trans($language, 'All.enter_today_s_results', "Enter today's results")}}: {{date('d-m-Y')}}</h5>
                <x-component::input.ckfinder-array id="task_{{$index}}" key="{{$task}}" name="resuft[{{$index}}][]" :value="$value"/>
            </div>
        </div>
        @endif
        @endforeach
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Register" key="all.register"/>   
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
    $('.add_task').click(function(){
        var parent = $(this).parent();
        var val = parent.find('input').val();
        if(val == '')return;
        for(var i = 0; i < $('.tab-pane').length; i++){
            var html = $('.tab-pane').eq(i).find('.get-html').html();
            $('.tab-pane').eq(i).find('.task-wrap').append(html);
        }
        parent.parent().find('.task-wrap .content-item').last().find('input').val(val);
    })
    
})
</script>
@endsection()

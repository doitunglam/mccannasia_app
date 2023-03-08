@extends('core::layout.admin')
@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{$title}} : {{__transItem($item->user_name)}}</h4>

                

            </div>
            
        </div>
        
    </div>


   
    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
        @csrf
        <input type="hidden" name="status" class="check-status"/>
        
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="mb-3">
                    <label class="form-label">{{ __trans($language, 'All.reason', 'Reason') }}: {{$item->name}}</label>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">{{ __trans($language, 'All.amount', 'Amount') }}: {{$item->amount}}</label>
                </div>
                @if($item->type == '')
                <div class="mb-3">
                    <label class="form-label">{{__trans($language, 'All.withdraw_money', 'Withdraw Money')}}</label>
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">{{__trans($language, 'All.recharge', 'Recharge')}}</label>
                </div>
                @endif
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary waves-effect waves-light appect" type="button">{{ __trans($language, 'all.appect', 'Appect') }}</button>
                            <button class="btn btn-danger waves-effect waves-light not_appect" type="button">{{ __trans($language, 'all.not_appect', 'Not Appect') }}</button>
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
    $('.array_add_click').remove();
    $('.resetArrImage').remove();
    $('.appect').click(function(){
        $('.check-status').val(1);
        $('.form-submit').submit();
    })
    $('.not_appect').click(function(){
        $('.check-status').val(2);
        $('.form-submit').submit();
    })
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

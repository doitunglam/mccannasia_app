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


   
    <form action="{{ route($route) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
        @csrf
        <div class="card">
            <div class="card-body">
                
                
                        <div class="col-12">
                            <div class="row">
                                <div class="col-9">  
                                    <x-component::form.text name="name" default="Reason" value="" id="reason" key="all.reason" placeholder="All.enter_reason" defaultplaceholder="Enter your reason"/>
                                    <x-component::form.text name="price" default="Price" value="" id="Price" key="all.price" placeholder="All.enter_price" defaultplaceholder="Enter your price"/>
                                    <div class="mb-3">
                                        <label for="slect" class="form-label">{{ __trans($language, 'All.slect', 'Select') }}</label>
                                        <select name="type" class="form-control get-type">
                                            <option value="" selected="">{{ __trans($language, 'All.withdraw_money', 'Withdraw money') }}</option>
                                            <option value="1">{{ __trans($language, 'All.recharge', 'Recharge') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">  
                                    
                                </div>
                            </div>
                        </div>
                    
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            <x-component::form.submit default="Save" key="all.save"/>   
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
    var amount = '{{Auth::user()->amount}}';
    $('#Price').change(function(){
        var val = $(this).val();
        if(amount < val && $('.get-type').val() == ''){
            alert('Max amount is :' + amount);
            $('input[name="price"]').val(1);
        }
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

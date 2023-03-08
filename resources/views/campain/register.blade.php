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


   
    <form action="{{ route($route, $item->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
        @csrf
        @if(isset($use_))
            <input type="hidden" name="use_" value="{{$use_}}"/>
        @endif
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
                </div>
            </div>
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex flex-wrap gap-2">
                            @if(!$info)
                            <x-component::form.submit default="Register" key="all.register"/>   
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>
<div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transaction-detailModalLabel">{{__trans($language, 'All.tranfer_info', 'Tranfer Info')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                @foreach( $config as $index => $n)
                <?php
                    $info = json($n->name);
                ?>
                <div style="border-bottom: 1px solid #ddd;position: relative">
                    <p class="mb-2" style="margin-top: 10px;font-weight: bold">{{__trans($language, 'All.name', 'Name')}}: <span class="text-primary">{!!$info['name']!!}</span></p>    
                <p class="mb-2" style="margin-top: 10px;font-weight: bold">{{__trans($language, 'All.bank_name', 'Bank Name')}}: <span class="text-primary">{!!$info['bank']!!}</span></p>
                <p class="mb-4" style="margin-bottom: 9px !important;font-weight: bold">{{__trans($language, 'All.bank_account', 'Bank Account')}}: <span class="text-primary">{!!__transItem($n->value)!!}</span></p>
                <img src="{{asset($n->image)}}" style="position: absolute; top: -16px;right: 0;height: 61px;"/>
            </div>
                @endforeach
                <p class="mb-4" style="margin-top: 10px;font-weight: bold">{{__trans($language, 'All.Amount', 'Amount')}}: <span class="text-primary">{!!__transItem($item->registration_fee)!!}đ</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success done-payment" data-bs-dismiss="modal">{{__trans($language, 'All.done', 'Done')}}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__trans($language, 'All.close', 'Close')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection()
@section('script')
@stack('c-script')
<script>
$(document).ready(function(){
    
    $('.done-payment').click(function(){
        var fd = new FormData();
		fd.append('price', {{$item->registration_fee}});
		fd.append('type',1);
        $.ajax({
			type: 'post',
			url: "{{route('home.base')}}"+'/admin/payment/done',
            contentType: false,
			data: fd,
            processData: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			traditional: true,
			success: function (data) {

			}
		});
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

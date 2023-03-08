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
                <div class="col-12">
                    <div class="row">
                        
                        <div class="col-9">  
                            <x-component::form.text :messages="$errors->get('name')" name="name" default="Name" value="{{$item->name}}" id="name" key="all.name" placeholder="all.enter_name" defaultplaceholder="Enter your name"/>
                            <x-component::form.text :messages="$errors->get('code')" name="code" default="Code" value="{{$item->code}}" id="code" key="all.code" placeholder="all.enter_code" defaultplaceholder="Enter your code"/>
                            <x-component::form.text messages="" name="add_page" default="Name page" value="" id="add_page" key="all.name_page" placeholder="all.enter_name_page" defaultplaceholder="Enter your name page"/>
                            <span class="add_page badge rounded-pill badge-soft-primary" style="cursor: pointer">{{__trans($language, 'All.add_page', 'Add Page')}}</span>    
                        </div>
                        <div class="col-3">  
                            <x-component::input.ckfinder name="image" value="{{$item->image}}" key="all.image" default="Image" id="ckfinder"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="get-content-html" style="display:none">
            <div class="row content-item" style="margin: 10px -15px 0 -15px; ">
                <div class="col-6">
                    <input type="text" class="form-control content-language" name="" value=""/>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control get-key" value=""/>    
                </div>
            </div>
        </div>
        <div class="wrap-pages">
            @if(count($data_en) > 0)
            @foreach($data_en as $key => $value)
            <div class="card item-page{{($key == 'All') ? ' get-page' : ''}}" data-page="{{$key}}">
                
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Name page: <span class="name-page">{{$key}}</span></label>
                                <input type="text" class="form-control get-value-content" placeholder="{{__trans($language, 'all.enter_key_language','Enter your content language')}}" style="margin: 10px 0; "/> 
                                <span class="add_language badge rounded-pill badge-soft-primary" style="cursor: pointer">{{__trans($language, 'All.add_language', 'Add Language')}}</span>   
                            </div>
                            <div class="col-9">
                                <div class="row" style="">
                                    <div class="col-6">
                                        <label class="form-label">Content</label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Key</label> 
                                    </div>
                                </div>
                                <div class="content-key">
                                    @foreach($value as $key_ => $value_)
                                    <div class="row content-item" style="margin: 10px -15px 0 -15px; ">
                                        <div class="col-6">
                                            <input type="text" class="form-control content-language" name="language[{{$key}}][{{$key_}}]" value="{{ (isset($data[$key][$key_])) ? $data[$key][$key_] : '' }}"/>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control get-key" value="{{$key_}}"/>    
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
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
    $('.add_page').click(function(){
        var parent = $(this).parent();
        var val = parent.find('#add_page').val();
        if(val == '')return;
        var html = $('.get-page').html();
        $('.wrap-pages').append('<div class="card item-page" data-page="'+val+'">'+html+'</div>');
        var item = $('.item-page').last();
        item.find('.name-page').html(val);
        item.find('.content-key').html('');
    })
    $('body').on('click', '.add_language', function(){
        var parent = $(this).parent().parent().parent().parent().parent();
        var val = parent.find('.get-value-content').val();
        if(val == '')return;
        parent.find('.get-value-content').val('');
        var page = parent.attr('data-page');
        var html = $('.get-content-html').html();
        parent.find('.content-key').append(html);
        var key = page+'.'+val.toLowerCase().replace(/ /g, '_');
        var name = 'language['+page+']['+key+']';
        var item = parent.find('.content-key .content-item').last();
            item.find('.content-language').val(val);
            item.find('.content-language').attr('name', name);
            item.find('.get-key').val(key);
    });
    $('body').on('change', '.get-key', function(){
        var parent = $(this).parent().parent();
        var key = $(this).val();
        parent.find('.content-language').attr('name', key);
    })
})
</script>
@endsection()


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
    <iframe src="" style="width: 0 !important; height: 0 !important; height" title="W3Schools Free Online Web Tutorials" class="dowload-file"></iframe>
    <div class="card search_page">
        <div class="card-body">
            <form method="GET" action=""  enctype="multipart/form-data" style="position: relative;z-index: 1;">
                @csrf
            <div class="d-flex flex-wrap gap-2">
                <div class="col-sm-2">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__trans($language, 'All.name', 'Tên')}}</label>
                        <input type="text" class="form-control s_name" id="name" placeholder="" name="s_name" value="{{request()->s_name}}">
                    </div> 
                </div>
                <button type="submit" class="btn btn-danger waves-effect waves-light" style="height: 36px;margin-top: 26px;">{{__trans($language, 'All.search', 'Search')}}</button>      
                     
            </div>
        </form>
        <div class="d-flex flex-wrap gap-2" style="margin-top: -77px;">
            <div class="col-sm-2"></div>
            <div class="col-sm-2"> <button type="button" class="btn btn-primary waves-effect waves-light get-download" style="height: 36px;margin-top: 23px;margin-left: 79px;position: relative;z-index: 10;">{{__trans($language, 'All.export', 'Export')}}</button></div>
        </div>
    
    </div>
   
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                                <tr style="cursor: pointer;">
                                    @foreach($td as $i)
                                    <th>{{ $i['title'] }}</th>
                                    @endforeach
                                    <th>{{__trans($language, 'All.id_user', 'ID user')}}</th>
                                    <th>{{__trans($language, 'All.type', 'Type')}}</th>
                                    <th>{{__trans($language, 'All.status', 'Status')}}</th>
                                    <th>{{__trans($language, 'All.created_at', 'Created At')}}</th>
                                    <th>{{__trans($language, 'All.review_date', 'Review date')}}</th>
                                    <th>{{__trans($language, 'All.edit', 'Edit')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr data-id="1" style="cursor: pointer;">
                                    @foreach($td as $i)
                                    <?php
                                        $key = $i['value'];
                                    ?>
                                    @if(isset($i['type']) && $i['type'] == 'image')
                                        <td style=""><img style="height: 150px; width: auto" src="{!! env('APP_URL').__transItem($item->$key) !!}"/></td>
                                    @else
                                        <td style="">{{ __transItem($item->$key) }}</td>
                                    @endif
                                    @endforeach
                                    <td style="">{{ $item->user }}</td>
                                    @if($item->type == '')
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.withdraw_money', 'Withdraw Money')}}</span></td>	
									@else
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.recharge', 'Recharge')}}</span></td>
                                    @endif

                                    @if($item->status == 1)
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.appect', 'Appect')}}</span></td>	
									@elseif($item->status == 2)
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.not_appect', 'Not Appect')}}</span></td>		
									@else
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-primary">{{__trans($language, 'All.waiting', 'Waiting')}}</span></td>
                                    @endif
                                    <td style="">{{ $item->created_at }}</td>
                                    <td style="">{{ $item->updated_at }}</td>
                                    <td style="width: 30px">
                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route($route, $item->id)}}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection()
@section('script')
<script>
$('.get-download').click(function(){
    var url = "{{route('campain.download',['s_name' => request()->s_name])}}";
    $('.dowload-file').attr('src', url);
})
</script>
@stack('c-script')
@endsection()


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
                                    <th>{{__trans($language, 'All.status', 'Status')}}</th>
                                    <th colspan="1">{{__trans($language, 'All.edit', 'Edit')}}</th>
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
                                    @if($item->status == 1)
									<td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.appect', 'Appect')}}</span></td>	
									@elseif($item->status == 2)
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.not_appect', 'Not Appect')}}</span></td>		
									@else
                                    <td data-field="name" style="width: 50px;"><span class="badge rounded-pill badge-soft-default">{{__trans($language, 'All.unavailable', 'Unavailable')}}</span></td>		
                                    @endif
                                    <td style="width: 30px">
                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route($route, ['id'=>$item->campain, 'user'=> $item->user ])}}" title="Edit">
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
@endsection()
@section('script')
@stack('c-script')
@endsection()

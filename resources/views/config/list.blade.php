
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
                                    <th>{{__trans($language, 'All.name', 'Name')}}</th>
                                    <th>{{__trans($language, 'All.bank', 'Bank')}}</th>
                                    <th>{{__trans($language, 'All.status', 'Status')}}</th>
                                    <th colspan="2">{{__trans($language, 'All.edit', 'Edit')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr data-id="1" style="cursor: pointer;">
                                    <?php
                                        $info = json($item->name);
                                    ?>
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
                                    <td style="">{{isset($info['name']) ? $info['name'] : '' }}</td>
                                    <td style="">{{isset($info['bank']) ? $info['bank'] : '' }}</td>
                                    @if($item->status == 1)
									<td data-field="name" style="width: 50px;"><a href="{{route($status, $item->id)}}"><span class="badge rounded-pill badge-soft-success">{{__trans($language, 'All.available', 'Available')}}</span></a></td>	
									@else
									<td data-field="name" style="width: 50px;"><a href="{{route($status, $item->id)}}"><span class="badge rounded-pill badge-soft-danger">{{__trans($language, 'All.unavailable', 'Unavailable')}}</span></a></td>		
									@endif
                                    <td style="width: 30px">
                                        <a class="btn btn-outline-secondary btn-sm edit" href="{{ route($update, $item->id)}}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    
                                    <td style="width: 30px">
                                    <form action="{{ route($delete, $item->id)}}" method="post">
                                      {{ csrf_field() }}
                                      @method('DELETE')
                                      <button class="btn btn-outline-danger btn-sm btn-delete" type="button"><i class="fa fa-trash"></i></button>
                                    </form>
                                        
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
<script>
    $(document).ready(function(){
        $(".btn-delete").click(function(){
            item = $(this);
            var r = confirm("Are you sure delete this item!");
            if (r == true) {
                item.parent().submit();
            } else {
                
            }
        });
    });
    </script>
@stack('c-script')
@endsection()

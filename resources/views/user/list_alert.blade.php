<?php
use App\Models\Language;
use App\Models\Nation;
use App\Models\CountryData;
$country = Nation::all();
$ln = Language::find(Auth::user()->language_id);
$ln = json_decode($ln->label_, true);
?>
@extends('layouts.app')
   
@section('content')
	<div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>

                                    <div class="page-title-right">
                                       <a href="{{route($create)}}" class="btn btn-danger waves-effect waves-light">Thêm mới</a>
                                    </div>

                                </div>
                            </div>
                        </div>
						
						<div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-editable table-nowrap align-middle table-edits">
                                                <thead>
                                                    <tr style="cursor: pointer;">
                                                        <th>{{isset($ln['id']) ?  $ln['id'] : 'ID'}}</th>
														<th style="text-align:center">{{isset($ln['name']) ?  $ln['name'] : 'Name'}}</th>
														<th style="text-align:center">{{isset($ln['email']) ?  $ln['email'] : 'Email'}}</th>
														<th style="text-align:center">{{isset($ln['phone']) ?  $ln['phone'] : 'Phone'}}</th>
														<th style="text-align:center">{{isset($ln['gender']) ?  $ln['gender'] : 'Gender'}}</th>
														<th style="text-align:center">{{isset($ln['address']) ?  $ln['address'] : 'Address'}}</th>
														<th style="text-align:center">{{isset($ln['created_at']) ?  $ln['created_at'] : 'Created at'}}</th>
														<th colspan="1" style="text-align: center">Alert</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												
												<form method="GET" class="search-form">
													<tr data-id="1" style="cursor: pointer;">
														<td data-field="id" style="width: 80px"></td>
														<td>
														<input id="f_name" name="f_name" type="text" class="form-control get-val-search search-change" placeholder="{{isset($ln['name']) ?  $ln['name'] : 'Name'}}">
														</td>
														<td>
														<input id="f_email" name="f_email" type="text" class="form-control get-val-search search-change" placeholder="{{isset($ln['email']) ?  $ln['email'] : 'Email'}}">
														</td>
														<td>
														<input id="f_phone" name="f_phone" type="text" class="form-control get-val-search search-change" placeholder="{{isset($ln['phone']) ?  $ln['phone'] : 'Phone'}}">
														</td>
														<td style="width: 120px;">
															<select name="f_gender" class="form-control search-change" style="text-align: center;">
																
																<option value="Male">Male</option>
																<option value="Female">Female</option>
																
															</select>
														</td>
														
														<td style="width: 30px"></td>
														<td style="width: 30px"></td>
													
														<td style="width: 30px"></td>
													</tr>
												</form>
												@foreach($items as $item_)
                                                    <tr data-id="1" style="cursor: pointer;">
                                                        <td data-field="id" style="width: 80px">{{$item_->id}}</td>
														<td>
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->name}}</a></h5>
														
														</td>
														<td>
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->email}}</a></h5>
														
														</td>
														<td>
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->phone}}</a></h5>
														
														</td>
														<td style="text-align:center">
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->gender}}</a></h5>
														
														</td>
														<td>
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{$item_->address}}</a></h5>
														
														</td>
													
													
														<td>
                                                        <h5 class="text-truncate font-size-14"><a href="javascript: void(0);" class="text-dark">{{date('d-m-Y', strtotime($item_->created_at))}}</a></h5>
														
														</td>
                                                        <td style="width: 30px;padding: 0;text-align: center;">
                                                            <a class="edit badge rounded-pill badge-soft-success" href="{{ route('alert', $item_->id)}}" title="Edit">
                                                                <i class="fas fa-bell"></i>
                                                            </a>
                                                        </td>
														
												@endforeach
                                                </tbody>
                                                </table>
                                        </div>
        
                                    </div>
                                </div>
								
                    </div>
                    
                

@endsection  
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
	@foreach($search as $key_ => $s)
		@if(isset($search[$key_]))
			$('input[name="{{$key_}}"], select[name="{{$key_}}"]').val('{{$search[$key_]}}');
		@endif
	@endforeach
	
	$('.search-change').change(function(){
		$('.search-form').submit();
	})
});
</script>
@endsection  
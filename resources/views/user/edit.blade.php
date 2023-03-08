<?php
use App\Models\Language;
use App\Models\Type;
use App\Models\Nation;
use App\Models\User;
$lang = (session('locale') ? session('locale') : 'en');
$ln = Language::where('code', $lang)->first();
$ln = json_decode($ln->label_, true);
?>
@extends('core::layout.admin')
   
@section('content')
	<div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>
                                    <div class="page-title-right">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

						<form action="{{ route($store, $model->id) }}" method="POST" class="form-submit" enctype="multipart/form-data">	
                        @csrf
						<div class="row">
							<div class="row">
								<div class="col-12">
									
									
									<div class="card">
										<div class="card-body">
											
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Tên hiển thị</label>
															<input id="productname" name="display" type="text" value="{{$model->name}}" class="form-control" value="" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Email</label>
															<input id="productname" name="username" type="text" value="{{$model->email}}" class="form-control" value="" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Password</label>
															<input id="productname" name="password" type="password" class="form-control" value="" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Số điện thoại</label>
															<input id="productname" name="phone" type="text" class="form-control" value="{{$model->phone}}" autocomplete="off">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Địa chỉ</label>
															<input id="productname" name="address" type="text" class="form-control" value="{{$model->address}}" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Gender</label>
															<select name="gender" class="form-control" id="gender">
															
																<option value="Male" {{('Male' == $model->gender) ? ' selected' : ''}}>Male</option>
																<option value="Female" {{('Female' == $model->gender) ? ' selected' : ''}}>Female</option>
														
															</select>
														</div>
													</div>
												</div>
												
												
												<div class="col-sm-6">
														
													<div class="mb-3">
														<label for="formFile" class="form-label">Image</label>
														<input class="form-control change-img" type="file" name="image" id="formFile">
														<input class="form-control" type="hidden" name="type_" value="{{$model->type}}">
													</div>
													<div class="mb-3">                                                  
														<img src="{{($model->img != '') ? asset($model->img) : ''}}" style="width: 50px; height: auto;margin-top: 27px;" class="show-flag"/>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Bank Account</label>
															<input id="productname" name="bank_account" type="text" class="form-control" value="{{$model->bank_account}}" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Bank Name</label>
															<input id="productname" name="name_bank" type="text" class="form-control" value="{{$model->name_bank}}" autocomplete="off">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="mb-3">
															<label for="productname">Link</label>
															<input id="productname" name="" type="text" class="form-control" value="{{route('home.base.introduce', md5($model->id))}}" autocomplete="off">
														</div>
													</div>
												</div>
												
												
										</div>
									</div>
									
									<div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                                
                                        </div>
                                    </div>

                                </div>
								</div>
								
                            </div>
								
                                
        
                                
                            </div>
                        </div>
                        </form>

                    </div>
                    
                

@endsection  
@section('script')
<script>
$(document).ready(function(){
	
	$('#position').change(function(){
		var val = $(this).val();
		if(val == 1){
			$('.show-manager_id').css('display','block');
		}else{
			$('.show-manager_id').css('display','none');
		}
	})
	$('#position').change();
	
	$('.none-select').css('display','none');
	$('.show-position').css('display','none');
	$('.manager_id').select2();


	$('body').on('change', '#roles', function(){
		var value = $(this).val();
		$('.show-position').css('display','none');
		if(value.indexOf('coach') != -1 || value.indexOf('coachees') != -1){
			$('.show-position').css('display','block');
		}
		$('.show-manager_id').css('display','none');
		
		if(value.indexOf('coachees') != -1){
			$('.show-manager_id').css('display','block');
		}
	})
	$('.project').select2({
		placeholder: "Chọn dự án",
		allowClear: true
	});
	var level;
	var first = 1;
	function getUser(){
		var SendInfo = {
			level: $('#level').val(),
			country: $('#country').val(),
			region: $('#region').val(),
			sanitary_zone: $('#sanitary_zone').val(),
			health_center: $('#health_center').val()
		}
		$.ajax({
			type: 'post',
			url: url+'/get/user/select',
			data: JSON.stringify(SendInfo),
			contentType: "application/json; charset=utf-8",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			traditional: true,
			success: function (data) {
				$('#manager_id').html(data);
				$('#manager_id').val({{$model->manager_id}});
				$('#manager_id').select2();
			}
		});
	}
	
	
	$('body').on('change', '#region', function(){
		var id = $(this).val();
		$.ajax({
			type: 'post',
			url: url+'/get/region/son/'+id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			traditional: true,
			success: function (data) {
				$('#sanitary_zone').html(data);
				$('#sanitary_zone').val({{$model->sanitary_zone}});
				$('#sanitary_zone').change();
				if(level == 'Region'){
					getUser();
				}
			}
		});
	})
	$('body').on('change', '#health_center', function(){
		if(level == 'District'){
			health_center();
		}
		
	})
	$('body').on('change', '#sanitary_zone', function(){
		var id = $(this).val();
		$.ajax({
			type: 'post',
			url: url+'/get/region/sanitary-zone/'+id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			traditional: true,
			success: function (data) {
				if(level == 'District'){
					getUser();
				}
				$('#health_center').html(data);
				$('#health_center').val({{$model->health_center}});
				$('#health_center').change();
			}
		});
	})
	$('body').on('change', '#country', function(){
		var id = $(this).val();
		$.ajax({
			type: 'post',
			url: url+'/get/region/'+id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			traditional: true,
			success: function (data) {
				$('#region').html(data);
				$('#region').val({{$model->region}});
				$('#region').change();
			}
		});
	})
	
	$('#country').change();
	$('body').on('change', '#level', function(){
		var val = $(this).val();
		level = val;
		var class_ = '.open-'+val;
		$('.none-select').css('display','none');
		$(class_).css('display','block');
		var html = '<option value="coachees">{{isset($ln["coachees"]) ?  $ln["coachees"] : "Coachees"}}</option>';
		html = html+'<option value="coach">{{isset($ln["coach"]) ?  $ln["coach"] : "Coach"}}</option>';
		html = html+'<option value="investigators">{{isset($ln["investigators"]) ?  $ln["investigators"] : "Investigators"}}</option>';
		if(val == 'National'){
			html = '<option value="coach">{{isset($ln["coach"]) ?  $ln["coach"] : "Coach"}}</option>';
		}
		if(val == 'health_center'){
			html = '<option value="coachees">{{isset($ln["coachees"]) ?  $ln["coachees"] : "Coachees"}}</option>';
			html = html+'<option value="investigators">{{isset($ln["investigators"]) ?  $ln["investigators"] : "Investigators"}}</option>';
		}
		$('#roles').html(html);
		
		var val_ = JSON.parse('{!!$model->position_name!!}');
		
		$('#roles').val(val_);
		$('#roles').select2();
		$('#roles').change();
		$('#country').change();
	})
	$('#level').val("{{$model->level}}");
	$('#level').change();
	
	
	
	$('body').on('change', '.change-img', function(){
	
		
		var input = this;
		var parent = $(this).parent().parent();
		var url = $(this).val();
		
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
			   parent.find('.show-flag').attr('src', e.target.result);
			}
		   reader.readAsDataURL(input.files[0]);
		}
		
	});
	var parent;
	var edit = 0;
	$('body').on('click', '.edit-module', function(){
		edit = 1;
		parent = $(this).parent().parent();
		var name = parent.find('.get_module_name').val();	
		var time = parent.find('.get_module_time').val();
		var description = parent.find('.get_module_description').val();
		$('.module_name').val(name);	
		$('.module_time').val(time);	
		$('.module_description').val(description);	
		
	})
	$('body').on('click', '.cancel-module', function(){
		edit = 0;
		$('.module_name').val('');		   
		$('.module_time').val('');		   
		$('.module_description').val('');	
	})
	$('body').on('click', '.delete-module', function(){
		item = $(this);
		var r = confirm("Are you sure delete this item!");
		if (r == true) {
			$(this).parent().parent().css('display','none');
			$(this).parent().parent().find('.get-module-delete').val(1);
		} else {
			
		}
	})
	
	$('body').on('click', '.add-module', function(){
		if(edit == 0){
			var name = $('.module_name').val();	
			var time = $('.module_time').val();	
			var description = $('.module_description').val();	
			var length = $('.module-item').length + 1;
			var html = '<tr class="module-item">'+
						'<td><input type="hidden" name="module_name[]" class="get_module_name" value="'+name+'"/><input type="hidden" name="module_id[] value="0"/><span class="show_name">'+name+'</span></td>'+	
						'<td><input type="hidden" name="module_time[]" class="get_module_time" value="'+time+'"/><span class="show_time">'+time+'</span></td>'+	
						'<td><input type="text" value="'+length+'" name="module_order[]"/></td>'+	
						'<td style="width: 50px;"><input type="hidden" name="module_description[]" class="get_module_description" value="'+description+'"/><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light delete-module">'+	
							'<i class="fa fa-trash"></i>'+	
							'</button>'+
						'</td>'+
						'<td style="width: 50px;"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light edit-module">'+	
							'<i class="fas fa-pencil-alt"></i>'+	
							'</button>'+
						'</td>'+
					   '</tr>';
			$('.list-module').append(html);	
		}else{
			edit = 0;
			var name = $('.module_name').val();	
			var time = $('.module_time').val();	
			var description = $('.module_description').val();
			parent.find('.get_module_name').val(name);
			parent.find('.get_module_time').val(time);
			parent.find('.get_module_description').val(description);
			parent.find('.show_name').html(name);
			parent.find('.show_time').html(time);
		}		
		$('.module_name').val('');		   
		$('.module_time').val('');		   
		$('.module_description').val('');		
		
	})
	
});
</script>
<script>
$(document).ready(function(){
	$('body').on('change', '.change-img', function(){
	
		
		var input = this;
		var parent = $(this).parent();
		var url = $(this).val();
		
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
			   parent.find('.show-img').attr('src', e.target.result);
			}
		   reader.readAsDataURL(input.files[0]);
		}
		
	});
	for(var i = 0; i < $('.get-id-editor').length; i++){
		var id_ = $('.get-id-editor').eq(i).attr('id');
		tinymce.init({selector:"textarea#"+id_,height:300,plugins:["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor"],toolbar:"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]})
	}
	for(var i = 0; i < $('.get-id-color').length; i++){
		var id_ = $('.get-id-color').eq(i).attr('id');
		
		$("#"+id_).spectrum();
	
	}
	$('.multiple-image').change(function(){
		var files = event.target.files;
		var parent = $(this).parent();
		parent.find('.show_image').html('');
		
		if (files) {

			for (var i = 0; i < files.length; i++) {
			var file = files[i];
			if (!file.type.match('image')) continue;
			var picReader = new FileReader();
			picReader.addEventListener("load", function (event) {
				var picFile = event.target;
				var img = '<div class="dz-preview dz-processing dz-image-preview dz-error dz-complete"><div class="dz-image">';
				img = img + '<img data-dz-thumbnail="" alt="1630339859.jpg" style="width: 100%;" src="' + picFile.result +'"/>';
				img = img + '</div></div>';
				
				parent.find('.show_image').append(img);
			});
				//Read the image
				picReader.readAsDataURL(file);
			}
		}
	})

	
});
</script>
@endsection  
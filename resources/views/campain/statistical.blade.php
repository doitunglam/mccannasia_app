<?php
use App\Models\Campain;
use App\Models\CampainItem;
use Goeasyapp\Core\Http\Repositories\CampainRepository;
$ca = new Campain;
$model = new CampainRepository($ca);
?>
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


   
   

                
                @foreach($items as $item)
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <h5>{{__trans($language, 'All.campain', 'Campain')}}: {{$item->name}}</h5>
                                <?php 
                                    $id = (isset($id)) ? $id : Auth::user()->id;
                                    $item_ = CampainItem::where('uid', $id)->where('cid', $item->id)->first();
                                    if($item_){
                                        $level = 1;
                                        $items  = CampainItem::where('use_', $item_->url)->where('cid', $item->id)->get();
                                        $model->getSon($items, $level);
                                    }
                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
                @endforeach
            

        
</div>
@endsection()
@section('script')
@stack('c-script')
<script>

</script>
@endsection()

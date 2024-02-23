@extends('admin.layout')
@section('title','Dashbaord')

@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
		   @php
			$menu_results = App\Menu::get_menu_dashboard();
		  @endphp	
         @if($menu_results)
      
                    @foreach($menu_results as $key=>$val)
                
                      @if($val->status =='active')
					     @php
                         $ftable  = $val->menu_table;
						 @endphp
                      @if($ftable!="")
					     @php
                          $table_count = App\Menu::menu_count_table($ftable);
						  @endphp
                      @else
					    @php
                         $table_count=0;
						 @endphp
                     @endif
                   	 
          <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="background-color:{{$val->color}} !important;">
              <div class="inner">
                <h3>{{$table_count}}</h3>
                <p>{{$val->name}}</p>
              </div>
              <div class="icon">
                <i class=" fa fa-{{$val->icon}} widget-stat-icon"></i>
              </div>
              <a href="{{url('admin').'/'.$val->url}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		
              @endif
            @endforeach
         @endif
        
 		
        </div>

      </div>
    </section>
	@endsection
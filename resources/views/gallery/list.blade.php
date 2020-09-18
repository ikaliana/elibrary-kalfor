@extends('layouts.app')

@section('css')
	<style type="text/css">
		.gallery-title {
			margin: 5px;
			padding: 0;
			font-weight: bold;
			text-align: left;
		}
		.btn-add {
			padding: 10px 20px;
		}
	</style>
@endsection

@section('main_content')
	<h2 class="title">
		Galleries
		<a class="btn btn-primary btn-sm float-right btn-add" href="{{route('gallery.create')}}">
			<i class="now-ui-icons ui-1_simple-add"></i>
		</a>
		<hr>
	</h2>

	<div id="gallery-container">
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
			@foreach($list as $gallery)
				<div class="col mb-4">
					<div class="card h-100">
						<!--div class="card-header">
							Featured
						</div-->
						<div class="card-body">
							<h5 class="card-title">
								<a href="{{route('gallery.show', $gallery['id'])}}" class="btn btn-neutral gallery-title">{{ $gallery['name'] }}</a>
							</h5>
							<span class="gallery-desc">{!! \Illuminate\Support\Str::words($gallery['description'], 35,'....')  !!}</span>
						</div>
					</div>
				</div>
	        @endforeach
		</div>
	</div>

@endsection
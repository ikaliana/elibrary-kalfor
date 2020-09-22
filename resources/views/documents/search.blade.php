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
		li.media {
			padding-bottom: 20px;
		}
	</style>
@endsection

@section('main_content')
	@include('documents.filter')

	<h2 class="title">
		Search result
		<hr>
	</h2>

	<p>Searching for <span style="font-weight: bold;">'{{ $key }}'</span>. Found {{ count($list) }} document(s) matching the search query.</p>

	<div id="document-container">
		<div class="row row-cols-1">
			<ul class="list-unstyled">
			@foreach($list as $doc)
				@php
					$category_class = "category-0";
					if($doc['category'] != 0) $category_class .= " category-".$doc['category'];
				@endphp
				<li class="media {{ $category_class }}">
					<img src="{{ asset('img/icons/icons8-'.$doc['icon'].'-64.png') }}" class="mr-3" alt="{{ $doc['icon'] }} file">
					<div class="media-body">
						<a href="{{ route('documents.show', $doc['id'] ) }}" target="_blank">
							<h5 class="my-0 doc-title">{{ $doc['name'] }}</h5>
						</a>
						<span class="font-italic font-weight-bold">In gallery 
							@if($doc['gallery_id']) 
							<a href="{{route('gallery.show', $doc['gallery_id'])}}" class="text-info my-0 font-weight-normal" target="_blank">
								"{{ $doc['gallery_name'] }}"
							</a>
							@endif
						</span>
						<span class="d-block mt-1">{{ $doc['description'] }}</span>
					</div>
				</li>
	        @endforeach
	        </ul>
		</div>
	</div>

@endsection

@section('js')

	@include('documents.filterjs')

@endsection
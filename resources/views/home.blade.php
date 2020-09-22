@extends('layouts.master')

@section('content')
	<div class="section text-center" style="background-image: linear-gradient(#fefefe, white, #f2f2f2); padding-bottom: 50px;">
    <div class="container">
        <p>&nbsp;</p>
      <h2 class="title">Document search</h2>
      <div class="row">
        <div class="col-lg-6 text-center col-md-8 ml-auto mr-auto">
          <form method="GET" action="{{ route('documents.search') }}">
            <div class="input-group input-lg">
              <div class="input-group-prepend">
                <span class="input-group-text border border-right-0">
                  <i class="now-ui-icons ui-1_zoom-bold"></i>
                </span>
              </div>
              <input id="q" name="q" type="text" class="form-control border border-left-0" placeholder="Enter keywords...">
            </div>
            <div class="send-button">
              <button type="submit" class="btn btn-primary btn-round btn-lg">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
    
  <div class="section" style="padding-top: 50px;padding-bottom: 120px;">
    <div class="container">
      <h2 class="title text-center">E-Library Latest documents</h2>
      <div class="row row-cols-1">
@if (count($list) > 0)
        <ul class="list-unstyled col-md-9 ml-auto mr-auto">
        @foreach($list as $doc)
          <li class="media pb-1">
            <img src="{{ asset('img/icons/icons8-'.$doc['icon'].'-64.png') }}" class="mr-3" alt="{{ $doc['icon'] }} file">
            <div class="media-body">
              <a href="{{ route('documents.show', $doc['id'] ) }}">
                <h5 class="my-0 doc-title">{{ $doc['name'] }}</h5>
              </a>
              <span class="font-italic font-weight-bold">In gallery: 
                <a href="{{route('gallery.show', $doc['gallery_id'])}}" class="text-info my-0 font-weight-normal" target="_blank">
                  {{ $doc['gallery_name'] }}
                </a>
              </span>
              <span class="d-block mt-1">{{ $doc['description'] }}</span>
            </div>
          </li>
        @endforeach
        </ul>
@else
        <p class="text-center">No new documents in this library</p>
@endif
      </div>
    </div>
  </div>

@endsection
	

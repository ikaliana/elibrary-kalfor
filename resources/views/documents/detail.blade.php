@extends('layouts.app')

@section('css')
	<style type="text/css">
		h4.title { padding-top: 15px; }
		h2 img { margin-top: -4px; width: 32px; }
	</style>
@endsection

@section('main_content')
	<h2 class="title pl-5 mb-1">
		<img src="{{ asset('img/icons/icons8-'.$item['icon'].'-64.png') }}" alt="{{ $item['icon'] }} file" class="ml-n5">
		<span>{{ $item['name'] }}</span>
	</h2>
	<hr>

	<div id="gallery-content">
		<p>{{ $item['description'] }}</p>
	</div>

	@php
		//taken from here: https://www.php.net/manual/en/function.filesize.php#120250
		$bytes = $item['filesize'];
		$decimals  = 2;
		$factor = floor((strlen($bytes) - 1) / 3);
		if ($factor > 0) $sz = 'KMGT';
		$strsize = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor - 1] . 'B';
	@endphp

	<dl class="row">
		<dt class="col-sm-3"><strong>Gallery</strong></dt>
		<dd class="col-sm-9">
			@if($item['gallery_id'])
			<a href="{{route('gallery.show', $item['gallery_id'])}}" target="_blank" class="text-info">
				{{ $item['gallery_name'] }}
			</a>
			@else
			N/A
		</dd>
		@endif
		<dt class="col-sm-3"><strong>Type</strong></dt>
		<dd class="col-sm-9">{{ $type }}</dd>
		<dt class="col-sm-3"><strong>Filename</strong></dt>
		<dd class="col-sm-9">{{ $item['filename'] }}</dd>
		<dt class="col-sm-3"><strong>Format</strong></dt>
		<dd class="col-sm-9">{{ $item['fileformat'] }}</dd>
		<dt class="col-sm-3"><strong>Size</strong></dt>
		<dd class="col-sm-9">{{ $strsize }}</dd>
	</dl>

	@php
		$filepath = null;
		if(!$item['gallery_id']) 
			$filepath = $item['filepath'];
		else
			if($item['filepath']) $filepath = asset('doc_repository/'.$item['gallery_id'].'/'.$item['filename']);
	@endphp


	<div id="gallery-footer">
		<p align="center">
			@if($type == 'Document')
			<a class="btn btn-primary btn-preview" href="https://docs.google.com/viewer?embedded=true&url={{ $filepath }}" target="_blank">
				<i class="far fa-eye"></i> Preview
			</a>
			@endif
			<!-- <button type="button" class="btn btn-primary btn-download">
				<i class="fas fa-download"></i> Download
			</button> -->
			<a class="btn btn-primary btn-download" href="{{ $filepath }}" target="_blank">
				<i class="fas fa-download"></i> Download
			</a>
			<button type="button" class="btn btn-primary btn-edit d-none">
				<i class="fas fa-edit"></i> Edit
			</button>
			<button type="button" class="btn btn-primary btn-delete d-none">
				<i class="fas fa-trash-alt"></i> Delete
			</button>
		</p>
	</div>

	<!-- <div class="embed-responsive embed-responsive-16by9">
  		<iframe class="embed-responsive-item" src="https://docs.google.com/viewer?url=https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf%3F{{ time() }}&embedded=true"></iframe>
	</div> -->
	
    <!-- <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header justify-content-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="now-ui-icons ui-1_simple-remove"></i>
            </button>
            <h4 class="title title-up">Document preview</h4>
          </div>
          <div class="modal-body">
			<div class="embed-responsive embed-responsive-16by9" id="preview-content">
			</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> -->

@endsection

@section('js')

<script type="text/javascript">
	// $('#modalPreview').on('shown.bs.modal', function () {
 //        var iframe = '<iframe width="100%" src="';
 //        iframe += 'https://docs.google.com/viewer?{{ time() }}&url=https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf&embedded=true';
 //        iframe += '" frameborder="0" id="print_frame"></iframe>';

 //        $('#preview-content').html(iframe);
 //    });
</script>

@endsection
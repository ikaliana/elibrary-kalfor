@extends('layouts.app')

@section('css')
	<style type="text/css">
		li.media { margin-bottom: 15px; }
		h4.title { padding-top: 15px; }
		.doc-title { font-variant: small-caps; font-weight: bold; }
	</style>
@endsection

@section('main_content')
	<h2 class="title text-right">
		@if ($mode == 'new')New Gallery @endif
		@if ($mode == 'edit')Edit Gallery @endif
		@if ($mode == 'view')Gallery @endif
		<hr>
	</h2>

@if ($mode == 'view')
	<h3>
		<strong>{{ $item['name'] }}</strong>
	</h3>

	<div id="gallery-content">
		<p>{{ $item['description'] }}</p>
	</div>

	@if($loginfo['is_klhk'])
		@if( $loginfo['is_admin'] || $loginfo['id'] == $item['user_id'] )
	<div id="gallery-footer">
		<p align="center">
			<button type="button" class="btn btn-primary btn-edit" data-toggle="tooltip" data-placement="top" title="Edit gallery">
				<i class="fas fa-edit"></i> Edit
			</button>
			<button type="button" class="btn btn-primary btn-delete" data-toggle="tooltip" data-placement="top" title="Delete gallery">
				<i class="fas fa-trash-alt"></i> Delete
			</button>
		</p>
	</div>
		@endif
	@endif
@else
	<form>
		<div class="form-group">
			<h4 style="margin-bottom: 0;"><label for="title">Title</label></h4>
			<textarea class="form-control" id="name" rows="1">{{ $item['name'] }}</textarea>
		</div>
		<div class="form-group">
			<h4 style="margin-bottom: 0;"><label for="description">Description</label></h4>
			<textarea class="form-control" id="description" rows="5" style="max-height: initial;">{{ $item['description'] }}</textarea>
		</div>
		<div class="form-group form-check">
            <label class="form-check-label" style="margin-top: 25px;">
              <input class="form-check-input" type="checkbox" id="visibility" @if($item['visibility']==0) checked @endif>
              <span class="form-check-sign"></span>
              <h4 style="margin-top: 0">Private Gallery</h4>
            </label>
		</div>
		<div class="form-group text-center">
			<button type="button" class="btn btn-default btn-outline-default btn-cancel" data-mode="{{ $mode }}">
				Cancel
			</button>
			<button type="button" class="btn btn-primary btn-save" data-mode="{{ $mode }}">
				<i class="fas fa-save"></i> Save
			</button>
		</div>
	</form>
@endif

@if ($mode == 'view')
	<h4 class="title">
		Documents ({{ count($item['documents']) }})
		
		@if($loginfo['is_klhk'])
			@if( $loginfo['is_admin'] || $loginfo['id'] == $item['user_id'] )
		<div class="btn-group float-right" role="group">
			<button type="button" class="btn btn-primary btn-sm btn-add-document" data-toggle="tooltip" data-placement="left" title="Add document">
				<i class="now-ui-icons ui-1_simple-add"></i>
			</button>
		</div>
			@endif
		@endif

		<hr>
	</h4>

@if (count($item['documents']) > 0)
    <ul class="list-unstyled">
	@foreach($item['documents'] as $doc)
	<li class="media">
		<img src="{{ asset('img/icons/icons8-'.$doc['icon'].'-64.png') }}" class="mr-3" alt="{{ $doc['icon'] }} file">
		<div class="media-body">
			<a href="{{ route('documents.show', 'CN1|'.$doc['id'] ) }}" target="_blank" class="btn btn-link btn-info my-0 btn-block text-left pl-0">
				<h5 class="mt-0 mb-1 doc-title">{{ $doc['name'] }}</h5>
			</a>
			{{ $doc['description'] }}
		</div>
	</li>
	@endforeach
	</ul>
@else
	<p>There are no documents in  this library</p>
@endif

@endif

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<input type="hidden" name="gallery_id" id="gallery_id" value="{{ $item['id'] }}">
@include('documents.upload', ['category' => $category])

@endsection

@section('js')

<script type="text/javascript">
	$('.btn-save').on("click",function(){
		$("#modalspinner").modal('show');

		var item = { name: '', description: '', visibility: '' };
		var mode = $(this).data('mode');

		var private = $('#visibility').prop('checked');

		item.name = $("#name").val();
		item.description = $("#description").val();
		item.visibility = (private) ? 0 : 1;
		item["_token"] =  $('#token').val();

		var method = (mode=='new') ? 'POST' : 'PUT';
		var url = (mode=='new') ? "{{ route('gallery.store') }}" : "{{ route('gallery.update', is_null($item['id'])?0:$item['id']) }}";

		$.ajax({
			"method": method,
			"url": url,
			"data": item,
		})
		.done(function( msg ) {
			console.log(msg);
			msg = eval(msg);

			$('#body-text').text("Gallery has been saved successfully");
			$('#modal-success-id').val(msg.id);

			$("#modalSuccess").modal('show');
		})
		.fail(function( jqXHR, textStatus ) {
			console.log(textStatus, jqXHR);
			$("#modalError").modal('show');
		})
		.always(function() {
			$("#modalspinner").modal('hide');
		});
	});

	$(".btn-edit").on("click", function() {
		location.href = location.href + "/edit";
	});

	function ConfirmDeleteGallery() {
		var item = { };
		item["_token"] =  $('#token').val();

		$("#modalspinner").modal('show');

		var method = 'DELETE';
		var url = "{{ route('gallery.destroy', is_null($item['id'])?0:$item['id']) }}";

		$.ajax({
			"method": method,
			"url": url,
			"data": item,
		})
		.done(function( msg ) {
			$('#body-text').text("Gallery has been deleted successfully");
			$('#modal-success-id').val("0");
			$("#modalSuccess").modal('show');
		})
		.fail(function( jqXHR, textStatus ) {
			$("#modalError").modal('show');
		})
		.always(function() {
			$("#modalspinner").modal('hide');
		});
	}

	$(".btn-delete").on("click", function() {
		// var r = confirm("Delete gallery?");
		// if(!r) return;
		$('#body-text-confirm').html("The documents under this gallery will be deleted also!<br><br>Delete this gallery?");
		$('.btn-confirm-ok').off("click", "**");
		$('.btn-confirm-ok').on("click",function() { $("#modalConfirm").modal('hide'); ConfirmDeleteGallery(); });
		$("#modalConfirm").modal('show');
	});

	$(".btn-cancel").on("click", function() {
		var mode = $(this).data('mode');
		var url = (mode=='new') ? "{{ route('gallery.store') }}" : "{{ route('gallery.show', is_null($item['id'])?0:$item['id']) }}";

		location.href = url;
	});

	$('#modalSuccess').on('hidden.bs.modal', function (event) {
		$("#modalspinner").modal('show');
		var modal = $(this);
		var id = modal.find('#modal-success-id').val();
		var url = "{{ route('gallery.show', 9999) }}";
		var urlGallery = "{{ route('gallery.index') }}";

		if(id != 0) {
			url = url.replace("9999", id);
			location.href = url;
		}
		else location.href = urlGallery;
	});

	$(".btn-add-document").on("click", function() {
		
		$("#modalspinner").modal('show');
		//$("#modalUpload").modal('show');
		$("#type").empty();

		$.ajax({
			"method": "GET",
			"url": "{{ route('documents.types') }}",
		})
		.done(function( msg ) {
			msg = eval(msg);

			$("#name").val('');
			$("#description").val('');
			$("#license").val('');
			$('#visibility').prop('checked','');
			$("#datasource").val('');

			$("#type").append( new Option('Document','') );
			$.each(msg, function(key,item) {
	            $("#type").append( new Option(item,item) );
	        });
	        $("#type").val('');
	        $("#category").val('1');
	        $(".map-row").hide();

			$("#modalUpload").modal('show');
		})
		.fail(function( jqXHR, textStatus ) {
			console.log(textStatus, jqXHR);
			alert("Error loading document types")
		})
		.always(function() {
			$("#modalspinner").modal('hide');
		});
	});

	$("#type").on("change", function() {
		var val = $(this).val();
		if (val == "Map") $(".map-row").show();
		else $(".map-row").hide();
	})

	$(".btn-upload-doc").on("click", function(){
		$("#modalspinner").modal('show');

		// var item = { name: '', description: '', visibility: '', license: '', type: '', gallery_id: '' };
		var mode = $(this).data('mode');

		var private = $('#visibility').prop('checked');

		var formData = new FormData();
		formData.append('file', $('#file')[0].files[0]);
		formData.append('name', $("#name").val());
		formData.append('description', $("#description").val());
		formData.append('visibility', ((private) ? 0 : 1));
		formData.append('license', $("#license").val());
		formData.append('type', $("#type").val());
		formData.append('category', $("#category").val());
		formData.append('datasource', $("#datasource").val());
		formData.append('gallery_id', $("#gallery_id").val());
		formData.append('_token', $("#token").val());

		$.ajax({
			type 	: "POST",
			url 	: "{{ route('documents.save') }}",
			data 	: formData,
			processData: false,
			contentType: false,
		})
		.done(function( msg ) {
			msg = eval(msg);

			$('#body-text').text("Document has been saved successfully");
			$('#modal-success-id').val(msg.gallery_id);

			$("#modalSuccess").modal('show');
		})
		.fail(function( jqXHR, textStatus ) {
			console.log(textStatus, jqXHR);
			$('#body-text-error').text("Error while uploading document!");
			$("#modalError").modal('show');
			//alert("Error while uploading document")
		})
		.always(function() {
			$("#modalspinner").modal('hide');
		});
	});

	//$("#modalUpload").modal('show');

</script>

@endsection
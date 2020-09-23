	<div class="text-right" style="margin-top:30px;margin-bottom: -70px;">
		<span class="mr-3 font-weight-bold">Categories: </span> 
		@foreach($category as $cat)
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-{{ $cat['id'] }}" class="form-check-input" type="checkbox" checked="" value="category-{{ $cat['id'] }}">
				<span class="form-check-sign"></span> {{ $cat['name'] }}
			</label>
		</div>
		@endforeach
		
		<!-- <div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-1" class="form-check-input" type="checkbox" checked="" value="category-1">
				<span class="form-check-sign"></span> N/A
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-2" class="form-check-input" type="checkbox" checked="" value="category-2">
				<span class="form-check-sign"></span> Publications
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-3" class="form-check-input" type="checkbox" checked="" value="category-3">
				<span class="form-check-sign"></span> Raster
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-4" class="form-check-input" type="checkbox" checked="" value="category-4">
				<span class="form-check-sign"></span> Vector
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input id="category-check-5" class="form-check-input" type="checkbox" checked="" value="category-5">
				<span class="form-check-sign"></span> Module
			</label>
		</div> -->
    </div>


	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Attributes</h3>
			@if (isset($rolls))
				<ul class="list-inline">
					<li>Your stat rolls are</li>
					@foreach ($rolls->roll as $roll)
						<li>{{ $roll }}</li>
					@endforeach
				</ul>
			@endif
			@foreach ($attributes as $attribute)
				{{ bForm::select('attributes['. $attribute->id .']', $rollsArray, Input::old('attributes['. $attribute->id .']'), array('id' => 'attribute', 'placeholder' => $attribute->name), $attribute->name) }}
			@endforeach
		</div>
	</div>
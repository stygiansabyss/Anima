	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Appearances</h3>
			@foreach ($appearances as $appearance)
				{{ bForm::text('appearances['. $appearance->id .']', Input::old('appearances['. $appearance->id .']'), array('id' => 'appearance', 'placeholder' => $appearance->name), $appearance->name) }}
			@endforeach
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Advantages</h3>
			@foreach ($advantages as $advantage)
				{{ bForm::text('traits['. $advantage->id .']', Input::old('traits['. $advantage->id .']'), array('id' => 'trait', 'placeholder' => $advantage->name), $advantage->name) }}
			@endforeach
		</div>
	</div>
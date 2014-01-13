	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Disadvantages</h3>
			@foreach ($disadvantages as $disadvantage)
				{{ bForm::text('traits['. $disadvantage->id .']', Input::old('traits['. $disadvantage->id .']'), array('id' => 'trait', 'placeholder' => $disadvantage->name), $disadvantage->name) }}
			@endforeach
		</div>
	</div>
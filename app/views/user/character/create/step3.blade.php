	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Stats</h3>
			@foreach ($stats as $stat)
				{{ bForm::text('stats['. $stat->id .']', Input::old('stats['. $stat->id .']'), array('id' => 'stat', 'placeholder' => $stat->name), $stat->name) }}
			@endforeach
		</div>
	</div>
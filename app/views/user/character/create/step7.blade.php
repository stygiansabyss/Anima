	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Skills</h3>
			@foreach ($skills as $skill)
				{{ bForm::text('skills['. $skill->id .']', Input::old('skills['. $skill->id .']'), array('id' => 'skill', 'placeholder' => $skill->name), $skill->name) }}
			@endforeach
		</div>
	</div>
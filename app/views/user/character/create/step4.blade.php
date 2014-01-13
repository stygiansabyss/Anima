	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Class selection</h3>
			{{ bForm::select('class_id', $classArray, Input::old('class_id'), array('id' => 'class_id', 'placeholder' => 'Class'), 'Class') }}
		</div>
	</div>
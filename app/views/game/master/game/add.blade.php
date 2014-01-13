{{ bForm::open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="well">
				<div class="well-title">Game Details</div>
				{{ bForm::text('name', Input::old('name'), array('placeholder' => 'Name', 'required' => 'required'), 'Name') }}
				{{ bForm::text('keyName', Input::old('keyName'), array('placeholder' => 'Key Name', 'required' => 'required'), 'Key Name') }}
				{{ bForm::textarea('description', Input::old('description'), array('placeholder' => 'Description'), 'Description') }}
				{{ bForm::select('users[]', $userArray, null, array('multiple' => 'multiple', 'style' => 'height: 200px;'), 'Story-Tellers') }}
				{{ bForm::checkbox('activeFlag', 1, true, 'Active') }}
				{{ bForm::submit('Update Game') }}
			</div>
		</div>
	</div>
{{ bForm::close() }}
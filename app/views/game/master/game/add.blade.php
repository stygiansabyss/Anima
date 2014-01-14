{{ bForm::open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Game Details</div>
				<div class="panel-body">
					{{ bForm::text('name', Input::old('name'), array('placeholder' => 'Name', 'required' => 'required'), 'Name') }}
					{{ bForm::text('keyName', Input::old('keyName'), array('placeholder' => 'Key Name', 'required' => 'required'), 'Key Name') }}
					{{ bForm::textarea('description', Input::old('description'), array('placeholder' => 'Description'), 'Description') }}
					{{ bForm::select('users[]', $userArray, null, array('multiple' => 'multiple', 'style' => 'height: 200px;'), 'Story-Tellers') }}
					{{ bForm::checkbox('activeFlag', 1, true, array(), 'Active') }}
					{{ bForm::submit('Create Game') }}
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}
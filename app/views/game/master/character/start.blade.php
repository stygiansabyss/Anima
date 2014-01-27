{{ bForm::open() }}
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Basic Details</div>
			<div class="panel-body">
				{{ bForm::text('name', Input::old('name') or null, array('placeholder' => 'Name'), 'Name') }}
				{{ bForm::select('user_id', $users, Input::old('user_id') or null, array('placeholder' => 'User'), 'User') }}
				{{ bForm::select('parent_id', $characters, Input::old('parent_id') or null, array('placeholder' => 'Parent'), 'Parent') }}
				{{ bForm::submit() }}
			</div>
		</div>
	</div>
{{ bForm::close() }}
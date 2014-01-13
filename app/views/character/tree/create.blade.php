@include('character.components.breadcrumbs')
{{ bForm::ajaxForm('submitForm', 'New tree submitted for approval')->open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Create a tree</div>
				<div class="panel-body">
					{{ bForm::text('name', null, array('placeholder' => 'Name'), 'Name') }}
					{{ bForm::select('magic_type_id', $types, null, array(), 'Magic Type') }}
					{{ bForm::textarea('description', null, array('placeholder' => 'Description'), 'Description') }}
					{{ bForm::jsonSubmit('Submit Tree') }}
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}
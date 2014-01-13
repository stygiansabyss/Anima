<div class="row">
	<div class="col-md-offset-3 col-md-6">
		{{ bForm::open() }}
			<div class="panel panel-default">
				<div class="panel-heading">Create Entity</div>
				<div class="panel-body">
					{{ bForm::text('name', null, array('id' => 'name', 'placeholder' => 'Name'), 'Name') }}
					{{ bForm::color('color', '#ffffff', array(), 'Chat Color') }}
					{{ bForm::textarea('description', null, array('placeholder' => 'Description'), 'Description') }}
					{{ bForm::checkbox('hiddenFlag', 1, false, array(), 'Hidden') }}
					{{ bForm::checkbox('activeFlag', 1, true, array(), 'Active') }}
					{{ bForm::image('avatar', null, 'Avatar') }}
					{{ bForm::submit('Create Entity') }}
				</div>
			</div>
		{{ bForm::close() }}
	</div>
</div>
<div class="row">
	<div class="col-md-offset-3 col-md-6">
		{{ bForm::setType('inline')->open() }}
			<div class="panel panel-default">
				<div class="panel-heading">Create Entity</div>
				<div class="panel-body">
					{{ bForm::text('name', null, array('id' => 'name', 'placeholder' => 'Name'), 'Name') }}
					{{ bForm::submitReset() }}
				</div>
			</div>
		{{ bForm::close() }}
	</div>
</div>
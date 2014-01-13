@include('character.components.breadcrumbs')
{{ Form::ajaxForm('submitForm', 'New spell submitted for approval.')->open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Create a spell</div>
				<div class="panel-body">
					{{ bForm::text('name', null, array('placeholder' => 'Name'), 'Name') }}
					{{ bForm::select('magic_tree_id', $trees, null, array(), 'Magic Tree') }}
					{{ bForm::select('attribute_id', $attributes, null, array(), 'Attribute') }}
					{{ bForm::text('level', null, array('placeholder' => 'Level'), 'Level') }}
					{{ bForm::text('useCost', null, array('placeholder' => 'Use Cost'), 'Use Cost') }}
					{{ bForm::textarea('stats', null, array('placeholder' => 'Stats'), 'Stats') }}
					{{ bForm::textarea('extra', null, array('placeholder' => 'Extra Details'), 'Extra Details') }}
					{{ bForm::jsonSubmit('Submit Spell') }}
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}
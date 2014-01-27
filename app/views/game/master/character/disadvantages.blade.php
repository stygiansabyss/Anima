{{ bForm::ajaxForm('disadvantagesForm', 'Disadvantages updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Disadvantages</div>
		<div class="panel-body">
			@foreach ($disadvantages as $disadvantage)
				{{ bForm::text('disdisadvantages['. $disadvantage->id .']', $character->getValue('Trait', $disadvantage->id), array('placeholder' => $disadvantage->name), $disadvantage->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update disadvantages') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
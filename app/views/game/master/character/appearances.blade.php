{{ bForm::ajaxForm('appearancesForm', 'Appearances updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Appearances</div>
		<div class="panel-body">
			@foreach ($appearances as $appearance)
				{{ bForm::text('appearances['. $appearance->id .']', $character->getValue('Appearance', $appearance->id), array('placeholder' => $appearance->name), $appearance->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update appearances') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
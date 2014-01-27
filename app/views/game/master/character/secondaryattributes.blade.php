{{ bForm::ajaxForm('attributesForm', 'Secondary attributes updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Secondary Attributes</div>
		<div class="panel-body">
			@foreach ($attributes as $attribute)
				{{ bForm::text('attributes['. $attribute->id .']', $character->getValue('SecondaryAttribute', $attribute->id), array('placeholder' => $attribute->name), $attribute->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update secondary attributes') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
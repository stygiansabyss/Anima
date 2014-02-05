{{ bForm::ajaxForm('classesForm', 'Class updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Class</div>
		<div class="panel-body">
			{{ bForm::select('class_id', $classes, $character->classId, array(), 'Class') }}
			{{ bForm::jsonSubmit('Update Class') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
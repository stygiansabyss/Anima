{{ bForm::ajaxForm('skillsForm', 'Skills updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Skills</div>
		<div class="panel-body">
			@foreach ($skills as $skill)
				{{ bForm::text('skills['. $skill->id .']', $character->getValue('Skill', $skill->id), array('placeholder' => $skill->name), $skill->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update skills') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
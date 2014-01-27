{{ bForm::ajaxForm('basicsForm', 'Character updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Basic Details</div>
		<div class="panel-body">
			{{ bForm::text('name', $character->name, array('placeholder' => 'Name'), 'Name') }}
			{{ bForm::select('user_id', $users, $character->user_id, array('placeholder' => 'User'), 'User') }}
			{{ bForm::select('parent_id', $characters, $character->parent_id or null, array('placeholder' => 'Parent'), 'Parent') }}
			{{ bForm::color('color', $character->color, array(), 'Chat Color') }}
			{{ bForm::jsonSubmit('Update Character') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
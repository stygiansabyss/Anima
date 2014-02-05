{{ bForm::ajaxForm('detailsForm', $type .' details updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Character Details</div>
		<div class="panel-body">
			{{ bForm::text('level', $details->level, array('placeholder' => 'Level'), 'Level') }}
			{{ bForm::text('experience', $details->experience, array('placeholder' => 'Experience'), 'Experience') }}
			{{ bForm::text('hitPoints', $details->hitPoints, array('placeholder' => 'Hit Points'), 'Hit Points') }}
			{{ bForm::text('magicPoints', $details->magicPoints, array('placeholder' => 'Magic Points'), 'Magic Points') }}
			{{ bForm::select('magic_type_id', $magicTypes, $details->magic_type_id, array(), 'Magic Type') }}
			{{ bForm::text('gold', $details->gold, array('placeholder' => 'Gold'), 'Gold') }}
			{{ bForm::text('silver', $details->silver, array('placeholder' => 'Silver'), 'Silver') }}
			{{ bForm::text('copper', $details->copper, array('placeholder' => 'Copper'), 'Copper') }}
			{{ bForm::textarea('armorWeapons', $details->armorWeapons, array('placeholder' => 'Armor & Weapons'), 'Armor & Weapons') }}
			{{ bForm::textarea('generalItems', $details->generalItems, array('placeholder' => 'General Items'), 'General Items') }}
			{{ bForm::jsonSubmit('Update '. $type) }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}
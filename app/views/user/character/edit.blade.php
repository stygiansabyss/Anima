<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">Edit {{ $character->name }}</div>
			<div class="panel-body">
				{{ bForm::open() }}
					<div class="row">
						<div class="col-md-6">
							{{ bForm::image('avatar', $character->avatarPath, 'Avatar') }}
							{{ bForm::color('color', $character->color, array(), 'Chat Color') }}
							{{ bForm::text('age', $character->getValueByName('Appearance', 'Age'), array(), 'Age') }}
							{{ bForm::text('gender', $character->getValueByName('Appearance', 'Gender'), array(), 'Gender') }}
							{{ bForm::text('hair', $character->getValueByName('Appearance', 'Hair'), array(), 'Hair') }}
							{{ bForm::text('eyes', $character->getValueByName('Appearance', 'Eyes'), array(), 'Eyes') }}
							{{ bForm::text('gold', $character->details->gold, array(), 'Gold') }}
							{{ bForm::text('silver', $character->details->silver, array(), 'Silver') }}
							{{ bForm::text('copper', $character->details->copper, array(), 'Copper') }}
							{{ bForm::submitReset() }}
						</div>
						<div class="col-md-6">
							{{ bForm::textarea('backstory', $character->getValueByName('Appearance', 'Backstory'), array(), 'Backstory') }}
							{{ bForm::textarea('armorWeapons', $character->details->armorWeapons, array(), 'Armor & Weapons') }}
							{{ bForm::textarea('generalItems', $character->details->generalItems, array(), 'General Items') }}
						</div>
					</div>
				{{ bForm::close() }}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<small>
			<ul class="breadcrumb">
				<li>{{ HTML::link('/character/spellbook/'. $character->id, 'Spellbook') }}</li>
				<li>{{ HTML::link('/character/spell/request/'. $character->id, 'Request Spell') }}</li>
				<li>{{ HTML::link('/character/spell/create/'. $character->id, 'Create Spell') }}</li>
				<li>{{ HTML::link('/character/tree/create/'. $character->id, 'Create Tree') }}</li>
			</ul>
		</small>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">Character Spell Access Awaiting Approval</div>
	<table class="table table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th>Spell</th>
				<th>Character</th>
				<th>Details</th>
				<th class="text-right">Actions</th>
			</tr>
		</thead>
		<tbody>
			@if (count($game->unApprovedCharacterSpells) > 0)
				@foreach ($game->unApprovedCharacterSpells as $spell)
					<tr>
						<td>{{ $spell->spell->name }}</td>
						<td>{{ HTML::link('character/sheet/'. $spell->morph->id, $spell->morph->name, array('target' => '_blank')) }}</td>
						<td>
							<div class="btn-group">
								<a href="javascript: void();" data-trigger="{{ $activeUser->popover }}" rel="popover" class="btn btn-xs btn-primary" data-toggle="popover" data-placement="right" data-content="{{ nl2br($spell->description) }}" data-html="true" title data-original-title="Description">Description</a>
								<a href="javascript: void();" data-trigger="{{ $activeUser->popover }}" rel="popover" class="btn btn-xs btn-primary" data-toggle="popover" data-placement="right" data-content="{{ nl2br($spell->buyCost) }}" data-html="true" title data-original-title="Buy Cost">Buy Cost</a>
							</div>
						</td>
						<td class="text-right">
							<div class="btn-group">
								{{ HTML::link('/game/master/update/'. $spell->id .'/approvedFlag/1/characterSpell', 'Approve', array('class' => 'btn btn-xs btn-primary')) }}
								{{ HTML::link('/game/master/deny-character-spell/'. $spell->id, 'Deny', array('class' => 'btn btn-xs btn-danger')) }}
							</div>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No spell requests awaiting approval.</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
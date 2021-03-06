<div class="panel panel-default">
	<div class="panel-heading">Characters Awaiting Approval</div>
	<table class="table table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th>Name</th>
				<th>User</th>
				<th>Type</th>
				<th class="text-right">Actions</th>
			</tr>
		</thead>
		<tbody>
			@if (count($game->unApprovedCharacters) > 0)
				@foreach ($game->unApprovedCharacters as $character)
					<tr>
						<td>
							{{ HTML::link('/character/sheet/'. $character->id, $character->name, array('target' => '_blank')) }}
							@if ($character->checkStatus('IN_PROGRESS'))
								<small class="text-info">(In Progress)</small>
							@endif
						</td>
						<td>{{ HTML::link('/user/view/'. $character->user->id, $character->user->username) }}</td>
						<td>{{ getRootClass($character) }}</td>
						<td class="text-right">
							<div class="btn-group">
								{{ HTML::link('/game/master/status/'. $character->id .'/'. getRootClass($character) .'/APPROVED/1', 'Approve', array('class' => 'btn btn-xs btn-primary')) }}
								{{ HTML::linkIcon(
									'/game/master/character-status/'. $character->id .'/'. getRootClass($character) .'/'. $game->id,
									'fa fa-bars',
									null,
									array('class' => 'btn btn-xs btn-primary', 'title' => 'Set statuses')
								) }}
							</div>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="3">No applications awaiting approval.</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
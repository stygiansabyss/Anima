<div class="panel panel-default">
	<div class="panel-heading">Magic Trees Awaiting Approval</div>
	<table class="table table-hover table-striped table-condensed">
		<thead>
			<tr>
				<th style="width: 25%">Name</th>
				<th style="width: 25%">Type</th>
				<th style="width: 25%">Submitted By</th>
				<th style="width: 25%">Actions</th>
			</tr>
		</thead>
		<tbody>
			@if (count($game->unApprovedTrees) > 0)
				@foreach ($game->unApprovedTrees as $tree)
					<tr>
						<td title="{{ $tree->description }}">{{ $tree->name }}</td>
						<td>{{ $tree->type_name }}</td>
						<td>{{ HTML::link('character/sheet/'. $tree->character->id, $tree->character->name) }}</td>
						<td>
							<div class="btn-group">
								{{ HTML::link('game/update/'. $tree->id .'/approvedFlag/1/tree', 'Approve', array('class' => 'btn btn-mini btn-primary')) }}
								{{ HTML::link('game/denyTree/'. $tree->id, 'Deny', array('class' => 'btn btn-mini btn-danger')) }}
							</div>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No trees awaiting approval.</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
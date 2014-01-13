<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	<h3 id="myModalLabel">{{ $character->name }} Experience History</h3>
</div>
<div class="modal-body">
	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th>Given By</th>
				<th>Amount</th>
				<th>Reason</th>
				<th>Balance</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			@if (count($expHistory) > 0)
				@foreach ($expHistory as $exp)
					<tr>
						<td>{{ $exp->morph->user->username }}</td>
						<td>{{ $exp->value }}</td>
						<td>
							@if ($exp->resource_type == 'Forum_Post')
								{{ HTML::link('/forum/post/view/'. $exp->resource->id, $exp->resource->name, array('target' => '_blank')) }}
							@elseif ($exp->resource_type == 'Forum_Reply')
								{{ HTML::link('/forum/post/view/'. $exp->resource->post->id .'#reply:'. $exp->post->id, $exp->resource->name, array('target' => '_blank')) }}
							@else
								{{ $exp->reason }}
							@endif
						</td>
						<td>{{ $exp->balance }}</td>
						<td>{{ $exp->created_at }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="5">No experience history for {{ $character->name }}</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<div class="btn-group">
		<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
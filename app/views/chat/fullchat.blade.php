<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Full Chat Transcript for {{ $chatRoom->name }}</div>
			<div id="chatBox">
				<?php $index = 1; ?>
				@foreach ($chatRoom->chats as $chat)
					<table class="table-hover">
						<tbody>
							<tr>
								<td>{{ str_pad($index, 3, 0, STR_PAD_LEFT) }}&nbsp;</td>
								<td style="vertical-align: top;white-space: nowrap;"><small class="text-muted">({{ $chat->created_at }})</small>&nbsp;</td>
								<td style="vertical-align: top;white-space: nowrap;">
										@if ($chat->morph_id != null)
											<strong style="color: {{ $chat->morph->color }};">
												{{ $chat->morph->name }}
											</strong>
										@else
											<strong class="text-disabled">
												@if ($chat->room->game_id != null)
													<small><small>(OOC)</small></small>
												@endif
												{{ $chat->user->username }}
											</strong>
										@endif
										:&nbsp;
								</td>
								<td style="vertical-align: top;">{{ nl2br($chat->message) }}</td>
							</tr>
						</tbody>
					</table>
					<?php $index++; ?>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-md-4">
		{{ bForm::setType('basic')->open() }}
			<div class="panel panel-default">
				<div class="panel-heading">Add to existing post</div>
				<div class="panel-body">
					{{ bForm::text('post_id', null, array('placeholder' => 'Post Id'), 'Post ID') }}
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Make a new post to a board</div>
				<div class="panel-body">
					{{ bForm::select('board_id', $boards, null, array(), 'Board') }}
					{{ bForm::text('title', null, array('placeholder' => 'Post Title'), 'Post Title') }}
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Extra Options</div>
				<div class="panel-body">
					{{ bForm::text('start', 1, array('placeholder' => 'Start at line'), 'Starting Line Number') }}
					{{ bForm::text('end', $index-1, array('placeholder' => 'End at line'), 'Ending Line Number') }}
					{{ bForm::checkbox('noTimestamps', 1, true, array(), 'Omit timestamps') }}
					{{ bForm::checkbox('characterOnly', 1, false, array(), 'Omit OOC chats') }}
					{{ bForm::submit('Post') }}
				</div>
			</div>
		{{ bForm::close() }}
	</div>
</div>
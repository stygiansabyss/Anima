<div class="row">
	<div class="col-md-9">
		<div class="well">
			<div class="well-title">Awaiting Story-Teller Attention</div>
			@if (count($game->unApprovedTrees) > 0)
				<table class="table table-hover table-striped table-condensed text-center">
					<caption>Magic Trees Awaiting Approval</caption>
					<thead>
						<tr>
							<th style="width: 25%">Name</th>
							<th style="width: 25%">Type</th>
							<th style="width: 25%">Submitted By</th>
							<th style="width: 25%">Actions</th>
						</tr>
					</thead>
					<tbody>
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
					</tbody>
				</table>
			@endif
			@if (count($game->unApprovedSpells) > 0)
				<table class="table table-hover table-striped table-condensed text-center">
					<caption>New Spells Awaiting Approval</caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>Tree</th>
							<th>Level</th>
							<th>Use Cost</th>
							<th>Details</th>
							<th>Submitted By</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($game->unApprovedSpells as $spell)
							<tr>
								<td>{{ $spell->name }}</td>
								<td>{{ $spell->tree_name }}</td>
								<td>{{ $spell->level }}</td>
								<td>{{ $spell->useCost }}</td>
								<td>
									<div class="btn-group">
										<a href="javascript: void();" rel="popover" class="btn btn-mini btn-primary" data-toggle="popover" data-placement="right" data-content="{{ nl2br($spell->stats) }}" data-html="true" title data-original-title="Stats">Stats</a>
										<a href="javascript: void();" rel="popover" class="btn btn-mini btn-primary" data-toggle="popover" data-placement="right" data-content="{{ nl2br($spell->extra) }}" data-html="true" title data-original-title="Extra Details">Extra Details</a>
									</div>
								</td>
								<td>{{ HTML::link('character/sheet/'. $spell->character->id, $spell->character->name) }}</td>
								<td>
									<div class="btn-group">
										{{ HTML::link('game/update/'. $spell->id .'/approvedFlag/1/spell', 'Approve', array('class' => 'btn btn-mini btn-primary')) }}
										{{ HTML::link('game/denySpell/'. $spell->id, 'Deny', array('class' => 'btn btn-mini btn-danger')) }}
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			@if (count($game->unApprovedCharacterSpells) > 0)
				<table class="table table-hover table-striped table-condensed text-center">
					<caption>Character Spell Access Awaiting Approval</caption>
					<thead>
						<tr>
							<th class="text-center">Spell</th>
							<th class="text-center">Character</th>
							<th class="text-center">Details</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
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
					</tbody>
				</table>
			@endif
			@if (count($game->charactersAwaitingApproval) > 0)
				<table class="table table-hover table-striped table-condensed text-center">
					<caption>Applications Awaiting Approval</caption>
					<thead>
						<tr>
							<th style="width: 33%">Name</th>
							<th style="width: 33%">User</th>
							<th style="width: 33%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($game->charactersAwaitingApproval as $post)
							<tr>
								<td>
									{{ HTML::link('character/sheet/'. $post->character->id, $post->character->name, array('target' => '_blank')) }}
								</td>
								<td>{{ HTML::link('profile/user/'. $post->author->id, $post->author->username) }}</td>
								<td>
									<div class="btn-group">
										{{ HTML::link('forum/post/view/'. $post->keyName, 'View Post', array('target' => '_blank', 'class' => 'btn btn-mini btn-primary')) }}
										{{ HTML::link('game/update/'. $post->id .'/approvedFlag/1/post', 'Approve', array('class' => 'btn btn-mini btn-primary')) }}
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			@if (count($game->actionsAwaitingApproval) > 0)
				<table class="table table-hover table-striped table-condensed text-center">
					<caption>Action Posts Awaiting Response</caption>
					<thead>
						<tr>
							<th style="width: 33%">Post / Roll</th>
							<th style="width: 33%">User</th>
							<th style="width: 33%">Actions</th>
						</tr>
					</thead>
						@foreach ($game->actionsAwaitingApproval as $reply)
							<tr>
								<td>
									{{ HTML::link('forum/post/view/'. $reply->post->keyName .'#reply:'. $reply->id, $reply->name, array('target' => '_blank')) }} / {{ $reply->roll->roll }}
								</td>
								<td>{{ HTML::link('profile/user/'. $reply->author->id, $reply->author->username) }}</td>
								<td>
									<div class="btn-group">
										{{ HTML::link('game/update/'. $reply->id .'/approvedFlag/1/reply', 'Approve', array('class' => 'btn btn-mini btn-primary')) }}
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
		@include('game.master.components.character.list', array('title' => 'Characters', 'characters' => $game->playerCharacters, 'type' => 'character'))
		@include('game.master.components.character.list', array('title' => 'NPCs', 'characters' => $game->npcs, 'type' => 'enemy'))
		@include('game.master.components.character.list', array('title' => 'Entities', 'characters' => $entities, 'type' => 'entity'))
		@include('game.master.components.character.list', array('title' => 'Inactive Characters', 'characters' => $game->deadCharacters, 'type' => 'inactive'))
	</div>
	<div class="col-md-3">
		<div class="well">
			<div class="well-title">Recent Forum Activity</div>
			<table style="width: 100%;" class="table-hover">
				<tbody>
					@if (count($recentPosts) > 0)
						@foreach ($recentPosts as $post)
							<tr>
								<td class="text-center" style="width: 30px;">
									@if (isset($post->status->id))
										{{ $post->status->icon }}
									@else
										{{ $post->icon }}
									@endif
								</td>
								<td style="width: 100px;min-width: 100px;max-width: 100px;text-align: justify;text-overflow: ellipsis;word-wrap: break-word;white-space: nowrap;overflow: hidden;">
									{{ HTML::link('forum/post/view/'. $post->keyName, $post->name) }}
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<div class="well">
			<div class="well-title">Game Notes</div>
			<table style="width: 100%;" class="table-hover">
				<tbody>
					@if (count($game->notes) > 0)
						@foreach ($game->notes as $note)
							<tr>
								<td>
									<a href="javascript: void();" rel="popover" data-toggle="popover" data-placement="top" data-content="{{ nl2br($note->content) }}" data-html="true" title data-original-title="Description">{{ $note->title }}</a>
								</td>
								<td>{{ HTML::link('game/note/delete/'. $note->id, 'Delete', array('class' => 'confirm-remove btn btn-mini btn-danger')) }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
{{ bForm::open() }}
	{{ Form::hidden('character_id', null, array('id' => 'exp_character_id')) }}
	{{ Form::hidden('character_type', null, array('id' => 'exp_character_type')) }}
	<div id="grantExp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Grant Experience to Player</h3>
				</div>
				<div class="modal-body text-center">
					<span id="exp_character_name"></span> currently has <span id="exp_character_exp"></span> experience
					{{ bForm::text('exp', null, array('placeholder' => 'Experience Points', 'required' => 'required'), 'Exp') }}
					{{ bForm::textarea('reason', null, array('placeholder' => 'Reason for Exp', 'required' => 'required'), 'Reason') }}
				</div>
				<div class="modal-footer">
					{{ Form::submit('Give Exp', array('class' => 'btn btn-mini btn-primary')) }}
					<button class="btn btn-mini btn-inverse" data-dismiss="modal" aria-hidden="true" onClick="removeResources('exp')">Close</button>
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}
<script type="text/javascript">
	function removeResources(type) {
		$('#character_id').val('');
	}
</script>
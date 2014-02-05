<div class="row-fluid">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Details
				@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
					<div class="panel-btn">
						<div class="panel-btn-divider"></div>
						{{ HTML::linkIcon('character/update/'. $character->id, 'fa fa-edit') }}
						<div class="panel-btn-divider"></div>
						{{ HTML::linkIcon('character/spellbook/'. $character->id, 'fa fa-book') }}
					</div>
				@endif
			</div>
			<div class="media">
				{{ $character->avatarFull }}
				<div class="media-body">
					<h4 class="media-heading">{{ $character->name }}</h4>
					<table class="table table-hover table-condensed">
						<tbody>
							<tr>
								<td style="font-weight: bold;">User:</td>
								<td>{{ HTML::link('/user/view/'. $character->user->id, $character->user->username) }}</td>
							</tr>
							<tr>
								<td style="font-weight: bold;">Game(s):</td>
								<td>{{ implode(', ', $character->games->game->name->toArray()) }}</td>
							</tr>
							<tr>
								<td style="font-weight: bold">Class:</td>
								<td>{{ $character->className }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" href="#currency" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
						Currency <i class="fa fa-chevron-down"></i>
					</a>
				</div>
				<div class="list-glow accordion-body collapse" id="currency">
					<ul class="list-glow-group no-header">
						<li>
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-6">Gold</div>
								<div class="col-md-6">{{ $character->details->gold }}</div>
							</div>
						</li>
						<li>
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-6">Silver</div>
								<div class="col-md-6">{{ $character->details->silver }}</div>
							</div>
						</li>
						<li>
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-6">Copper</div>
								<div class="col-md-6">{{ $character->details->copper }}</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" href="#inventory" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
						Inventory <i class="fa fa-chevron-down"></i>
					</a>
				</div>
				<div class="list-glow accordion-body collapse" id="inventory">
					<ul class="list-glow-group no-header">
						<li>
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-12 text-primary"><strong>Armor & Weapons</strong></div>
							</div>
							<div class="list-glow-group-item list-glow-group-item-sm" style="border-top: none;">
								<div class="col-md-12">{{ $character->details->armorWeapons }}</div>
							</div>
						</li>
						<li>
							<div class="list-glow-group-item list-glow-group-item-sm">
								<div class="col-md-12 text-primary"><strong>General Items</strong></div>
							</div>
							<div class="list-glow-group-item list-glow-group-item-sm" style="border-top: none;">
								<div class="col-md-12">{{ $character->details->generalItems }}</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		@endif
	</div>
	<div class="col-md-4">
		@if (count($character->appearances) > 0)
			<div class="panel panel-default">
				<div class="panel-heading">Description</div>
				<div class="list-glow" id="inventory">
					<ul class="list-glow-group no-header">
						@foreach ($character->appearances as $appearance)
							@if (!is_null($appearance->value))
								<li>
									<div class="list-glow-group-item list-glow-group-item-sm">
										<div class="col-md-12 text-primary">
											<strong>{{ $appearance->appearance->name }}</strong>
										</div>
									</div>
									<div class="list-glow-group-item list-glow-group-item-sm" style="border-top: none;">
										<div class="col-md-12">{{ nl2br($appearance->value) }}</div>
									</div>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
		@endif
	</div>
	@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
		@if (count($character->attributes) > 0 || count($character->secondaryAttributes) > 0)
			<div class="col-md-4">
				@if (count($character->stats) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#baseStats" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Base Stats <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="baseStats">
							<div class="list-glow-labels">
								<div class="col-md-6">Stat</div>
								<div class="col-md-6">Value</div>
							</div>
							<ul class="list-glow-group">
								<li>
									<div class="list-glow-group-item list-glow-group-item-sm">
										<div class="col-md-6">Level</div>
										<div class="col-md-6">{{ $character->details->level }}</div>
									</div>
								</li>
								<li>
									<div class="list-glow-group-item list-glow-group-item-sm">
										<div class="col-md-6">LP</div>
										<div class="col-md-6">{{ $character->details->hitPoints }}</div>
									</div>
								</li>
								<li>
									<div class="list-glow-group-item list-glow-group-item-sm">
										<div class="col-md-6">Zeon</div>
										<div class="col-md-6">{{ $character->details->magicPoints }}</div>
									</div>
								</li>
								@foreach ($character->stats as $stat)
									@if (!is_null($stat->value))
										<li>
											<div class="list-glow-group-item list-glow-group-item-sm">
												<div class="col-md-6">{{ $stat->stat->name }}</div>
												<div class="col-md-6">{{ $stat->value }}</div>
											</div>
										</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if (count($character->attributes) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#attributes" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Attributes <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="attributes">
							<div class="list-glow-labels">
								<div class="col-md-6">Attribute</div>
								<div class="col-md-6">Value</div>
							</div>
							<ul class="list-glow-group">
								@foreach ($character->attributes as $attribute)
									@if (!is_null($attribute->value))
										<li>
											<div class="list-glow-group-item list-glow-group-item-sm">
												<div class="col-md-6">{{ $attribute->attribute->name }}</div>
												<div class="col-md-6">{{ $attribute->value }}</div>
											</div>
										</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if (count($character->secondaryAttributes) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#secondaryAttributes" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Secondary Attributes <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="secondaryAttributes">
							<div class="list-glow-labels">
								<div class="col-md-6">Attribute</div>
								<div class="col-md-6">Value</div>
							</div>
							<ul class="list-glow-group">
								@foreach ($character->secondaryAttributes as $attribute)
									@if (!is_null($attribute->value))
										<li>
											<div class="list-glow-group-item list-glow-group-item-sm">
												<div class="col-md-6">{{ $attribute->attribute->name }}</div>
												<div class="col-md-6">{{ $attribute->value }}</div>
											</div>
										</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if (count($character->skills) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#skills" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Skills <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="skills">
							<div class="list-glow-labels">
								<div class="col-md-4">Skill</div>
								<div class="col-md-4">Attribute</div>
								<div class="col-md-4">Value</div>
							</div>
							<ul class="list-glow-group">
								@foreach ($character->skills as $skill)
									@if (!is_null($skill->skill) && $skill->value != 0)
										<li>
											<div class="list-glow-group-item list-glow-group-item-sm">
												<div class="col-md-4">{{ $skill->skill->name }}</div>
												<div class="col-md-4">{{ $skill->skill->attribute->name }}</div>
												<div class="col-md-4">{{ $skill->value }}</div>
											</div>
										</li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if (count($character->advantages) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#advantages" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Advantages <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="advantages">
							<div class="list-glow-labels">
								<div class="col-md-6">Advantage</div>
								<div class="col-md-6">Value</div>
							</div>
							<ul class="list-glow-group">
								@foreach ($character->advantages as $advantage)
									@if ($advantage->value == 0)
										<?php continue; ?>
									@endif
									<li>
										<div class="list-glow-group-item list-glow-group-item-sm">
											<div class="col-md-6">{{ $advantage->trait->name }}</div>
											<div class="col-md-6">{{ $advantage->value }}</div>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				@if (count($character->disadvantages) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#disadvantages" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Disadvantages <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<div class="list-glow accordion-body collapse" id="disadvantages">
							<div class="list-glow-labels">
								<div class="col-md-6">Disadvantage</div>
								<div class="col-md-6">Value</div>
							</div>
							<ul class="list-glow-group">
								@foreach ($character->disadvantages as $disadvantage)
									@if ($disadvantage->value == 0)
										<?php continue; ?>
									@endif
									<li>
										<div class="list-glow-group-item list-glow-group-item-sm">
											<div class="col-md-6">{{ $disadvantage->trait->name }}</div>
											<div class="col-md-6">{{ $disadvantage->value }}</div>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
			</div>
		@endif
	@endif
</div>
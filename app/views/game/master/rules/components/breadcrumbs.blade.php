<?php
	$areas = array(
		'Items'              => '/game/master/items',
		'Core'               => 'game/master/rules/core',
		'Combat Modules'     => 'game/master/rules/modules',
		'Creature Abilities' => 'game/master/rules/abilities',
		'Ki'                 => 'game/master/rules/ki',
		'Magic'              => 'game/master/rules/magic',
		'Psychic'            => 'game/master/rules/psychic',
		'Summoning'          => 'game/master/rules/summoning',
	);
?>
<div class="row">
	<div class="col-md-12">
		<small>
			<ul class="breadcrumb">
				@foreach ($areas as $area => $link)
					<li>{{ HTML::link($link, $area) }}</li>
				@endforeach
			</ul>
		</small>
	</div>
</div>
<?php

class Game_Master_Rules_AbilityController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Creature Abilities';
		$this->areaName  = 'Creature Abilities';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/abilities/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}

}
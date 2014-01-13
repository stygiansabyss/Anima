<?php

class Game_Master_Rules_SummoningController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Summoning';
		$this->areaName  = 'Summoning Spells';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/summoning/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}

}
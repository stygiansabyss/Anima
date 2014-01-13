<?php

class Game_Master_Rules_PsychicController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Psychic';
		$this->areaName  = 'Psychic Spells';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/psychic/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}

}
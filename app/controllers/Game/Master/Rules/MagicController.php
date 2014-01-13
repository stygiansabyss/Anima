<?php

class Game_Master_Rules_MagicController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Magic';
		$this->areaName  = 'Magic Spells';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/magic/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}
}
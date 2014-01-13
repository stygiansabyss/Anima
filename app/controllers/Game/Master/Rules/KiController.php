<?php

class Game_Master_Rules_KiController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Ki';
		$this->areaName  = 'Ki Spells';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/ki/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}

}
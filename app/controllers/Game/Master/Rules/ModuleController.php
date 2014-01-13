<?php

class Game_Master_Rules_ModuleController extends Game_Master_RulesController {

	public function __construct()
	{
		parent::__construct();
		$this->magicType = 'Combat Modules';
		$this->areaName  = 'Combat Modules';
	}

	public function getIndex()
	{
		$leftTabPanel = parent::getIndex();

		$leftTabPanel->panels->each(function ($panel){
			// ppd($panel);
			$panel->setBasePath('/game/master/rules/modules/')->updateTabPaths();
		});

		$leftTabPanel->make();
	}

}
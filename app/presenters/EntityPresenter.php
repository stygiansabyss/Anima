<?php

class EntityPresenter extends CharacterPresenter {

	public function editButton($gameId)
	{
		return HTML::linkIcon(
			'/game/master/'. getRootClass($this->resource, true) .'/edit/'. $this->resource->id .'/'. $gameId,
			'fa fa-edit',
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => 'Edit')
		);
	}
}
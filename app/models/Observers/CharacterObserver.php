<?php

class CharacterObserver {

	public function deleted($model)
	{
		$model->games->delete();
		$model->status->delete();
	}
}
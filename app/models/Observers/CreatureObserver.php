<?php

class CreatureObserver {

	public function deleted($model)
	{
		$model->games->delete();
		$model->status->delete();
	}
}
<?php

class EnemyObserver {

	public function deleted($model)
	{
		$model->games->delete();
		$model->status->delete();
	}
}
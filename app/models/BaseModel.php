<?php
 
class BaseModel extends Core_BaseModel {
 
    /********************************************************************
     * Core
     *******************************************************************/
    const ROLE_DEVELOPER   = 2;
    const ROLE_GUEST       = 3;
    const ROLE_FORUM_ADMIN = 5;
    const ROLE_SITE_ADMIN  = 1;

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
	public function checkStatus($statuses, $matchAll = false)
	{
		if (!is_array($statuses)) {
			$statuses = array($statuses);
		}

		$matchedStatus = 0;

		$characterStatuses = $this->status->status->keyName->toArray();

		foreach ($statuses as $status) {
			if (in_array($status, $characterStatuses)) {
				if (!$matchAll) {
					return true;
				}

				$matchedStatus++;
			}
		}

		if ($matchedStatus) {
			if (count($statuses) == $matchedStatus) return true;
		}

		return false;
	}
}
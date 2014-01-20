<?php

class Chat extends Core\Chat
{
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public function __construct()
	{
		parent::__construct();

		self::$relationsData = array_merge(parent::$relationsData, array(
			'morph' => array('morphTo'),
		));
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/

	public function sendToNode ($messageObject) 
	{

		$newMessage = ParseChat::parse($messageObject);

		$node = new SocketIOClient(Config::get('app.url') .':1337', 'socket.io', 1, false, true, true);
		$node->init();
		$node->send(
			SocketIOClient::TYPE_EVENT,
			null,
			null,
			json_encode(array('name' => 'message', 'args' => $newMessage))
			);
		$node->close();
	}

	protected function parseCharacterStats($message)
	{
		$character = $this->morph;

		if (getRootClass($character) != 'Entity') {
			$attributes = Attribute::lists('uniqueId', 'name');
			if (count($attributes) > 0) {
				foreach ($attributes as $name => $id) {
					$message = str_ireplace('/attribute '. $name, '<small class="text-warning"><b>['. $name .':'. $character->getValue('AttributeMod', $id) .']</b></small>', $message);
				}
			}
			$skills = Skill::lists('uniqueId', 'name');
			// if (count($skills) > 0) {
			// 	foreach ($skills as $name => $id) {
			// 		$message = str_replace('/'. $name, '<small class="text-warning"><b>['. $name .':'. (int)$character->getValue('Skill', $id) .' '. $attribute->name .':'. $character->getValue('Attribute', $attribute->id) .']</b></small>', $message);
			// 	}
			// }
			$secondaryAttributes = Attribute_Secondary::all();
			if (count($secondaryAttributes) > 0) {
				foreach ($secondaryAttributes as $secondaryAttribute) {
					$message = str_ireplace('/'. $secondaryAttribute->name, '<small class="text-warning"><b>['. $secondaryAttribute->name .':'. (int)$character->getValue('SecondaryAttribute', $secondaryAttribute->id) .' '. $secondaryAttribute->attribute->name .':'. (int)$character->getValue('Attribute', $secondaryAttribute->attribute->id) .']</b></small>', $message);
				}
			}
			// $spells = Character\Spell::where('character_id', '=', $character->id)->get();
			// if (count($spells) > 0) {
			// 	foreach ($spells as $spell) {
			// 		$message = str_replace('/spell '. $spell->gameSpell->name, '<small class="text-warning"><b>['. $spell->gameSpell->name .': Level('. $spell->gameSpell->level .'): Cost('. $spell->gameSpell->useCost .'): Attribute: '. $spell->gameSpell->gameAttribute->name .' ('. (int)$character->getValue('Attribute', $spell->gameSpell->gameAttribute->id) .')]</b></small>', $message);
			// 	}
			// }
		}

		return $message;
	}
}
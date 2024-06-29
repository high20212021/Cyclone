<?php

/*
 *      ____           _
 *     / ___|   _  ___| | ___  _ __   ___
 *    | |  | | | |/ __| |/ _ \|  _ \ / _ \
 *    | |__| |_| | (__| | (_) | | | |  __/
 *     \____\__, |\___|_|\___/|_| |_|\___|
 *          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Sunch233
 * @link https://github.com/Sunch233/Cyclone
 *
*/

namespace pocketmine\item;

class LingeringPotion extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LINGERING_POTION, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function getNameByMeta(int $meta){
		return "Lingering ".Potion::getNameByMeta($meta);
	}
}
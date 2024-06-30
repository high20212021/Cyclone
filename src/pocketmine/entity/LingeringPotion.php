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

namespace pocketmine\entity;

use pocketmine\item\Item;
use pocketmine\item\Potion;
use pocketmine\level\Level;
use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class LingeringPotion extends Projectile{
	const NETWORK_ID = 101;

	const DATA_POTION_ID = 16;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.1;
	protected $drag = 0.05;

	private $hasSplashed = false;

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		if(!isset($nbt->PotionId)){
			$nbt->PotionId = new ShortTag("PotionId", Potion::AWKWARD);
		}

		parent::__construct($level, $nbt, $shootingEntity);

		unset($this->dataProperties[self::DATA_SHOOTER_ID]);
		$this->setDataProperty(self::DATA_POTION_ID, self::DATA_TYPE_SHORT, $this->getPotionId());
	}

	public function getPotionId() : int{
		return (int) $this->namedtag["PotionId"];
	}

	public function splash(){
		if(!$this->hasSplashed){
			$this->hasSplashed = true;
			$this->getLevel()->addParticle(new ItemBreakParticle($this, Item::get(Item::SPLASH_POTION)));

			$aec = null;

			$nbt = new CompoundTag("", [
				new ListTag("Pos", [
					new DoubleTag("", $this->getX()),
					new DoubleTag("", $this->getY()),
					new DoubleTag("", $this->getZ()),
				]),
				new ListTag("Motion", [
					new DoubleTag("", 0),
					new DoubleTag("", 0),
					new DoubleTag("", 0),
				]),
				new ListTag("Rotation", [
					new FloatTag("", 0),
					new FloatTag("", 0),
				]),

				new IntTag(AreaEffectCloud::TAG_AGE, 0),
				new ShortTag(AreaEffectCloud::TAG_POTION_ID, $this->getPotionId()),
				new FloatTag(AreaEffectCloud::TAG_RADIUS, 3),
				new FloatTag(AreaEffectCloud::TAG_RADIUS_ON_USE, -0.5),
				new FloatTag(AreaEffectCloud::TAG_RADIUS_PER_TICK, -0.005),
				new IntTag(AreaEffectCloud::TAG_WAIT_TIME, 10),
				new IntTag(AreaEffectCloud::TAG_TILE_X, intval(round($this->getX()))),
				new IntTag(AreaEffectCloud::TAG_TILE_Y, intval(round($this->getY()))),
				new IntTag(AreaEffectCloud::TAG_TILE_Z, intval(round($this->getZ()))),
				new IntTag(AreaEffectCloud::TAG_DURATION, 600),
				new IntTag(AreaEffectCloud::TAG_DURATION_ON_USE, 0),
			]);

			$aec = Entity::createEntity("AreaEffectCloud", $this->getLevel(), $nbt);
			if($aec instanceof Entity){
				var_dump("spawnToAll");
				$aec->spawnToAll();
			}

			$this->kill();
		}
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);

		$this->age++;

		if($this->age > 1200 or $this->isCollided){
			$this->splash();
			$hasUpdate = true;
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = LingeringPotion::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
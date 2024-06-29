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

use pocketmine\event\player\PlayerFishEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\level\particle\WaterParticle;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\Player;
use pocketmine\utils\Random;

class FishingHook extends Projectile{
	const NETWORK_ID = 77;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.1;
	protected $drag = 0.05;

	public $waitChance = 0;
	public $waitTimer = 0;
	public $attractTimer = 0;
	public $attracted = false;
	public $coughtTimer = 0;
	public $caught = false;

	public $fish = null;

	public function initEntity(){
		parent::initEntity();

		if($this->shootingEntity instanceof Player){
			$pk = new EntityEventPacket();
			$pk->eid = $this->getId();
			$pk->event = EntityEventPacket::FISH_HOOK_POSITION;
			$this->shootingEntity->dataPacket($pk);
		}
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);
		if($this->isInsideOfWater() and $hasUpdate){
			$hasUpdate = true;

			if($this->waitTimer == 240){
				$this->waitTimer = $this->waitChance << 1;
			}elseif($this->waitTimer == 360){
				$this->waitTimer = $this->waitChance * 3;
			}

			if(!$this->attracted){
				if($this->waitTimer > 0){
					--$this->waitTimer;
				}
				if($this->waitTimer == 0){
					if(mt_rand(0, 100) < 90){
						$this->attractTimer = mt_rand(0, 40) + 20;
						$this->spawnFish();
						$this->caught = false;
						$this->attracted = true;
					}
				}
			}elseif(!$this->caught){
				if($this->attractFish()){
					$this->coughtTimer = mt_rand(0, 20) + 30;
					$this->fishBites();
					$this->caught = true;
				}
			}else{
				if($this->coughtTimer > 0){
					--$this->coughtTimer;
				}
				if($this->coughtTimer == 0){
					$this->attracted = false;
					$this->caught = false;
					$this->waitTimer = $this->waitChance * 3;
				}
			}
		}
		$this->timings->stopTiming();

		return $hasUpdate;
	}

	protected function updateMovement(){
		if($this->isInsideOfWater()){
			$this->motionX = 0;
			$this->motionY = 0.1;
			$this->motionZ = 0;
			$this->motionChanged = true;
		}
		parent::updateMovement();
	}

	public function getWaterHeight(){
		for($y = $this->getFloorY(); $y <= 127; ++$y){
			$id = $this->level->getBlockIdAt($this->getFloorX(), $y, $this->getFloorZ());
			if($id == 0){
				return $y;
			}
		}
		return $this->y;
	}

	public function spawnFish(){
		$random = new Random(time());
		$this->fish = new Vector3(
			$this->x + ($random->nextFloat() * 2.5 + 1) * ($random->nextBoolean() ? -1 : 1),
			$this->getWaterHeight(),
			$this->z + ($random->nextFloat() * 2.5 + 1) * ($random->nextBoolean() ? -1 : 1)
		);
	}

	public function attractFish(): bool{
		$multiply = mt_rand(3, 7) * 0.01;
		$this->fish->setComponents(
			$this->fish->x + ($this->x - $this->fish->x) * $multiply,
			$this->fish->y,
			$this->fish->z + ($this->z - $this->fish->z) * $multiply
		);

		if(mt_rand(0, 100) < 85){
			$this->shootingEntity->getLevel()->addParticle(new WaterParticle($this->fish)); //水花粒子
		}

		$d = sqrt(pow($this->x - $this->fish->x, 2) + pow($this->z - $this->fish->z, 2));
		return $d < 0.15;
	}

	public function fishBites(){
		$viewers = $this->getViewers();

		$pk = new EntityEventPacket();
		$pk->eid = $this->getId();
		$pk->event = EntityEventPacket::FISH_HOOK_HOOK;
		$this->server->broadcastPacket($viewers, $pk);

		$pk = new EntityEventPacket();
		$pk->eid = $this->getId();
		$pk->event = EntityEventPacket::FISH_HOOK_BUBBLE;
		$this->server->broadcastPacket($viewers, $pk);

		$pk = new EntityEventPacket();
		$pk->eid = $this->getId();
		$pk->event = EntityEventPacket::FISH_HOOK_TEASE;
		$this->server->broadcastPacket($viewers, $pk);
	}

	public function reelLine(){
		if($this->shootingEntity instanceof Player and $this->caught){
			$fishes = [ItemItem::RAW_FISH, ItemItem::RAW_SALMON, ItemItem::CLOWN_FISH, ItemItem::PUFFER_FISH];
			$fish = array_rand($fishes, 1);
			$item = ItemItem::get($fishes[$fish]);
			$this->getLevel()->getServer()->getPluginManager()->callEvent($ev = new PlayerFishEvent($this->shootingEntity, $item, $this));

			$this->getLevel()->dropItem($this, $item, $this->shootingEntity->subtract($this)->divide(8)->add(0, 0.3, 0));
			//$this->getLevel()->spawnXPOrb($this->shootingEntity, mt_rand(2, 12));
		}
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = FishingHook::NETWORK_ID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}

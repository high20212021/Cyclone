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

use pocketmine\item\Potion;
use pocketmine\level\particle\Particle;
use pocketmine\math\AxisAlignedBB;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class AreaEffectCloud extends Entity{
	const NETWORK_ID = 95;
	/** @var string */
	public const
		TAG_POTION_ID = "PotionId",
		TAG_AGE = "Age",
		TAG_RADIUS = "Radius",
		TAG_RADIUS_ON_USE = "RadiusOnUse",
		TAG_RADIUS_PER_TICK = "RadiusPerTick",
		TAG_WAIT_TIME = "WaitTime",
		TAG_TILE_X = "TileX",
		TAG_TILE_Y = "TileY",
		TAG_TILE_Z = "TileZ",
		TAG_DURATION = "Duration",
		TAG_DURATION_ON_USE = "DurationOnUse";
	public $width = 5;
	public $length = 5;
	public $height = 1;
	private $PotionId = 0;
	private $Radius = 3;
	private $RadiusOnUse = -0.5;
	private $RadiusPerTick = -0.005;
	private $WaitTime = 10;
	private $TileX = 0;
	private $TileY = 0;
	private $TileZ = 0;
	private $Duration = 600;
	private $DurationOnUse = 0;
	protected $age = 0;

	public function initEntity(){ //TODO from TeaSpoon
		parent::initEntity();

		/*if(!$this->namedtag->hasTag(self::TAG_POTION_ID, ShortTag::class)){
			$this->namedtag->setShort(self::TAG_POTION_ID, $this->PotionId);
		}
		$this->PotionId = $this->namedtag->getShort(self::TAG_POTION_ID);

		if(!$this->namedtag->hasTag(self::TAG_RADIUS, FloatTag::class)){
			$this->namedtag->setFloat(self::TAG_RADIUS, $this->Radius);
		}
		$this->Radius = $this->namedtag->getFloat(self::TAG_RADIUS);

		if(!$this->namedtag->hasTag(self::TAG_RADIUS_ON_USE, FloatTag::class)){
			$this->namedtag->setFloat(self::TAG_RADIUS_ON_USE, $this->RadiusOnUse);
		}
		$this->RadiusOnUse = $this->namedtag->getFloat(self::TAG_RADIUS_ON_USE);

		if(!$this->namedtag->hasTag(self::TAG_RADIUS_PER_TICK, FloatTag::class)){
			$this->namedtag->setFloat(self::TAG_RADIUS_PER_TICK, $this->RadiusPerTick);
		}
		$this->RadiusPerTick = $this->namedtag->getFloat(self::TAG_RADIUS_PER_TICK);

		if(!$this->namedtag->hasTag(self::TAG_WAIT_TIME, IntTag::class)){
			$this->namedtag->setInt(self::TAG_WAIT_TIME, $this->WaitTime);
		}
		$this->WaitTime = $this->namedtag->getInt(self::TAG_WAIT_TIME);

		if(!$this->namedtag->hasTag(self::TAG_TILE_X, IntTag::class)){
			$this->namedtag->setInt(self::TAG_TILE_X, intval(round($this->getX())));
		}
		$this->TileX = $this->namedtag->getInt(self::TAG_TILE_X);

		if(!$this->namedtag->hasTag(self::TAG_TILE_Y, IntTag::class)){
			$this->namedtag->setInt(self::TAG_TILE_Y, intval(round($this->getY())));
		}
		$this->TileY = $this->namedtag->getInt(self::TAG_TILE_Y);

		if(!$this->namedtag->hasTag(self::TAG_TILE_Z, IntTag::class)){
			$this->namedtag->setInt(self::TAG_TILE_Z, intval(round($this->getZ())));
		}
		$this->TileZ = $this->namedtag->getInt(self::TAG_TILE_Z);

		if(!$this->namedtag->hasTag(self::TAG_DURATION, IntTag::class)){
			$this->namedtag->setInt(self::TAG_DURATION, $this->Duration);
		}
		$this->Duration = $this->namedtag->getInt(self::TAG_DURATION);

		if(!$this->namedtag->hasTag(self::TAG_DURATION_ON_USE, IntTag::class)){
			$this->namedtag->setInt(self::TAG_DURATION_ON_USE, $this->DurationOnUse);
		}
		$this->DurationOnUse = $this->namedtag->getInt(self::TAG_DURATION_ON_USE);*/

		$this->setDataProperty(self::DATA_AREA_EFFECT_CLOUD_PARTICLE_ID, self::DATA_TYPE_INT, Particle::TYPE_MOB_SPELL);//todo
		$this->setDataProperty(self::DATA_AREA_EFFECT_CLOUD_RADIUS, self::DATA_TYPE_FLOAT, $this->Radius);
		$this->setDataProperty(self::DATA_AREA_EFFECT_CLOUD_WAITING, self::DATA_TYPE_INT, $this->WaitTime);
		$this->setDataProperty(self::DATA_BOUNDING_BOX_HEIGHT, self::DATA_TYPE_FLOAT, 1);
		$this->setDataProperty(self::DATA_BOUNDING_BOX_WIDTH, self::DATA_TYPE_FLOAT, $this->Radius * 2);
		$this->setDataProperty(self::DATA_POTION_AMBIENT, self::DATA_TYPE_BYTE, 1);
	}

	public function entityBaseTick($tickDiff = 1): bool{
		if(!$this->isAlive() or $this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::entityBaseTick($tickDiff);

		if($this->age > $this->Duration || $this->PotionId == 0 || $this->Radius <= 0){
			//$this->close();
			$hasUpdate = true;
		}else{
			$effects = Potion::getEffectsById($this->PotionId);
			if(count($effects) <= 0){
				//$this->close();
				$this->timings->stopTiming();

				return true;
			}

			// Multi effect color... Based off of Color::mix()
			$count = $r = $g = $b = $a = 0;
			foreach($effects as $effect){
				$ecol = $effect->getColor();
				$r += $ecol[0];
				$g += $ecol[1];
				$b += $ecol[2];
				//$a += $ecol[3];
				$count++;
			}

			$r /= $count;
			$g /= $count;
			$b /= $count;
			$a /= $count;

			$this->setDataProperty(self::DATA_POTION_COLOR,self::DATA_TYPE_INT, (($a & 0xff) << 24) | (($r & 0xff) << 16) | (($g & 0xff) << 8) | ($b & 0xff));

			$this->Radius += $this->RadiusPerTick;
			$this->setDataProperty(self::DATA_BOUNDING_BOX_WIDTH, self::DATA_TYPE_FLOAT, $this->Radius * 2);
			if($this->WaitTime > 0){
				$this->WaitTime--;
				$this->timings->stopTiming();

				return true;
			}
			/*foreach($effects as $eff){
				$eff->setDuration($this->DurationOnUse + 20);//would do nothing at 0
			}*/ // Buggy as of now...
			$bb = new AxisAlignedBB($this->x - $this->Radius, $this->y - 1, $this->z - $this->Radius, $this->x + $this->Radius, $this->y + 1, $this->z + $this->Radius);
			$used = false;
			foreach($this->getLevel()->getCollidingEntities($bb, $this) as $collidingEntity){
				if($collidingEntity instanceof Living && $collidingEntity->distanceSquared($this) <= $this->Radius ** 2){
					$used = true;
					foreach($effects as $eff){
						$collidingEntity->addEffect($eff);
					}
				}
			}
			if($used){
				$this->Duration -= $this->DurationOnUse;
				$this->Radius += $this->RadiusOnUse;
				$this->WaitTime = 10;
			}
		}

		$this->setDataProperty(self::DATA_AREA_EFFECT_CLOUD_RADIUS, self::DATA_TYPE_FLOAT, $this->Radius);
		$this->setDataProperty(self::DATA_AREA_EFFECT_CLOUD_WAITING,self::DATA_TYPE_INT, $this->WaitTime);

		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function getName(){
		return "Area Effect Cloud";
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = AreaEffectCloud::NETWORK_ID;
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
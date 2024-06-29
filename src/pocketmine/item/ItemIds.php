<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\BlockIds;

interface ItemIds extends BlockIds{

	//All BlockIds are also accessible through this interface.
	public const IRON_SHOVEL = 256;
	public const IRON_PICKAXE = 257;
	public const IRON_AXE = 258;
	public const FLINT_AND_STEEL = 259, FLINT_STEEL = 259;
	public const APPLE = 260;
	public const BOW = 261;
	public const ARROW = 262;
	public const COAL = 263;
	public const DIAMOND = 264;
	public const IRON_INGOT = 265;
	public const GOLD_INGOT = 266;
	public const IRON_SWORD = 267;
	public const WOODEN_SWORD = 268;
	public const WOODEN_SHOVEL = 269;
	public const WOODEN_PICKAXE = 270;
	public const WOODEN_AXE = 271;
	public const STONE_SWORD = 272;
	public const STONE_SHOVEL = 273;
	public const STONE_PICKAXE = 274;
	public const STONE_AXE = 275;
	public const DIAMOND_SWORD = 276;
	public const DIAMOND_SHOVEL = 277;
	public const DIAMOND_PICKAXE = 278;
	public const DIAMOND_AXE = 279;
	public const STICK = 280, STICKS = 280;
	public const BOWL = 281;
	public const MUSHROOM_STEW = 282;
	public const GOLD_SWORD = 283, GOLDEN_SWORD = 283;
	public const GOLD_SHOVEL = 284, GOLDEN_SHOVEL = 284;
	public const GOLD_PICKAXE = 285, GOLDEN_PICKAXE = 285;
	public const GOLD_AXE = 286, GOLDEN_AXE = 286;
	public const STRING = 287;
	public const FEATHER = 288;
	public const GUNPOWDER = 289;
	public const WOODEN_HOE = 290;
	public const STONE_HOE = 291;
	public const IRON_HOE = 292;
	public const DIAMOND_HOE = 293;
	public const GOLD_HOE = 294, GOLDEN_HOE = 294;
	public const SEEDS = 295, WHEAT_SEEDS = 295;
	public const WHEAT = 296;
	public const BREAD = 297;
	public const LEATHER_CAP = 298;
	public const LEATHER_TUNIC = 299;
	public const LEATHER_PANTS = 300;
	public const LEATHER_BOOTS = 301;
	public const CHAIN_HELMET = 302;
	public const CHAIN_CHESTPLATE = 303;
	public const CHAIN_LEGGINGS = 304;
	public const CHAIN_BOOTS = 305;
	public const IRON_HELMET = 306;
	public const IRON_CHESTPLATE = 307;
	public const IRON_LEGGINGS = 308;
	public const IRON_BOOTS = 309;
	public const DIAMOND_HELMET = 310;
	public const DIAMOND_CHESTPLATE = 311;
	public const DIAMOND_LEGGINGS = 312;
	public const DIAMOND_BOOTS = 313;
	public const GOLD_HELMET = 314;
	public const GOLD_CHESTPLATE = 315;
	public const GOLD_LEGGINGS = 316;
	public const GOLD_BOOTS = 317;
	public const FLINT = 318;
	public const RAW_PORKCHOP = 319;
	public const COOKED_PORKCHOP = 320;
	public const PAINTING = 321;
	public const GOLDEN_APPLE = 322;
	public const SIGN = 323;
	public const WOODEN_DOOR = 324, OAK_DOOR = 324;
	public const BUCKET = 325;

	public const MINECART = 328;
	public const SADDLE = 329;
	public const IRON_DOOR = 330;
	public const REDSTONE = 331, REDSTONE_DUST = 331;
	public const SNOWBALL = 332;
	public const BOAT = 333;
	public const LEATHER = 334;

	public const BRICK = 336;
	public const CLAY = 337;
	public const SUGARCANE = 338, SUGAR_CANE = 338, SUGAR_CANES = 338;
	public const PAPER = 339;
	public const BOOK = 340;
	public const SLIMEBALL = 341;
	public const MINECART_WITH_CHEST = 342;

	public const EGG = 344;
	public const COMPASS = 345;
	public const FISHING_ROD = 346;
	public const CLOCK = 347;
	public const GLOWSTONE_DUST = 348;
	public const RAW_FISH = 349;
	public const COOKED_FISH = 350;
	public const DYE = 351;
	public const BONE = 352;
	public const SUGAR = 353;
	public const CAKE = 354;
	public const BED = 355;
	public const REPEATER = 356;
	public const COOKIE = 357;
	public const FILLED_MAP = 358;
	public const SHEARS = 359;
	public const MELON = 360, MELON_SLICE = 360;
	public const PUMPKIN_SEEDS = 361;
	public const MELON_SEEDS = 362;
	public const RAW_BEEF = 363;
	public const STEAK = 364, COOKED_BEEF = 364;
	public const RAW_CHICKEN = 365;
	public const COOKED_CHICKEN = 366;
	public const ROTTEN_FLESH = 367;
	public const ENDER_PEARL = 368;
	public const BLAZE_ROD = 369;
	public const GHAST_TEAR = 370;
	public const GOLD_NUGGET = 371, GOLDEN_NUGGET = 371;
	public const NETHER_WART = 372;
	public const POTION = 373;
	public const GLASS_BOTTLE = 374;
	public const SPIDER_EYE = 375;
	public const FERMENTED_SPIDER_EYE = 376;
	public const BLAZE_POWDER = 377;
	public const MAGMA_CREAM = 378;
	public const BREWING_STAND = 379;
	public const CAULDRON = 380;

	public const GLISTERING_MELON = 382;
	public const SPAWN_EGG = 383;
	public const BOTTLE_O_ENCHANTING = 384, ENCHANTING_BOTTLE = 384;
	public const FIRE_CHARGE = 385;

	public const EMERALD = 388;
	public const ITEM_FRAME = 389;
	public const FLOWER_POT = 390;
	public const CARROT = 391, CARROTS = 391;
	public const POTATO = 392, POTATOES = 392;
	public const BAKED_POTATO = 393, BAKED_POTATOES = 393;
	public const POISONOUS_POTATO = 394;
	public const MAP = 395, EMPTY_MAP = 395;
	public const GOLDEN_CARROT = 396;
	public const MOB_HEAD = 397, SKULL = 397;
	public const CARROT_ON_A_STICK = 398;
	public const NETHER_STAR = 399;
	public const PUMPKIN_PIE = 400;

	public const ENCHANTED_BOOK = 403;
	public const COMPARATOR = 404;
	public const NETHER_BRICK = 405;
	public const QUARTZ = 406;
	public const NETHER_QUARTZ = 406;
	public const MINECART_WITH_TNT = 407;
	public const MINECART_WITH_HOPPER = 408;
	public const PRISMARINE_SHARD = 409;
	public const HOPPER = 410;
	public const RAW_RABBIT = 411;
	public const COOKED_RABBIT = 412;
	public const RABBIT_STEW = 413;
	public const RABBIT_FOOT = 414;
	public const RABBIT_HIDE = 415;
	public const LEATHER_HORSE_ARMOR = 416; //I hate being forced to spell this wrong
	public const IRON_HORSE_ARMOR = 417;
	public const GOLD_HORSE_ARMOR = 418;
	public const DIAMOND_HORSE_ARMOR = 419;
	public const LEAD = 420, LEASH = 420;
	public const NAMETAG = 421;
	public const PRISMARINE_CRYSTALS = 422;
	public const RAW_MUTTON = 423;
	public const COOKED_MUTTON = 424;

	public const SPRUCE_DOOR = 427;
	public const BIRCH_DOOR = 428;
	public const JUNGLE_DOOR = 429;
	public const ACACIA_DOOR = 430;
	public const DARK_OAK_DOOR = 431;

	public const SPLASH_POTION = 438;

	public const LINGERING_POTION = 441;

	public const BEETROOT = 457;
	public const BEETROOT_SEEDS = 458, BEETROOT_SEED = 458;
	public const BEETROOT_SOUP = 459;
	public const RAW_SALMON = 460;
	public const CLOWN_FISH = 461;
	public const PUFFER_FISH = 462;
	public const COOKED_SALMON = 463;

	public const ENCHANTED_GOLDEN_APPLE = 466;

	public const CAMERA = 498; #blamemojang
}

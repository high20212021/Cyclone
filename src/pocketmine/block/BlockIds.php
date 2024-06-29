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

namespace pocketmine\block;

interface BlockIds{

	public const AIR = 0;
	public const STONE = 1;
	public const GRASS = 2;
	public const DIRT = 3;
	public const COBBLESTONE = 4, COBBLE = 4;
	public const PLANK = 5, PLANKS = 5, WOODEN_PLANK = 5, WOODEN_PLANKS = 5;
	public const SAPLING = 6, SAPLINGS = 6;
	public const BEDROCK = 7;
	public const WATER = 8;
	public const STILL_WATER = 9;
	public const LAVA = 10;
	public const STILL_LAVA = 11;
	public const SAND = 12;
	public const GRAVEL = 13;
	public const GOLD_ORE = 14;
	public const IRON_ORE = 15;
	public const COAL_ORE = 16;
	public const LOG = 17, WOOD = 17, TRUNK = 17;
	public const LEAVES = 18;
	public const SPONGE = 19;
	public const GLASS = 20;
	public const LAPIS_ORE = 21;
	public const LAPIS_BLOCK = 22;
	public const DISPENSER = 23;
	public const SANDSTONE = 24;
	public const NOTE_BLOCK = 25, NOTEBLOCK = 25;
	public const BED_BLOCK = 26;
	public const POWERED_RAIL = 27;
	public const DETECTOR_RAIL = 28;
	public const STICKY_PISTON = 29;
	public const COBWEB = 30;
	public const TALL_GRASS = 31;
	public const BUSH = 32, DEAD_BUSH = 32;
	public const PISTON = 33;
	public const PISTON_HEAD = 34;
	public const WOOL = 35;

	public const DANDELION = 37;
	public const POPPY = 38, ROSE = 38, RED_FLOWER = 38;
	public const BROWN_MUSHROOM = 39;
	public const RED_MUSHROOM = 40;
	public const GOLD_BLOCK = 41;
	public const IRON_BLOCK = 42;
	public const DOUBLE_SLAB = 43, DOUBLE_SLABS = 43;
	public const SLAB = 44, SLABS = 44, STONE_SLAB = 44;
	public const BRICKS = 45, BRICKS_BLOCK = 45;
	public const TNT = 46;
	public const BOOKSHELF = 47;
	public const MOSS_STONE = 48, MOSSY_STONE = 48;
	public const OBSIDIAN = 49;
	public const TORCH = 50;
	public const FIRE = 51;
	public const MONSTER_SPAWNER = 52;
	public const WOOD_STAIRS = 53, WOODEN_STAIRS = 53, OAK_WOOD_STAIRS = 53, OAK_WOODEN_STAIRS = 53;
	public const CHEST = 54;
	public const REDSTONE_WIRE = 55;
	public const DIAMOND_ORE = 56;
	public const DIAMOND_BLOCK = 57;
	public const CRAFTING_TABLE = 58, WORKBENCH = 58;
	public const WHEAT_BLOCK = 59;
	public const FARMLAND = 60;
	public const FURNACE = 61;
	public const BURNING_FURNACE = 62, LIT_FURNACE = 62;
	public const SIGN_POST = 63;
	public const DOOR_BLOCK = 64, WOODEN_DOOR_BLOCK = 64, WOOD_DOOR_BLOCK = 64;
	public const LADDER = 65;
	public const RAIL = 66;
	public const COBBLESTONE_STAIRS = 67, COBBLE_STAIRS = 67;
	public const WALL_SIGN = 68;
	public const LEVER = 69;
	public const STONE_PRESSURE_PLATE = 70;
	public const IRON_DOOR_BLOCK = 71;
	public const WOODEN_PRESSURE_PLATE = 72;
	public const REDSTONE_ORE = 73;
	public const GLOWING_REDSTONE_ORE = 74, LIT_REDSTONE_ORE = 74;
	public const UNLIT_REDSTONE_TORCH = 75;
	public const REDSTONE_TORCH = 76, LIT_REDSTONE_TORCH = 76;
	public const STONE_BUTTON = 77;
	public const SNOW = 78, SNOW_LAYER = 78;
	public const ICE = 79;
	public const SNOW_BLOCK = 80;
	public const CACTUS = 81;
	public const CLAY_BLOCK = 82;
	public const REEDS = 83, SUGARCANE_BLOCK = 83;

	public const FENCE = 85;
	public const PUMPKIN = 86;
	public const NETHERRACK = 87;
	public const SOUL_SAND = 88;
	public const GLOWSTONE = 89, GLOWSTONE_BLOCK = 89;
	public const PORTAL_BLOCK = 90, PORTAL = 90;
	public const JACK_O_LANTERN = 91, LIT_PUMPKIN = 91;
	public const CAKE_BLOCK = 92;
	public const REPEATER_BLOCK = 93, UNPOWERED_REPEATER_BLOCK = 93;
	public const POWERED_REPEATER_BLOCK = 94;
	public const INVISIBLE_BEDROCK = 95;
	public const TRAPDOOR = 96, WOODEN_TRAPDOOR = 96;
	public const MONSTER_EGG_BLOCK = 97;
	public const STONE_BRICKS = 98, STONE_BRICK = 98;
	public const BROWN_MUSHROOM_BLOCK = 99;
	public const RED_MUSHROOM_BLOCK = 100;
	public const IRON_BARS = 101, IRON_BAR = 101;
	public const GLASS_PANE = 102, GLASS_PANEL = 102;
	public const MELON_BLOCK = 103;
	public const PUMPKIN_STEM = 104;
	public const MELON_STEM = 105;
	public const VINES = 106, VINE = 106;
	public const FENCE_GATE = 107, OAK_FENCE_GATE = 107;
	public const BRICK_STAIRS = 108;
	public const STONE_BRICK_STAIRS = 109;
	public const MYCELIUM = 110;
	public const LILY_PAD = 111, WATER_LILY = 111;
	public const NETHER_BRICKS = 112, NETHER_BRICK_BLOCK = 112;
	public const NETHER_BRICK_FENCE = 113;
	public const NETHER_BRICK_STAIRS = 114, NETHER_BRICKS_STAIRS = 114;
	public const NETHER_WART_BLOCK = 115;
	public const ENCHANTING_TABLE = 116, ENCHANT_TABLE = 116, ENCHANTMENT_TABLE = 116;
	public const BREWING_STAND_BLOCK = 117;
	public const CAULDRON_BLOCK = 118;

	public const END_PORTAL_FRAME = 120, END_PORTAL = 120;
	public const END_STONE = 121;

	public const REDSTONE_LAMP = 123, INACTIVE_REDSTONE_LAMP = 123;
	public const LIT_REDSTONE_LAMP = 124, ACTIVE_REDSTONE_LAMP = 124;
	public const DROPPER = 125;
	public const ACTIVATOR_RAIL = 126;
	public const COCOA_BLOCK = 127, COCOA_PODS = 127;
	public const SANDSTONE_STAIRS = 128;
	public const EMERALD_ORE = 129;
	public const ENDER_CHEST = 130;

	public const TRIPWIRE_HOOK = 131;
	public const TRIPWIRE = 132;
	public const EMERALD_BLOCK = 133;
	public const SPRUCE_WOOD_STAIRS = 134, SPRUCE_WOODEN_STAIRS = 134;
	public const BIRCH_WOOD_STAIRS = 135, BIRCH_WOODEN_STAIRS = 135;
	public const JUNGLE_WOOD_STAIRS = 136, JUNGLE_WOODEN_STAIRS = 136;

	public const BEACON = 138;
	public const COBBLESTONE_WALL = 139, COBBLE_WALL = 139, STONE_WALL = 139;
	public const FLOWER_POT_BLOCK = 140;
	public const CARROT_BLOCK = 141;
	public const POTATO_BLOCK = 142;
	public const WOODEN_BUTTON = 143;
	public const MOB_HEAD_BLOCK = 144, SKULL_BLOCK = 144;
	public const ANVIL = 145;
	public const TRAPPED_CHEST = 146;
	public const WEIGHTED_PRESSURE_PLATE_LIGHT = 147, LIGHT_WEIGHTED_PRESSURE_PLATE = 147, GOLD_PRESSURE_PLATE = 147;
	public const WEIGHTED_PRESSURE_PLATE_HEAVY = 148, HEAVY_WEIGHTED_PRESSURE_PLATE = 148, IRON_PRESSURE_PLATE = 148;
	public const COMPARATOR_BLOCK = 149, UNPOWERED_COMPARATOR_BLOCK = 149;
	public const POWERED_COMPARATOR_BLOCK = 150;
	public const DAYLIGHT_SENSOR = 151;
	public const REDSTONE_BLOCK = 152;
	public const NETHER_QUARTZ_ORE = 153;
	public const HOPPER_BLOCK = 154;
	public const QUARTZ_BLOCK = 155;
	public const QUARTZ_STAIRS = 156;
	public const DOUBLE_WOOD_SLAB = 157, DOUBLE_WOODEN_SLAB = 157, DOUBLE_WOOD_SLABS = 157, DOUBLE_WOODEN_SLABS = 157;
	public const WOOD_SLAB = 158, WOODEN_SLAB = 158, WOOD_SLABS = 158, WOODEN_SLABS = 158;
	public const STAINED_CLAY = 159, STAINED_HARDENED_CLAY = 159;

	public const LEAVES2 = 161;
	public const WOOD2 = 162, TRUNK2 = 162, LOG2 = 162;
	public const ACACIA_WOOD_STAIRS = 163, ACACIA_WOODEN_STAIRS = 163;
	public const DARK_OAK_WOOD_STAIRS = 164, DARK_OAK_WOODEN_STAIRS = 164;
	public const SLIME_BLOCK = 165;

	public const IRON_TRAPDOOR = 167;
	public const PRISMARINE = 168;
	public const SEA_LANTERN = 169;
	public const HAY_BALE = 170;
	public const CARPET = 171;
	public const HARDENED_CLAY = 172;
	public const COAL_BLOCK = 173;
	public const PACKED_ICE = 174;
	public const DOUBLE_PLANT = 175;

	public const INVERTED_DAYLIGHT_SENSOR = 178, DAYLIGHT_SENSOR_INVERTED = 178;
	public const RED_SANDSTONE = 179;
	public const RED_SANDSTONE_STAIRS = 180;
	public const DOUBLE_RED_SANDSTONE_SLAB = 181;
	public const RED_SANDSTONE_SLAB = 182;
	public const SPRUCE_FENCE_GATE = 183, FENCE_GATE_SPRUCE = 183;
	public const BIRCH_FENCE_GATE = 184, FENCE_GATE_BIRCH = 184;
	public const JUNGLE_FENCE_GATE = 185, FENCE_GATE_JUNGLE = 185;
	public const DARK_OAK_FENCE_GATE = 186, FENCE_GATE_DARK_OAK = 186;
	public const ACACIA_FENCE_GATE = 187, FENCE_GATE_ACACIA = 187;

	public const SPRUCE_DOOR_BLOCK = 193;
	public const BIRCH_DOOR_BLOCK = 194;
	public const JUNGLE_DOOR_BLOCK = 195;
	public const ACACIA_DOOR_BLOCK = 196;
	public const DARK_OAK_DOOR_BLOCK = 197;
	public const GRASS_PATH = 198;
	public const ITEM_FRAME_BLOCK = 199;
	public const CHORUS_FLOWER = 200;

	public const PURPUR_BLOCK = 201, PURPUR = 201;

	public const PURPUR_STAIRS = 203;

	public const CHORUS_PLANT = 240;

	public const PODZOL = 243;
	public const BEETROOT_BLOCK = 244;
	public const STONECUTTER = 245;
	public const GLOWING_OBSIDIAN = 246;
	public const NETHER_REACTOR = 247;
	public const UPDATE_BLOCK = 248;
	public const ATEUPD_BLOCK = 249;
	public const BLOCK_MOVED_BY_PISTON = 250;
	public const OBSERVER = 251;
	public const INFO_RESERVED6 = 255;
}

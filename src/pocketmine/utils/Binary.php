<?php

/*
 *  ______   _____    ______  __   __  ______
 * /  ___/  /  ___|  / ___  \ \ \ / / |  ____|
 * | |___  | |      | |___| |  \ / /  | |____
 * \___  \ | |      |  ___  |   / /   |  ____|
 *  ___| | | |____  | |   | |  / / \  | |____
 * /_____/  \_____| |_|   |_| /_/ \_\ |______|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Sunch233#3226 QQ2125696621 And KKK
 * @link https://github.com/ScaxeTeam/Scaxe/
 *
*/

declare(strict_types=1);

/**
 * Methods for working with binary strings
 * 很多的严格类型限制被取消了，因为API2本身就很不严格，很多传入都变成Null或者其他的东西了
 */

namespace pocketmine\utils;

use InvalidArgumentException;
use pocketmine\entity\Entity;
use function chr;
use function ord;
use function pack;
use function preg_replace;
use function round;
use function sprintf;
use function strlen;
use function substr;
use function unpack;
use const PHP_INT_MAX;

class Binary{
    const SIZEOF_SHORT = 2;
    const SIZEOF_INT = 4;
    const SIZEOF_LONG = 8;

    const SIZEOF_FLOAT = 4;
    const SIZEOF_DOUBLE = 8;

    const BIG_ENDIAN = 0x00;
    const LITTLE_ENDIAN = 0x01;

    public static function signByte($value): int{
        return $value << 56 >> 56;
    }

    public static function unsignByte($value): int{
        return $value & 0xff;
    }

    public static function signShort($value): int{
        return $value << 48 >> 48;
    }

    public static function unsignShort($value): int{
        return $value & 0xffff;
    }

    public static function signInt($value): int{
        return $value << 32 >> 32;
    }

    public static function unsignInt($value): int{
        return $value & 0xffffffff;
    }

    public static function flipShortEndianness($value): int{
        return self::readLShort(self::writeShort($value));
    }

    public static function flipIntEndianness($value): int{
        return self::readLInt(self::writeInt($value));
    }

    public static function flipLongEndianness($value): int{
        return self::readLLong(self::writeLong($value));
    }

    /**
     * @return mixed[]
     * @throws BinaryDataException
     */
    private static function safeUnpack($formatCode, $bytes, $needLength): array{
        $haveLength = strlen($bytes);
        if($haveLength < $needLength){
            throw new BinaryDataException("Not enough bytes: need $needLength, have $haveLength");
        }
        //unpack SUCKS SO BADLY. We really need an extension to replace this garbage :(
        $result = unpack($formatCode, $bytes);
        if($result === false){
            //this should never happen; we checked the length above
            throw new \AssertionError("unpack() failed for unknown reason");
        }
        return $result;
    }

    /**
     * Reads a byte boolean
     */
    public static function readBool($b): bool{
        return $b[0] !== "\x00";
    }

    /**
     * Writes a byte boolean
     */
    public static function writeBool($b): string{
        return $b ? "\x01" : "\x00";
    }

    /**
     * Reads an unsigned byte (0 - 255)
     *
     * @throws BinaryDataException
     */
    public static function readByte($c): int{
        if($c === ""){
            throw new BinaryDataException("Expected a string of length 1");
        }
        return ord($c[0]);
    }

    /**
     * Reads a signed byte (-128 - 127)
     *
     * @throws BinaryDataException
     */
    public static function readSignedByte($c): int{
        if($c === ""){
            throw new BinaryDataException("Expected a string of length 1");
        }
        return self::signByte(ord($c[0]));
    }

    /**
     * Writes an unsigned/signed byte
     */
    public static function writeByte($c): string{
        return chr((int) $c);
    }

    /**
     * Reads a 16-bit unsigned big-endian number
     *
     * @throws BinaryDataException
     */
    public static function readShort($str): int{
        return self::safeUnpack("n", $str, self::SIZEOF_SHORT)[1];
    }

    /**
     * Reads a 16-bit signed big-endian number
     *
     * @throws BinaryDataException
     */
    public static function readSignedShort($str): int{
        return self::signShort(self::safeUnpack("n", $str, self::SIZEOF_SHORT)[1]);
    }

    /**
     * Writes a 16-bit signed/unsigned big-endian number
     */
    public static function writeShort($value): string{
        return pack("n", $value);
    }

    /**
     * Reads a 16-bit unsigned little-endian number
     *
     * @throws BinaryDataException
     */
    public static function readLShort($str): int{
        return self::safeUnpack("v", $str, self::SIZEOF_SHORT)[1];
    }

    /**
     * Reads a 16-bit signed little-endian number
     *
     * @throws BinaryDataException
     */
    public static function readSignedLShort($str): int{
        return self::signShort(self::safeUnpack("v", $str, self::SIZEOF_SHORT)[1]);
    }

    /**
     * Writes a 16-bit signed/unsigned little-endian number
     */
    public static function writeLShort($value): string{
        return pack("v", $value);
    }

    /**
     * Reads a 3-byte big-endian number
     *
     * @throws BinaryDataException
     */
    public static function readTriad($str): int{
        return self::safeUnpack("N", "\x00" . $str, self::SIZEOF_INT)[1];
    }

    /**
     * Writes a 3-byte big-endian number
     */
    public static function writeTriad($value): string{
        return substr(pack("N", $value), 1);
    }

    /**
     * Reads a 3-byte little-endian number
     *
     * @throws BinaryDataException
     */
    public static function readLTriad($str): int{
        return self::safeUnpack("V", $str . "\x00", self::SIZEOF_INT)[1];
    }

    /**
     * Writes a 3-byte little-endian number
     */
    public static function writeLTriad($value): string{
        return substr(pack("V", $value), 0, -1);
    }

    /**
     * Writes a coded metadata string
     *
     * @param array $data
     *
     * @return string
     */
    public static function writeMetadata(array $data){
        $m = "";
        foreach($data as $bottom => $d){
            $m .= chr(($d[0] << 5) | ($bottom & 0x1F));
            switch($d[0]){
                case Entity::DATA_TYPE_BYTE:
                    $m .= self::writeByte($d[1]);
                    break;
                case Entity::DATA_TYPE_SHORT:
                    $m .= self::writeLShort($d[1]);
                    break;
                case Entity::DATA_TYPE_INT:
                    $m .= self::writeLInt($d[1]);
                    break;
                case Entity::DATA_TYPE_FLOAT:
                    $m .= self::writeLFloat($d[1]);
                    break;
                case Entity::DATA_TYPE_STRING:
                    $m .= self::writeLShort(strlen($d[1])) . $d[1];
                    break;
                case Entity::DATA_TYPE_SLOT:
                    $m .= self::writeLShort($d[1][0]);
                    $m .= self::writeByte($d[1][1]);
                    $m .= self::writeLShort($d[1][2]);
                    break;
                case Entity::DATA_TYPE_POS:
                    $m .= self::writeLInt($d[1][0]);
                    $m .= self::writeLInt($d[1][1]);
                    $m .= self::writeLInt($d[1][2]);
                    break;
                case Entity::DATA_TYPE_LONG:
                    $m .= self::writeLLong($d[1]);
                    break;
            }
        }
        $m .= "\x7f";

        return $m;
    }

    /**
     * Reads a metadata coded string
     *
     * @param      $value
     * @param bool $types
     *
     * @return array
     */
    public static function readMetadata($value, $types = false){
        $offset = 0;
        $m = [];
        $b = ord($value[$offset]);
        ++$offset;
        while($b !== 127 and isset($value[$offset])){
            $bottom = $b & 0x1F;
            $type = $b >> 5;
            switch($type){
                case Entity::DATA_TYPE_BYTE:
                    $r = self::readByte($value[$offset]);
                    ++$offset;
                    break;
                case Entity::DATA_TYPE_SHORT:
                    $r = self::readLShort(substr($value, $offset, 2));
                    $offset += 2;
                    break;
                case Entity::DATA_TYPE_INT:
                    $r = self::readLInt(substr($value, $offset, 4));
                    $offset += 4;
                    break;
                case Entity::DATA_TYPE_FLOAT:
                    $r = self::readLFloat(substr($value, $offset, 4));
                    $offset += 4;
                    break;
                case Entity::DATA_TYPE_STRING:
                    $len = self::readLShort(substr($value, $offset, 2));
                    $offset += 2;
                    $r = substr($value, $offset, $len);
                    $offset += $len;
                    break;
                case Entity::DATA_TYPE_SLOT:
                    $r = [];
                    $r[] = self::readLShort(substr($value, $offset, 2));
                    $offset += 2;
                    $r[] = ord($value[$offset]);
                    ++$offset;
                    $r[] = self::readLShort(substr($value, $offset, 2));
                    $offset += 2;
                    break;
                case Entity::DATA_TYPE_POS:
                    $r = [];
                    for($i = 0; $i < 3; ++$i){
                        $r[] = self::readLInt(substr($value, $offset, 4));
                        $offset += 4;
                    }
                    break;
                case Entity::DATA_TYPE_LONG:
                    $r = self::readLLong(substr($value, $offset, 4));
                    $offset += 8;
                    break;
                default:
                    return [];

            }
            if($types === true){
                $m[$bottom] = [$r, $type];
            }else{
                $m[$bottom] = $r;
            }
            $b = ord($value[$offset]);
            ++$offset;
        }

        return $m;
    }

    /**
     * Reads a 4-byte signed integer
     *
     * @throws BinaryDataException
     */
    public static function readInt($str): int{
        return self::signInt(self::safeUnpack("N", $str, self::SIZEOF_INT)[1]);
    }

    /**
     * Writes a 4-byte integer
     */
    public static function writeInt($value): string{
        return pack("N", $value);
    }

    /**
     * Reads a 4-byte signed little-endian integer
     *
     * @throws BinaryDataException
     */
    public static function readLInt($str): int{
        return self::signInt(self::safeUnpack("V", $str, self::SIZEOF_INT)[1]);
    }

    /**
     * Writes a 4-byte signed little-endian integer
     */
    public static function writeLInt($value): string{
        return pack("V", $value);
    }

    /**
     * Reads a 4-byte floating-point number
     *
     * @throws BinaryDataException
     */
    public static function readFloat($str): float{
        return self::safeUnpack("G", $str, self::SIZEOF_FLOAT)[1];
    }

    /**
     * Reads a 4-byte floating-point number, rounded to the specified number of decimal places.
     *
     * @throws BinaryDataException
     */
    public static function readRoundedFloat($str, $accuracy): float{
        return round(self::readFloat($str), $accuracy);
    }

    /**
     * Writes a 4-byte floating-point number.
     */
    public static function writeFloat($value): string{
        return pack("G", $value);
    }

    /**
     * Reads a 4-byte little-endian floating-point number.
     *
     * @throws BinaryDataException
     */
    public static function readLFloat($str): float{
        return self::safeUnpack("g", $str, self::SIZEOF_FLOAT)[1];
    }

    /**
     * Reads a 4-byte little-endian floating-point number rounded to the specified number of decimal places.
     *
     * @throws BinaryDataException
     */
    public static function readRoundedLFloat($str, $accuracy): float{
        return round(self::readLFloat($str), $accuracy);
    }

    /**
     * Writes a 4-byte little-endian floating-point number.
     */
    public static function writeLFloat($value): string{
        return pack("g", $value);
    }

    /**
     * Returns a printable floating-point number.
     */
    public static function printFloat($value): string{
        return preg_replace("/(\\.\\d+?)0+$/", "$1", sprintf("%F", $value));
    }

    /**
     * Reads an 8-byte floating-point number.
     *
     * @throws BinaryDataException
     */
    public static function readDouble($str): float{
        return self::safeUnpack("E", $str, self::SIZEOF_DOUBLE)[1];
    }

    /**
     * Writes an 8-byte floating-point number.
     */
    public static function writeDouble($value): string{
        return pack("E", $value);
    }

    /**
     * Reads an 8-byte little-endian floating-point number.
     *
     * @throws BinaryDataException
     */
    public static function readLDouble($str): float{
        return self::safeUnpack("e", $str, self::SIZEOF_DOUBLE)[1];
    }

    /**
     * Writes an 8-byte floating-point little-endian number.
     */
    public static function writeLDouble($value): string{
        return pack("e", $value);
    }

    /**
     * Reads an 8-byte integer.
     *
     * @throws BinaryDataException
     */
    public static function readLong($str): int{
        return self::safeUnpack("J", $str, self::SIZEOF_LONG)[1];
    }

    /**
     * Writes an 8-byte integer.
     */
    public static function writeLong($value): string{
        return pack("J", $value);
    }

    /**
     * Reads an 8-byte little-endian integer.
     *
     * @throws BinaryDataException
     */
    public static function readLLong($str): int{
        return self::safeUnpack("P", $str, self::SIZEOF_LONG)[1];
    }

    /**
     * Writes an 8-byte little-endian integer.
     */
    public static function writeLLong($value): string{
        return pack("P", $value);
    }

    /**
     * Reads a 32-bit zigzag-encoded variable-length integer.
     *
     * @param int $offset reference parameter
     *
     * @throws BinaryDataException
     */
    public static function readVarInt($buffer, &$offset): int{
        $raw = self::readUnsignedVarInt($buffer, $offset);
        $temp = ((($raw << 63) >> 63) ^ $raw) >> 1;
        return $temp ^ ($raw & (1 << 63));
    }

    /**
     * Reads a 32-bit variable-length unsigned integer.
     *
     * @param int $offset reference parameter
     *
     * @throws BinaryDataException if the var-int did not end after 5 bytes or there were not enough bytes
     */
    public static function readUnsignedVarInt($buffer, &$offset): int{
        $value = 0;
        for($i = 0; $i <= 28; $i += 7){
            if(!isset($buffer[$offset])){
                throw new BinaryDataException("No bytes left in buffer");
            }
            $b = ord($buffer[$offset++]);
            $value |= (($b & 0x7f) << $i);

            if(($b & 0x80) === 0){
                return $value;
            }
        }

        throw new BinaryDataException("VarInt did not terminate after 5 bytes!");
    }

    /**
     * Writes a 32-bit integer as a zigzag-encoded variable-length integer.
     */
    public static function writeVarInt($v): string{
        $v = ($v << 32 >> 32);
        return self::writeUnsignedVarInt(($v << 1) ^ ($v >> 31));
    }

    /**
     * Writes a 32-bit unsigned integer as a variable-length integer.
     *
     * @return string up to 5 bytes
     */
    public static function writeUnsignedVarInt($value): string{
        $buf = "";
        $remaining = $value & 0xffffffff;
        for($i = 0; $i < 5; ++$i){
            if(($remaining >> 7) !== 0){
                $buf .= chr($remaining | 0x80);
            }else{
                $buf .= chr($remaining & 0x7f);
                return $buf;
            }

            $remaining = (($remaining >> 7) & (PHP_INT_MAX >> 6)); //PHP really needs a logical right-shift operator
        }

        throw new InvalidArgumentException("Value too large to be encoded as a VarInt");
    }

    /**
     * Reads a 64-bit zigzag-encoded variable-length integer.
     *
     * @param int $offset reference parameter
     *
     * @throws BinaryDataException
     */
    public static function readVarLong($buffer, &$offset): int{
        $raw = self::readUnsignedVarLong($buffer, $offset);
        $temp = ((($raw << 63) >> 63) ^ $raw) >> 1;
        return $temp ^ ($raw & (1 << 63));
    }

    /**
     * Reads a 64-bit unsigned variable-length integer.
     *
     * @param int $offset reference parameter
     *
     * @throws BinaryDataException if the var-int did not end after 10 bytes or there were not enough bytes
     */
    public static function readUnsignedVarLong($buffer, &$offset): int{
        $value = 0;
        for($i = 0; $i <= 63; $i += 7){
            if(!isset($buffer[$offset])){
                throw new BinaryDataException("No bytes left in buffer");
            }
            $b = ord($buffer[$offset++]);
            $value |= (($b & 0x7f) << $i);

            if(($b & 0x80) === 0){
                return $value;
            }
        }

        throw new BinaryDataException("VarLong did not terminate after 10 bytes!");
    }

    /**
     * Writes a 64-bit integer as a zigzag-encoded variable-length long.
     */
    public static function writeVarLong($v): string{
        return self::writeUnsignedVarLong(($v << 1) ^ ($v >> 63));
    }

    /**
     * Writes a 64-bit unsigned integer as a variable-length long.
     */
    public static function writeUnsignedVarLong($value): string{
        $buf = "";
        $remaining = $value;
        for($i = 0; $i < 10; ++$i){
            if(($remaining >> 7) !== 0){
                $buf .= chr($remaining | 0x80); //Let chr() take the last byte of this, it's faster than adding another & 0x7f.
            }else{
                $buf .= chr($remaining & 0x7f);
                return $buf;
            }

            $remaining = (($remaining >> 7) & (PHP_INT_MAX >> 6)); //PHP really needs a logical right-shift operator
        }

        throw new InvalidArgumentException("Value too large to be encoded as a VarLong");
    }
}
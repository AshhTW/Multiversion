<?php

/*
 * This file is part of BedrockProtocol.
 * Copyright (C) 2014-2022 PocketMine Team <https://github.com/pmmp/BedrockProtocol>
 *
 * BedrockProtocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace MultiVersion\network\proto\v486\packets\types;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\serializer\CommonTypes;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\types\GetTypeIdFromConstTrait;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use pocketmine\network\mcpe\protocol\types\inventory\PredictedResult;
use pocketmine\network\mcpe\protocol\types\inventory\TriggerType;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemTransactionData;

class v486UseItemTransactionData extends UseItemTransactionData {
	use GetTypeIdFromConstTrait;

	public const ID = InventoryTransactionPacket::TYPE_USE_ITEM;

	public const ACTION_CLICK_BLOCK = 0;
	public const ACTION_CLICK_AIR = 1;
	public const ACTION_BREAK_BLOCK = 2;

	private int $actionType;
	private BlockPosition $blockPosition;
	private int $face;
	private int $hotbarSlot;
	private ItemStackWrapper $itemInHand;
	private Vector3 $playerPosition;
	private Vector3 $clickPosition;
	private int $blockRuntimeId;

	public function getActionType() : int{
		return $this->actionType;
	}

	public function getBlockPosition() : BlockPosition{
		return $this->blockPosition;
	}

	public function getFace() : int{
		return $this->face;
	}

	public function getHotbarSlot() : int{
		return $this->hotbarSlot;
	}

	public function getItemInHand() : ItemStackWrapper{
		return $this->itemInHand;
	}

	public function getPlayerPosition() : Vector3{
		return $this->playerPosition;
	}

	public function getClickPosition() : Vector3{
		return $this->clickPosition;
	}

	public function getBlockRuntimeId() : int{
		return $this->blockRuntimeId;
	}

	public function getTriggerType() : TriggerType{
		return TriggerType::PLAYER_INPUT;
	}

	public function getClientInteractPrediction() : PredictedResult{
		return PredictedResult::SUCCESS;
	}

	protected function decodeData(ByteBufferReader $in, int $protocolId = \pocketmine\network\mcpe\protocol\ProtocolInfo::CURRENT_PROTOCOL) : void{
		$this->actionType = VarInt::readUnsignedInt($in);
		$this->blockPosition = CommonTypes::getBlockPosition($in);
		$this->face = VarInt::readSignedInt($in);
		$this->hotbarSlot = VarInt::readSignedInt($in);
		$this->itemInHand = CommonTypes::getItemStackWrapper($in);
		$this->playerPosition = CommonTypes::getVector3($in);
		$this->clickPosition = CommonTypes::getVector3($in);
		$this->blockRuntimeId = VarInt::readUnsignedInt($in);
	}

	protected function encodeData(ByteBufferWriter $out, int $protocolId = \pocketmine\network\mcpe\protocol\ProtocolInfo::CURRENT_PROTOCOL) : void{
		VarInt::writeUnsignedInt($out, $this->actionType);
		CommonTypes::putBlockPosition($out, $this->blockPosition);
		VarInt::writeSignedInt($out, $this->face);
		VarInt::writeSignedInt($out, $this->hotbarSlot);
		CommonTypes::putItemStackWrapper($out, $this->itemInHand);
		CommonTypes::putVector3($out, $this->playerPosition);
		CommonTypes::putVector3($out, $this->clickPosition);
		VarInt::writeUnsignedInt($out, $this->blockRuntimeId);
	}
}

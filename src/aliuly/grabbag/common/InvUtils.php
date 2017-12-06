<?php
namespace aliuly\grabbag\common;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\item\ItemFactory;

/**
 * Inventory related utilities
 */
abstract class InvUtils{
	/**
	 * Clear players inventory
	 * @param Player $target
	 */
	static public function clearInventory(Player $target){
		if($target->isCreative() || $target->isSpectator()) return;
		$target->getInventory()->clearAll();
	}

	/**
	 * @param Player $target
	 * @throws \TypeError
	 */
	static public function clearHotBar(Player $target){
		$inv = $target->getInventory();
		for($i = 0; $i < $inv->getHotbarSize(); $i++){
			$inv->setItem($i, ItemFactory::get(Item::AIR, 0, 0));
		}
		// Make sure inventory is updated...
		$inv->sendContents($target);
	}

	/**
	 * Remove item from inventory....
	 * @param Player   $target
	 * @param Item     $item
	 * @param int|null $count
	 * @return int
	 */
	static public function rmInvItem(Player $target, Item $item, $count = null) : int{
		$k = 0;
		foreach($target->getInventory()->getContents() as $slot => &$inv){
			if($inv->getId() != $item->getId()) continue;
			if($count !== null){
				if($inv->getCount() > $count){
					$k += $count;
					$inv->setCount($inv->getCount() - $count);
					$target->getInventory()->setItem($slot, clone $inv);
					break;
				}
				$count -= $inv->getCount();
			}
			$k += $inv->getCount();
			$target->getInventory()->clear($slot);
			if($count === 0) break;
		}
		$target->getInventory()->sendContents($target);
		return $k;
	}

}

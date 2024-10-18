<?php
/**
 * @license MIT
 */

namespace clousclouds\mobai;

use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\player\Player;

class Ai implements AiInterface {

    protected Entity $mob;
    protected ?Entity $target;
    private Player $player;

    public function __construct(Entity $mob, Player $players) {
        $this->mob = $mob;
        $this->target = null;
        $this->players = $players;
    }

    public function think(): void {
        if ($this->isPlayerNearby()) {
            $this->move();
            $this->attack();
        } else {
            $this->wanderRandomly();
        }
    }

    public function move(): void {
        $this->target = $this->findTarget();
        if ($this->target) {
            $this->navigateTo($this->target);
        } else {
            $this->wanderRandomly();
        }
    }

    public function interact(): void {
        $item = $this->findNearbyItem();
        if ($item) {
            $this->pickUpItem($item);
        }
    }

    public function attack(): void {
        if ($this->target && $this->isInRange($this->target)) {
            $this->performAttack($this->target);
        }
    }

    public function defend(): void {
        if ($this->isUnderAttack()) {
            $this->takeDefensiveAction();
        }
    }

    protected function isPlayerNearby(): bool {
        $players = $this->players->getWorld()->getPlayers();
        foreach ($players as $player) {
            if ($this->mob->distance($player) < 10) {
                return true;
            }
        }
        return false;
    }

    protected function findTarget(): ?Entity {
        $entities = $this->mob->getWorld()->getEntities();
        foreach ($entities as $entity) {
            if ($entity !== $this->mob && $entity instanceof Player) {
                return $entity;
            }
        }
        return null;
    }

    protected function navigateTo(Entity $target): void {
        $direction = $target->getPosition()->subtract($this->mob->getPosition())->normalize();
        $this->mob->setMotion(new Vector3($direction->x, 0, $direction->z));
    }

    protected function wanderRandomly(): void {
        $randomDirection = new Vector3(rand(-1, 1), 0, rand(-1, 1));
        $this->mob->setMotion($randomDirection->normalize());
    }

    protected function isInRange(Entity $target): bool {
        return $this->mob->distance($target) < 3;
    }

    protected function performAttack(Entity $target): void {
        $damage = 2;
        $target->setHealth($target->getHealth() - $damage);
    }

    protected function findNearbyItem(): ?Entity {
        $items = $this->mob->getWorld()->getEntities();
        foreach ($items as $item) {
            if ($item instanceof \pocketmine\entity\Item) {
                return $item;
            }
        }
        return null;
    }

    protected function pickUpItem(Entity $item): void {
        $this->mob->getInventory()->addItem($item->getItem());
        $item->close();
    }

    protected function isUnderAttack(): bool {
        return false;
    }

    protected function takeDefensiveAction(): void {
        $this->wanderRandomly();
    }
}
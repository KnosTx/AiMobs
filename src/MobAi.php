<?php
/**
 * @license MIT
 */

namespace clousclouds\mobai;

use pocketmine\entity\Entity;

class MobAI extends Ai {

    public function think(): void {
        parent::think();
    }

    public function move(): void {
        parent::move();
    }

    public function interact(): void {
        parent::interact();
    }

    public function attack(): void {
        parent::attack();
    }

    public function defend(): void {
        parent::defend();
    }

    protected function wanderRandomly(): void {
        $randomDirection = new Vector3(rand(-1, 1), 0, rand(-1, 1));
        $this->mob->setMotion($randomDirection->normalize());
    }

    protected function navigateTo(Entity $target): void {
        $direction = $target->getPosition()->subtract($this->mob->getPosition())->normalize();
        $this->mob->setMotion(new Vector3($direction->x, 0, $direction->z));
    }
}
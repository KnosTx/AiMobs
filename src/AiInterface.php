<?php
/**
 * @license MIT
 */

namespace clousclouds/mobai;

interface AiInterface {
  public function think() : void{}
  public function move() : void{}
  public function interact() : void{}
  public function attack() : void{}
  public function defend() : void{}
}
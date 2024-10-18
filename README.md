# Mob AI Library

## Overview

This library provides an extensible AI system for mobs in PocketMine-MP using the `clousclouds\mobai` namespace. It allows developers to easily integrate AI behaviors such as movement, attacking, and interaction with the game world. The library is designed for flexibility, enabling custom AI logic for various entities.

## Features

- **AI Interface (`AiInterface`)**: Defines core AI methods (`think`, `move`, `interact`, `attack`, `defend`).
- **Base AI Implementation (`Ai`)**: Implements default AI behaviors such as random movement, player detection, and attack logic.
- **Customizable Mob AI (`MobAI`)**: Extendable class for specific mob behaviors.
- **No World Generators**: Focus solely on entity AI logic without world manipulation.
- **MIT License**: Open-source and free to use.

## Requirements

- **PocketMine-MP**: API version 5.
- **PHP**: 8.1 or higher.
- **Composer**: To manage the dependency and autoloading.

## Installation

1. Install via Composer:
   ```bash
   composer require clousclouds/mobai

2. Ensure that Composer's autoloader is included in your project:
```bash
require 'vendor/autoload.php';
```


## Usage

### Basic AI Setup

To create an AI for your mob:

1. Inherit from the MobAI class:
```php
use clousclouds\mobai\MobAI;
use pocketmine\entity\Entity;

class CustomMobAI extends MobAI {
    public function think(): void {
        parent::think(); // Use the base logic
        // Add custom behavior here
    }

    public function move(): void {
        parent::move(); // Use the base movement logic
        // Add custom movement logic here
    }
}
```

2. Assign AI to a Mob:

In your project, assign the AI to the mob when spawning or initializing:
```php
$mob = new YourMobClass($position); // Replace with your mob entity
$ai = new CustomMobAI($mob);
$mob->setAI($ai);
```


### Extending Logic

You can easily extend or override existing AI methods like think(), move(), or attack() in your custom AI class to implement specific behaviors.

For example, adding custom attack logic:
```php
public function attack(): void {
    if ($this->target && $this->isInRange($this->target)) {
        $this->performAttack($this->target);
        // Custom logic after attack
        $this->celebrateAttack(); // Example of custom logic
    }
}

protected function celebrateAttack(): void {
    // Custom behavior after a successful attack
}
```
## License

This project is licensed under the [LICENSE](MIT License)
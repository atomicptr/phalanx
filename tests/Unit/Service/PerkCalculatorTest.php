<?php

use App\Enums\ArmourType;
use App\Service\PerkCalculator;

test('PerkCalculator::forLevel', function () {
    $data = PerkCalculator::forLevel(ArmourType::HEAD, 20);
    expect($data['a'])->toBe(2);
    expect($data['b'])->toBe(3);
    expect($data['c'])->toBe(2);
    expect($data['d'])->toBe(0);

    $data = PerkCalculator::forLevel(ArmourType::TORSO, 20);
    expect($data['a'])->toBe(3);
    expect($data['b'])->toBe(2);
    expect($data['c'])->toBe(0);
    expect($data['d'])->toBe(0);

    $data = PerkCalculator::forLevel(ArmourType::ARMS, 20);
    expect($data['a'])->toBe(2);
    expect($data['b'])->toBe(2);
    expect($data['c'])->toBe(2);
    expect($data['d'])->toBe(0);

    $data = PerkCalculator::forLevel(ArmourType::LEGS, 20);
    expect($data['a'])->toBe(3);
    expect($data['b'])->toBe(0);
    expect($data['c'])->toBe(0);
    expect($data['d'])->toBe(2);
});

test('PerkCalculator::calculateForLevel', function () {
    $data = PerkCalculator::calculateForLevel(ArmourType::HEAD, 6, 34, 72, 63, 20); // this is for charrog pieces
    expect($data['6'])->toBe(2);
    expect($data['34'])->toBe(3);
    expect($data['72'])->toBe(2);
    expect(array_key_exists('63', $data))->toBeFalse();

    $data = PerkCalculator::calculateForLevel(ArmourType::TORSO, 6, 34, 72, 63, 20); // this is for charrog pieces
    expect($data['6'])->toBe(3);
    expect($data['34'])->toBe(2);
    expect(array_key_exists('72', $data))->toBeFalse();
    expect(array_key_exists('63', $data))->toBeFalse();

    $data = PerkCalculator::calculateForLevel(ArmourType::ARMS, 6, 34, 72, 63, 20); // this is for charrog pieces
    expect($data['6'])->toBe(2);
    expect($data['34'])->toBe(2);
    expect($data['72'])->toBe(2);
    expect(array_key_exists('63', $data))->toBeFalse();

    $data = PerkCalculator::calculateForLevel(ArmourType::LEGS, 6, 34, 72, 63, 20); // this is for charrog pieces
    expect($data['6'])->toBe(3);
    expect(array_key_exists('34', $data))->toBeFalse();
    expect(array_key_exists('72', $data))->toBeFalse();
    expect($data['63'])->toBe(2);
});

test('PerkCalculator::calculate', function () {
    $data = PerkCalculator::calculate(ArmourType::HEAD, 6, 34, 72, 63);
    expect($data)->toBe([
        [
            'min_level' => 1,
            'perks' => [
                '34' => 1,
            ],
        ],
        [
            'min_level' => 5,
            'perks' => [
                '6' => 1,
                '34' => 2,
            ],
        ],
        [
            'min_level' => 10,
            'perks' => [
                '6' => 2,
                '34' => 2,
                '72' => 1,
            ],
        ],
        [
            'min_level' => 15,
            'perks' => [
                '6' => 2,
                '34' => 2,
                '72' => 2,
            ],
        ],
        [
            'min_level' => 20,
            'perks' => [
                '6' => 2,
                '34' => 3,
                '72' => 2,
            ],
        ],
    ]);

    $data = PerkCalculator::calculate(ArmourType::TORSO, 6, 34, 72, 63);
    expect($data)->toBe([
        [
            'min_level' => 5,
            'perks' => [
                '34' => 1,
            ],
        ],
        [
            'min_level' => 10,
            'perks' => [
                '6' => 1,
                '34' => 2,
            ],
        ],
        [
            'min_level' => 15,
            'perks' => [
                '6' => 2,
                '34' => 2,
            ],
        ],
        [
            'min_level' => 20,
            'perks' => [
                '6' => 3,
                '34' => 2,
            ],
        ],
    ]);
});

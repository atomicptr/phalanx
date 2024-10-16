<?php

use App\Utils\VersionUtil;

test('VersionUtil::isValid', function () {
    expect(VersionUtil::isValid('1.0.0'))->toBeTrue();
    expect(VersionUtil::isValid('0.0.0'))->toBeTrue();
    expect(VersionUtil::isValid('13.3.7'))->toBeTrue();
    expect(VersionUtil::isValid('1.0.0.0'))->toBeFalse();
    expect(VersionUtil::isValid(''))->toBeFalse();
    expect(VersionUtil::isValid('..'))->toBeFalse();
});

test('VersionUtil::parse', function () {
    expect(VersionUtil::parse('1.0.0'))->toBe([1, 0, 0]);
    expect(VersionUtil::parse('13.3.7'))->toBe([13, 3, 7]);
    expect(VersionUtil::parse('0.0.0'))->toBe([0, 0, 0]);
});

test('VersionUtil::compare', function () {
    expect(VersionUtil::compare('1.0.0', '1.0.0'))->toBe(0);
    expect(VersionUtil::compare('1.0.0', '1.0.1'))->toBe(-1);
    expect(VersionUtil::compare('1.0.0', '0.0.0'))->toBe(1);
    expect(VersionUtil::compare('1.0.0', '0.9999.9999'))->toBe(1);
    expect(VersionUtil::compare('1.0.0', '1.1.0'))->toBe(-1);
});

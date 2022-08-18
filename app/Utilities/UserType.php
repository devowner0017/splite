<?php


namespace App\Utilities;

class UserType {

    const MERCHANT = 'merchant';
    const PLANNER = 'planner';

    private function __construct() {}

    public static function all(): array {
        return [
            self::MERCHANT,
            self::PLANNER,
        ];
    }

    public static function allCSV(): string {
        return implode(',', self::all());
    }
}

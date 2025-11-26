<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait EnumValue
{
    public static function getEnumValues($column = null)
    {
        // Get the table name and connection used by the model
        $table = (new static)->getTable();
        $connection = DB::connection((new static)->connection);

        // Get the schema for the table's columns
        $fields = $connection->select(DB::raw("SHOW COLUMNS FROM $table"));
        $result = [];

        foreach ($fields as $field) {
            $enum = self::parseEnumValues($field->Type);
            if (!empty($enum)) {
                // If a column name is provided, return its enum values
                if ($column && $field->Field == $column) {
                    return $enum;
                }

                $result[$field->Field] = $enum;
            }
        }

        // If no column name is provided, return all enum values
        return $result;
    }

    private static function parseEnumValues($type)
    {
        // Regex to match ENUM type and capture values inside parentheses
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];

        if (empty($matches)) {
            return null;
        }

        // Split enum values by commas and trim spaces and quotes
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum[$v] = $v;
        }

        return $enum;
    }
}
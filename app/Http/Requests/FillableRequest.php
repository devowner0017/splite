<?php

namespace App\Http\Requests;

trait FillableRequest {

    protected array $fillable = [];

    public abstract function all($keys = null);

    public function getFillableData(): array {
        $data = $this->all();
        $fillableData = [];

        foreach ($data as $field => $value) {
            if (in_array($field, $this->fillable)) {
                $fillableData[$field] = $value;
            }
        }

        return $fillableData;
    }
}

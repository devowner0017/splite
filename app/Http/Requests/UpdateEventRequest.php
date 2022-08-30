<?php

namespace App\Http\Requests;

class UpdateEventRequest extends PlannerRequest {
    use FillableRequest;

    public function __construct(array $query = [],
                                array $request = [],
                                array $attributes = [],
                                array $cookies = [],
                                array $files = [],
                                array $server = [],
                                $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->fillable = [
            'guests_count',
            'event_id',
        ];
    }

    public function rules(): array {
        return [
            'event_id' => 'required|exists:events,id',
            'guests_count' => 'required|numeric|min:1|max:1000000',
        ];
    }
}

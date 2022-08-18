<?php

namespace App\Http\Requests;

class CreateEventRequest extends PlannerRequest {
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
            'date',
            'start_time',
            'end_time',
            'guests_count',
            'service_id',
            'event_type_id',
        ];
    }

    public function rules(): array {
        return [
            'service_id' => 'required|exists:services,id',
            'event_type_id' => 'required|exists:event_types,id',
            'date' => 'required|date_format:Y-m-d|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'guests_count' => 'required|numeric|min:1|max:1000000',
        ];
    }
}

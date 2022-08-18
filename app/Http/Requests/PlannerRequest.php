<?php

namespace App\Http\Requests;

use App\Models\Planner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class PlannerRequest extends FormRequest {

    protected ?Planner $planner;

    public function getPlanner(): ?Planner {
        return $this->planner;
    }

    public function authorize(): bool {
        $this->planner = Planner::query()
            ->where('user_id', Auth::user()->id)
            ->first();

        return (bool) $this->planner;
    }

    public abstract function rules(): array;
}

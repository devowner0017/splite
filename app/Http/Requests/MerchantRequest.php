<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

abstract class MerchantRequest extends FormRequest {

    protected ?Merchant $merchant;

    public function getMerchant(): ?Merchant {
        return $this->merchant;
    }

    public function authorize(): bool {
        $this->merchant = Merchant::query()
            ->where('user_id', Auth::user()->id)
            ->first();

        return (bool) $this->merchant;
    }

    public abstract function rules(): array;
}

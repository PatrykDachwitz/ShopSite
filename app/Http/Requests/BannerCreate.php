<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Rules\DateRule;
use App\Rules\StringRule;
use Illuminate\Foundation\Http\FormRequest;

class BannerCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ['required', new StringRule(), 'min:3', 'max: 255'],
            "start-date" => ['required', 'date'],
            "end-date" => ['required', 'date'],
            "type" => ['required', 'Integer', 'min:1'],
            "active" => ['required', 'Boolean'],
            'position' => ['Integer', "min:1"]
        ];
    }
}

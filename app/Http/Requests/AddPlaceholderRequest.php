<?php

namespace App\Http\Requests;

use App\Club;
use App\Http\Requests\Request;

class AddPlaceholderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return Club::where([
        'slug' => $this->slug,
        'user_id' => $this->user()->id
      ])->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'placeholder' => 'required|mimes:jpg,png,gif'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TasksStoreRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'url' => 'required|url',

        ];
    }

    public function messages() {
        return [
            'url.required' => 'Fill the URL field please',
            'url.url'      => "It's not looks like valid url :(",
        ];
    }
}

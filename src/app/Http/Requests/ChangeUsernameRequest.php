<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class ChangeUsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('profile.can_change_username');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();
        return [
            'username' => ['required', 'alpha_dash', 'unique:users,username,'.$user->id.',id']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Veuillez indiquer un pseudo',
            'username.unique' => 'Ce pseudo est déjà utilisé !',
            'username.alpha_dash' => 'Le pseudo doit seulement contenir des lettres, des chiffres et des tirets'
        ];
    }
}

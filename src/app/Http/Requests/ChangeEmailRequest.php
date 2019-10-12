<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class ChangeEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('profile.can_change_email');
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
            'email' => ['required', 'email', 'unique:users,email,'.$user->id.',id']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Veuillez indiquer une adresse email',
            'email.email' => 'Veuillez entrer une adresse email correcte',
            'email.unique' => 'Cette adresse email est déjà utilisée !'
        ];
    }
}

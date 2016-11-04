<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;

class ChangeEmalRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('profile.can_change_email');
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

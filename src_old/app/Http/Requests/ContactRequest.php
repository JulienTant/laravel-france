<?php

namespace LaravelFrance\Http\Requests;

class ContactRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'phone' => ['required', 'email'],
            'email' => ['max:0'],
            'subject' => ['required', 'min:3'],
            'mailContent' => ['required', 'min:30'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le champ nom est obligatoire.',
            'name.min' => 'Le nom renseigné est trop court (min: :min).',
            'phone.required' => 'Le champ email est obligatoire.',
            'phone.email' => 'Le format de l’adresse email est invalide.',
            'subject.required' => 'Le champ sujet est obligatoire.',
            'subject.min' => 'Le sujet renseigné est trop court (min: :min).',
            'mailContent.required' => 'Le champ message est obligatoire.',
            'mailContent.min' => 'Le message renseigné est trop court (min: :min).',
            'email.max' => '------------------ lol ----------------------',
        ];
    }


}

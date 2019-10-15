<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use LaravelFrance\ForumsCategory;

class StoreTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::check('forums.can_create_topic', [ForumsCategory::find($this->get('category'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'category' => ['required', 'exists:forums_categories,id'],
            'markdown' => 'required|min:20',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Veuillez insérer un titre',
            'title.min' => 'Votre titre est trop court (min: 3)',
            'markdown.required' => 'Veuillez insérer un message',
            'markdown.min' => 'Votre message est trop court (min: 20)',
            'category.required' => 'Veuillez selectionner une catégorie',
            'category.exists' => 'La catégorie selectionnée n\'existe pas',
        ];
    }


}

<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFrance\ForumsCategory;

class StoreTopicRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('forums.can_create_topic', ['category' => ForumsCategory::find($this->get('category'))]);
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

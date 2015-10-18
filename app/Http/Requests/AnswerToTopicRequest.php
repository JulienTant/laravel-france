<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFrance\ForumsTopic;

class AnswerToTopicRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('forums.can_reply_to_topic', ['topic' => ForumsTopic::find($this->route('topicId'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'markdown' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'markdown.required' => 'Veuillez insérer un message',
            'markdown.min' => 'Votre réponse est trop court (min: 2)',
        ];
    }


}

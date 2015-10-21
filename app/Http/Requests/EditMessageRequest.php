<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFrance\ForumsMessage;

class EditMessageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('forums.can_reply_to_topic', ['message' => ForumsMessage::find($this->route('messageId'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var ForumsMessage $message */
        $message = ForumsMessage::findOrFail($this->route('messageId'));

        $max = $message->forumsTopic->firstMessage->id == $message->id ? 20 : 2;

        return [
            'markdown' => 'required|min:' . $max,
        ];
    }

    public function messages()
    {
        return [
            'markdown.required' => 'Veuillez insérer un message',
            'markdown.min' => 'Votre réponse est trop courte (min: :min)',
        ];
    }
}

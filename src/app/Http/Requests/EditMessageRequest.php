<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use LaravelFrance\ForumsMessage;

class EditMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('forums.can_edit_message', [ForumsMessage::find($this->route('messageId'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('GET')) {
            return [];
        }

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

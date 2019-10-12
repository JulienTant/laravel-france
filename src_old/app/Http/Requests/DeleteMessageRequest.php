<?php

namespace LaravelFranceOld\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFranceOld\ForumsMessage;

class DeleteMessageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('forums.can_remove_message', ['message' => ForumsMessage::find($this->route('messageId'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

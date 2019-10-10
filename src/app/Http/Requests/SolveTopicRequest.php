<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFrance\ForumsTopic;

class SolveTopicRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('forums.can_mark_as_solve', ['message' => ForumsTopic::find($this->route('topicId'))->forumsMessages()->find($this->route('messageId'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

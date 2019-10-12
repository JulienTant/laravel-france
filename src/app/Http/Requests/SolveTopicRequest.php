<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use LaravelFrance\ForumsTopic;

class SolveTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('forums.can_mark_as_solve', [ForumsTopic::whereSlug($this->route('topicSlug'))->first()->forumsMessages()->find($this->input('message_id'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message_id' => 'required'
        ];
    }
}

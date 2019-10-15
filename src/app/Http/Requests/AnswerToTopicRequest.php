<?php

namespace LaravelFrance\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsTopic;

class AnswerToTopicRequest extends FormRequest
{
    public $redirect;
    public $topic;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->redirect = \URL::previous().'#answer_form';
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize()
    {
        $chosenCategory = ForumsCategory::whereSlug($this->route('categorySlug'))->firstOrFail();
        $topic = ForumsTopic::whereForumsCategoryId($chosenCategory->id)
            ->whereSlug($this->route('topicSlug'))
            ->firstOrFail();

        $this->topic = $topic;

        return Gate::check('forums.can_reply_to_topic', [$topic]);
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
            'markdown.min' => 'Votre réponse est trop courte (min: 2)',
        ];
    }


}

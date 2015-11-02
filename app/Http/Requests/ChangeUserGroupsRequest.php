<?php

namespace LaravelFrance\Http\Requests;

use Illuminate\Contracts\Auth\Access\Gate;
use LaravelFrance\Http\Requests\Request;

class ChangeUserGroupsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Gate $gate
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        return $gate->check('admin.can_manage_users');
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

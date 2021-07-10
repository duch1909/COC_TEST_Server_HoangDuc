<?php

namespace Mi\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** @SuppressWarnings(PHPMD.NumberOfChildren.minimum) */
abstract class BaseRequest extends FormRequest
{
    const INT_32_MAX = 2147483647;
    const INT_32_MIN = 1;
    const ORDER_DEFAULT_LENGTH = 100;
    const WITH_DEFAULT_LENGTH = 100;
    const PER_PAGE_DEFAULT_MAX = 50;
    const SORTED_DEFAULT_LENGHT = 4;

    /**
     * Common list rules
     *
     * @return array
     */
    public function commonListRules()
    {
        return [
            'page' => [
                'bail',
                'sometimes',
                'integer'
            ],
            'per_page' => [
                'bail',
                'sometimes',
                'integer',
                'min:' . self::INT_32_MIN,
                'max:' . self::PER_PAGE_DEFAULT_MAX
            ],
            'orderBy' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::ORDER_DEFAULT_LENGTH
            ],
            'sortedBy' => [
                'bail',
                'sometimes',
                'string',
                'max:' . self::SORTED_DEFAULT_LENGHT,
                Rule::in(['asc', 'desc'])
            ]
        ];
    }
}

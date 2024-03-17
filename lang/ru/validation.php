<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, когда :other равно :value.',
    'active_url' => 'Поле :attribute не является допустимым URL.',
    'after' => 'Поле :attribute должно быть датой после :date.',
    'after_or_equal' => 'Поле :attribute должно быть датой после или равной :date.',
    'alpha' => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'before' => 'Поле :attribute должно быть датой до :date.',
    'before_or_equal' => 'Поле :attribute должно быть датой до или равной :date.',
    'between' => [
        'array' => 'Поле :attribute должно содержать от :min до :max элементов.',
        'file' => 'Размер файла в поле :attribute должен быть от :min до :max килобайт.',
        'numeric' => 'Значение поля :attribute должно быть от :min до :max.',
        'string' => 'Длина поля :attribute должна быть от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть true или false.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'current_password' => 'Неверный пароль.',
    'date' => 'Поле :attribute не является допустимой датой.',
    'date_equals' => 'Поле :attribute должно быть равным дате :date.',
    'date_format' => 'Поле :attribute не соответствует формату :format.',
    'declined' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено, когда :other равно :value.',
    'different' => 'Поля :attribute и :other должны отличаться.',
    'digits' => 'Поле :attribute должно содержать :digits цифр.',
    'digits_between' => 'Поле :attribute должно содержать от :min до :max цифр.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
    'doesnt_end_with' => 'Поле :attribute не может заканчиваться на одно из следующих значений: :values.',
    'doesnt_start_with' => 'Поле :attribute не может начинаться на одно из следующих значений: :values.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'ends_with' => 'Поле :attribute должно заканчиваться на одно из следующих значений: :values.',
    'enum' => 'Выбранное значение :attribute недопустимо.',
    'exists' => 'Выбранное значение :attribute недопустимо.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'Поле :attribute должно содержать более :value элементов.',
        'file' => 'Размер файла в поле :attribute должен быть больше :value килобайт.',
        'numeric' => 'Значение поля :attribute должно быть больше :value.',
        'string' => 'Длина поля :attribute должна быть больше :value символов.',
    ],
    'gte' => [
        'array' => 'Поле :attribute должно содержать :value элементов или больше.',
        'file' => 'Размер файла в поле :attribute должен быть больше или равен :value килобайт.',
        'numeric' => 'Значение поля :attribute должно быть больше или равно :value.',
        'string' => 'Длина поля :attribute должна быть больше или равна :value символов.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное значение :attribute недопустимо.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4' => 'Поле :attribute должно быть действительным IPv4-адресом.',
    'ipv6' => 'Поле :attribute должно быть действительным IPv6-адресом.',
    'json' => 'Поле :attribute должно быть допустимой JSON-строкой.',
    'lt' => [
        'array' => 'Поле :attribute должно содержать менее :value элементов.',
        'file' => 'Размер файла в поле :attribute должен быть меньше :value килобайт.',
        'numeric' => 'Значение поля :attribute должно быть меньше :value.',
        'string' => 'Длина поля :attribute должна быть меньше :value символов.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не может содержать более :value элементов.',
        'file' => 'Размер файла в поле :attribute должен быть меньше или равен :value килобайт.',
        'numeric' => 'Значение поля :attribute должно быть меньше или равно :value.',
        'string' => 'Длина поля :attribute должна быть меньше или равна :value символов.',
    ],

    'mac_address' => 'Поле :attribute должно быть действительным MAC-адресом.',
    'max' => [
        'array' => 'Поле :attribute не может содержать более :max элементов.',
        'file' => 'Размер файла в поле :attribute не может превышать :max килобайт.',
        'numeric' => 'Значение поля :attribute не может быть больше :max.',
        'string' => 'Длина поля :attribute не может быть больше :max символов.',
    ],
    'max_digits' => 'Поле :attribute не может содержать более :max цифр.',
    'mimes' => 'Поле :attribute должно быть файлом типа: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом типа: :values.',
    'min' => [
        'array' => 'Поле :attribute должно содержать как минимум :min элементов.',
        'file' => 'Размер файла в поле :attribute должен быть не менее :min килобайт.',
        'numeric' => 'Значение поля :attribute должно быть не менее :min.',
        'string' => 'Длина поля :attribute должна быть не менее :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать как минимум :min цифр.',
    'multiple_of' => 'Поле :attribute должно быть кратным :value.',
    'not_in' => 'Выбранное значение :attribute недопустимо.',
    'not_regex' => 'Формат поля :attribute недопустим.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'password' => [
        'letters' => 'Поле :attribute должно содержать как минимум одну букву.',
        'mixed' => 'Поле :attribute должно содержать как минимум одну заглавную и одну прописную букву.',
        'numbers' => 'Поле :attribute должно содержать как минимум одну цифру.',
        'symbols' => 'Поле :attribute должно содержать как минимум один символ.',
        'uncompromised' => 'Данное значение :attribute появилось в утечке данных. Пожалуйста, выберите другое значение :attribute.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает наличие поля :other.',
    'regex' => 'Формат поля :attribute недопустим.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
    'required_if_accepted' => 'Поле :attribute обязательно для заполнения, когда :other принято.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, если :other не находится в :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда присутствует :values.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, когда присутствуют все значения :values.',
    'required_without' => 'Поле :attribute обязательно для заполнения, когда отсутствует значение :values.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда отсутствуют все значения :values.',
    'same' => 'Поля :attribute и :other должны совпадать.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Размер файла в поле :attribute должен быть равен :size килобайт.',
        'numeric' => 'Значение поля :attribute должно быть равно :size.',
        'string' => 'Длина поля :attribute должна быть равна :size символов.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих значений: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique' => 'Значение поля :attribute уже занято.',
    'uploaded' => 'Не удалось загрузить файл в поле :attribute.',
    'url' => 'Поле :attribute должно быть действительным URL-адресом.',
    'uuid' => 'Поле :attribute должно быть действительным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

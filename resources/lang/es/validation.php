<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL válida.',
    'after'                => 'La :attribute debe ser mayor a :date.',
    'after_or_equal'       => 'La :attribute debe ser mayor o igual :date.',
    'alpha'                => 'El :attribute solo puede contener letras.',
    'alpha_dash'           => 'El :attribute solo puede contener letras, números y guiones.',
    'alpha_num'            => 'El :attribute solo puede contener letras y números.',
    'array'                => 'El :attribute debe ser un arreglo.',
    'before'               => 'La :attribute debe ser menor a :date.',
    'before_or_equal'      => 'La :attribute debe ser menor o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe ser entre :min y :max.',
        'file'    => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min y :max caracteres.',
        'array'   => 'El :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'El :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El :attribute no fue confirmado.',
    'date'                 => 'El :attribute no es una fecha válida.',
    'date_format'          => 'El :attribute no tiene el formato correcto :format.',
    'different'            => 'El :attribute y :other deben ser diferentes.',
    'digits'               => 'El :attribute deben ser :digits digitos.',
    'digits_between'       => 'El :attribute deben ser entre :min y :max digitos.',
    'dimensions'           => 'El :attribute tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El :attribute tiene un valor duplicado.',
    'email'                => 'El :attribute debe ser un correo electrónico.',
    'exists'               => 'La opcion seleccionada :attribute no es válida.',
    'file'                 => 'El :attribute debe ser un archivo.',
    'filled'               => 'El :attribute no puede estar vacío.',
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El selected :attribute is invalid.',
    'in_array'             => 'El :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un entero.',
    'ip'                   => 'El :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El :attribute debe contener un formato JSON.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser más grande que :max.',
        'file'    => 'El :attribute no puede ser más grande que :max kilobytes.',
        'string'  => 'El :attribute no debe tener más de :max caracteres.',
        'array'   => 'El :attribute no debe tener más de :max elementos.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser de al menos :min.',
        'file'    => 'El :attribute debe ser de al menos :min kilobytes.',
        'string'  => 'El :attribute debe tener al menos :min caracteres.',
        'array'   => 'El :attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => 'La opción seleccionada :attribute no es válida.',
    'numeric'              => 'El :attribute debe ser un número.',
    'present'              => 'El :attribute debe ser actual.',
    'regex'                => 'El :attribute no tiene un formato válido.',
    'required'             => 'El :attribute es obligatorio.',
    'required_if'          => 'El :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El :attribute es obligatorio menos cuando :other esté en :values.',
    'required_with'        => 'El :attribute es obligatorio cuando los valores sean :values .',
    'required_with_all'    => 'El :attribute es obligatorio cuando los valores sean :values .',
    'required_without'     => 'El :attribute es obligatorio cuando los valores no sean :values .',
    'required_without_all' => 'El :attribute es obligatorio cuando los valores no sean :values .',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe tener :size caracteres.',
        'array'   => 'El :attribute debe contener :size elementos.',
    ],
    'string'               => 'El :attribute debe ser una cadena de texto.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => 'El :attribute ya existe un registro con ese valor.',
    'uploaded'             => 'El :attribute fallo al subirse.',
    'url'                  => 'El :attribute no tiene un formato válido.',

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
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

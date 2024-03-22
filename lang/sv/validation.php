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

    'accepted' => 'Fältet :attribute måste accepteras.',
    'accepted_if' => 'Fältet :attribute måste accepteras när :other är :value.',
    'active_url' => 'Fältet :attribute måste vara en giltig URL.',
    'after' => 'Fältet :attribute måste vara ett datum efter :date.',
    'after_or_equal' => 'Fältet :attribute måste vara ett datum efter eller lika med :date.',
    'alpha' => 'Fältet :attribute får endast innehålla bokstäver.',
    'alpha_dash' => 'Fältet :attribute får endast innehålla bokstäver, siffror, bindestreck och understreck.',
    'alpha_num' => 'Fältet :attribute får endast innehålla bokstäver och siffror.',
    'array' => 'Fältet :attribute måste vara en array.',
    'ascii' => 'Fältet :attribute får endast innehålla enstaka alfanumeriska tecken och symboler.',
    'before' => 'Fältet :attribute måste vara ett datum före :date.',
    'before_or_equal' => 'Fältet :attribute måste vara ett datum före eller lika med :date.',
    'between' => [
        'array' => 'Fältet :attribute måste ha mellan :min och :max objekt.',
        'file' => 'Fältet :attribute måste vara mellan :min och :max kilobyte.',
        'numeric' => 'Fältet :attribute måste vara mellan :min och :max.',
        'string' => 'Fältet :attribute måste vara mellan :min och :max tecken.',
    ],
    'boolean' => 'Fältet :attribute måste vara sant eller falskt.',
    'can' => 'Fältet :attribute innehåller ett obehörigt värde.',
    'confirmed' => 'Bekräftelsen av fältet :attribute matchar inte.',
    'current_password' => 'Lösenordet är felaktigt.',
    'date' => 'Fältet :attribute måste vara ett giltigt datum.',
    'date_equals' => 'Fältet :attribute måste vara ett datum lika med :date.',
    'date_format' => 'Fältet :attribute måste matcha formatet :format.',
    'decimal' => 'Fältet :attribute måste ha :decimal decimaler.',
    'declined' => 'Fältet :attribute måste avböjas.',
    'declined_if' => 'Fältet :attribute måste avböjas när :other är :value.',
    'different' => 'Fältet :attribute och :other måste vara olika.',
    'digits' => 'Fältet :attribute måste vara :digits siffror.',
    'digits_between' => 'Fältet :attribute måste vara mellan :min och :max siffror.',
    'dimensions' => 'Fältet :attribute har ogiltiga bildmått.',
    'distinct' => 'Fältet :attribute har ett dubbelt värde.',
    'doesnt_end_with' => 'Fältet :attribute får inte sluta med något av följande: :values.',
    'doesnt_start_with' => 'Fältet :attribute får inte börja med något av följande: :values.',
    'email' => 'Fältet :attribute måste vara en giltig e-postadress.',
    'ends_with' => 'Fältet :attribute måste sluta med något av följande: :values.',
    'enum' => 'Det valda :attribute är ogiltigt.',
    'exists' => 'Det valda :attribute är ogiltigt.',
    'extensions' => 'Fältet :attribute måste ha en av följande filändelser: :values.',
    'file' => 'Fältet :attribute måste vara en fil.',
    'filled' => 'Fältet :attribute måste ha ett värde.',

    'gt' => [
        'array' => 'Fältet :attribute måste ha fler än :value objekt.',
        'file' => 'Fältet :attribute måste vara större än :value kilobyte.',
        'numeric' => 'Fältet :attribute måste vara större än :value.',
        'string' => 'Fältet :attribute måste vara längre än :value tecken.',
    ],
    'gte' => [
        'array' => 'Fältet :attribute måste ha :value objekt eller mer.',
        'file' => 'Fältet :attribute måste vara större än eller lika med :value kilobyte.',
        'numeric' => 'Fältet :attribute måste vara större än eller lika med :value.',
        'string' => 'Fältet :attribute måste vara längre än eller lika med :value tecken.',
    ],
    'hex_color' => 'Fältet :attribute måste vara en giltig hexadecimal färgkod.',
    'image' => 'Fältet :attribute måste vara en bild.',
    'in' => 'Det valda :attribute är ogiltigt.',
    'in_array' => 'Fältet :attribute måste finnas i :other.',
    'integer' => 'Fältet :attribute måste vara ett heltal.',
    'ip' => 'Fältet :attribute måste vara en giltig IP-adress.',
    'ipv4' => 'Fältet :attribute måste vara en giltig IPv4-adress.',
    'ipv6' => 'Fältet :attribute måste vara en giltig IPv6-adress.',
    'json' => 'Fältet :attribute måste vara en giltig JSON-sträng.',
    'list' => 'Fältet :attribute måste vara en lista.',
    'lowercase' => 'Fältet :attribute måste vara gemener.',

    'lt' => [
        'array' => 'Fältet :attribute måste ha färre än :value objekt.',
        'file' => 'Fältet :attribute måste vara mindre än :value kilobyte.',
        'numeric' => 'Fältet :attribute måste vara mindre än :value.',
        'string' => 'Fältet :attribute måste vara kortare än :value tecken.',
    ],
    'lte' => [
        'array' => 'Fältet :attribute får inte ha fler än :value objekt.',
        'file' => 'Fältet :attribute måste vara mindre än eller lika med :value kilobyte.',
        'numeric' => 'Fältet :attribute måste vara mindre än eller lika med :value.',
        'string' => 'Fältet :attribute måste vara kortare än eller lika med :value tecken.',
    ],
    'mac_address' => 'Fältet :attribute måste vara en giltig MAC-adress.',
    'max' => [
        'array' => 'Fältet :attribute får inte ha fler än :max objekt.',
        'file' => 'Fältet :attribute får inte vara större än :max kilobyte.',
        'numeric' => 'Fältet :attribute får inte vara större än :max.',
        'string' => 'Fältet :attribute får inte vara längre än :max tecken.',
    ],
    'max_digits' => 'Fältet :attribute får inte ha fler än :max siffror.',
    'mimes' => 'Fältet :attribute måste vara en fil av typen: :values.',
    'mimetypes' => 'Fältet :attribute måste vara en fil av typen: :values.',
    'min' => [
        'array' => 'Fältet :attribute måste ha minst :min objekt.',
        'file' => 'Fältet :attribute måste vara minst :min kilobyte.',
        'numeric' => 'Fältet :attribute måste vara minst :min.',
        'string' => 'Fältet :attribute måste vara minst :min tecken.',
    ],

    'min_digits' => 'Fältet :attribute måste ha minst :min siffror.',
    'missing' => 'Fältet :attribute måste saknas.',
    'missing_if' => 'Fältet :attribute måste saknas när :other är :value.',
    'missing_unless' => 'Fältet :attribute måste saknas om inte :other är :value.',
    'missing_with' => 'Fältet :attribute måste saknas när :values är närvarande.',
    'missing_with_all' => 'Fältet :attribute måste saknas när :values är närvarande.',
    'multiple_of' => 'Fältet :attribute måste vara en multipel av :value.',
    'not_in' => 'Det valda :attribute är ogiltigt.',
    'not_regex' => 'Formatet för fältet :attribute är ogiltigt.',
    'numeric' => 'Fältet :attribute måste vara ett nummer.',
    'password' => [
        'letters' => 'Fältet :attribute måste innehålla minst en bokstav.',
        'mixed' => 'Fältet :attribute måste innehålla minst en stor och en liten bokstav.',
        'numbers' => 'Fältet :attribute måste innehålla minst en siffra.',
        'symbols' => 'Fältet :attribute måste innehålla minst en symbol.',
        'uncompromised' => 'Det angivna :attribute har förekommit i en dataläcka. Välj ett annat :attribute.',
    ],

    'present' => 'Fältet :attribute måste vara närvarande.',
    'present_if' => 'Fältet :attribute måste vara närvarande när :other är :value.',
    'present_unless' => 'Fältet :attribute måste vara närvarande om inte :other är :value.',
    'present_with' => 'Fältet :attribute måste vara närvarande när :values är närvarande.',
    'present_with_all' => 'Fältet :attribute måste vara närvarande när :values är närvarande.',
    'prohibited' => 'Fältet :attribute är förbjudet.',
    'prohibited_if' => 'Fältet :attribute är förbjudet när :other är :value.',
    'prohibited_unless' => 'Fältet :attribute är förbjudet om inte :other är i :values.',
    'prohibits' => 'Fältet :attribute förbjuder :other från att vara närvarande.',
    'regex' => 'Formatet för fältet :attribute är ogiltigt.',
    'required' => 'Fältet :attribute är obligatoriskt.',
    'required_array_keys' => 'Fältet :attribute måste innehålla poster för: :values.',
    'required_if' => 'Fältet :attribute är obligatoriskt när :other är :value.',
    'required_if_accepted' => 'Fältet :attribute är obligatoriskt när :other är accepterat.',
    'required_unless' => 'Fältet :attribute är obligatoriskt om inte :other är i :values.',
    'required_with' => 'Fältet :attribute är obligatoriskt när :values är närvarande.',
    'required_with_all' => 'Fältet :attribute är obligatoriskt när :values är närvarande.',
    'required_without' => 'Fältet :attribute är obligatoriskt när :values inte är närvarande.',
    'required_without_all' => 'Fältet :attribute är obligatoriskt när ingen av :values är närvarande.',
    'same' => 'Fältet :attribute måste matcha :other.',

    'size' => [
        'array' => 'Fältet :attribute måste innehålla :size objekt.',
        'file' => 'Fältet :attribute måste vara :size kilobyte.',
        'numeric' => 'Fältet :attribute måste vara :size.',
        'string' => 'Fältet :attribute måste vara :size tecken.',
    ],
    'starts_with' => 'Fältet :attribute måste börja med en av följande: :values.',
    'string' => 'Fältet :attribute måste vara en sträng.',
    'timezone' => 'Fältet :attribute måste vara en giltig tidszon.',
    'unique' => 'Fältet :attribute har redan tagits.',
    'uploaded' => 'Det gick inte att ladda upp :attribute.',
    'uppercase' => 'Fältet :attribute måste vara versalt.',
    'url' => 'Fältet :attribute måste vara en giltig URL.',
    'ulid' => 'Fältet :attribute måste vara en giltig ULID.',
    'uuid' => 'Fältet :attribute måste vara en giltig UUID.',


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

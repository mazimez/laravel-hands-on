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

    'accepted' => 'Du måste acceptera :attribute.',
    'accepted_if' => ':attribute måste accepteras när :other är :value.',
    'active_url' => ':attribute är inte en giltig URL.',
    'after' => ':attribute måste vara ett datum efter :date.',
    'after_or_equal' => ':attribute måste vara ett datum efter eller lika med :date.',
    'alpha' => ':attribute får endast innehålla bokstäver.',
    'alpha_dash' => ':attribute får endast innehålla bokstäver, siffror, bindestreck och understreck.',
    'alpha_num' => ':attribute får endast innehålla bokstäver och siffror.',
    'array' => ':attribute måste vara en array.',
    'ascii' => ':attribute får endast innehålla enkelsbytessiffror, bokstäver och symboler.',
    'before' => ':attribute måste vara ett datum före :date.',
    'before_or_equal' => ':attribute måste vara ett datum före eller lika med :date.',
    'between' => [
        'array' => ':attribute måste ha mellan :min och :max objekt.',
        'file' => ':attribute måste vara mellan :min och :max kilobytes.',
        'numeric' => ':attribute måste vara mellan :min och :max.',
        'string' => ':attribute måste vara mellan :min och :max tecken.',
    ],
    'boolean' => ':attribute måste vara sant eller falskt.',
    'confirmed' => ':attribute bekräftelsen matchar inte.',
    'current_password' => 'Lösenordet är felaktigt.',
    'date' => ':attribute är inte ett giltigt datum.',
    'date_equals' => ':attribute måste vara ett datum lika med :date.',
    'date_format' => ':attribute matchar inte formatet :format.',
    'decimal' => ':attribute måste ha :decimal decimaler.',
    'declined' => ':attribute måste avböjas.',
    'declined_if' => ':attribute måste avböjas när :other är :value.',
    'different' => ':attribute och :other måste vara olika.',
    'digits' => ':attribute måste vara :digits siffror.',
    'digits_between' => ':attribute måste vara mellan :min och :max siffror.',
    'dimensions' => ':attribute har ogiltiga bildmått.',
    'distinct' => ':attribute fältet har ett duplicerat värde.',
    'doesnt_end_with' => ':attribute får inte sluta med något av följande: :values.',
    'doesnt_start_with' => ':attribute får inte börja med något av följande: :values.',
    'email' => ':attribute måste vara en giltig e-postadress.',
    'ends_with' => ':attribute måste sluta med något av följande: :values.',
    'enum' => 'Det valda :attribute är ogiltigt.',
    'exists' => 'Det valda :attribute är ogiltigt.',
    'file' => ':attribute måste vara en fil.',
    'filled' => ':attribute fältet måste ha ett värde.',
    'gt' => [
        'array' => ':attribute måste ha fler än :value objekt.',
        'file' => ':attribute måste vara större än :value kilobytes.',
        'numeric' => ':attribute måste vara större än :value.',
        'string' => ':attribute måste vara längre än :value tecken.',
    ],
    'gte' => [
        'array' => ':attribute måste ha :value objekt eller fler.',
        'file' => ':attribute måste vara större än eller lika med :value kilobytes.',
        'numeric' => ':attribute måste vara större än eller lika med :value.',
        'string' => ':attribute måste vara längre än eller lika med :value tecken.',
    ],
    'image' => ':attribute måste vara en bild.',
    'in' => 'Det valda :attribute är ogiltigt.',
    'in_array' => ':attribute fältet finns inte i :other.',
    'integer' => ':attribute måste vara ett heltal.',
    'ip' => ':attribute måste vara en giltig IP-adress.',
    'ipv4' => ':attribute måste vara en giltig IPv4-adress.',
    'ipv6' => ':attribute måste vara en giltig IPv6-adress.',
    'json' => ':attribute måste vara en giltig JSON-sträng.',
    'lowercase' => ':attribute måste vara gemener.',
    'lt' => [
        'array' => ':attribute får inte ha fler än :value objekt.',
        'file' => ':attribute måste vara mindre än :value kilobytes.',
        'numeric' => ':attribute måste vara mindre än :value.',
        'string' => ':attribute måste vara kortare än :value tecken.',
    ],
    'lte' => [
        'array' => ':attribute får inte ha fler än :value objekt.',
        'file' => ':attribute måste vara mindre än eller lika med :value kilobytes.',
        'numeric' => ':attribute måste vara mindre än eller lika med :value.',
        'string' => ':attribute måste vara kortare än eller lika med :value tecken.',
    ],
    'mac_address' => ':attribute måste vara en giltig MAC-adress.',
    'max' => [
        'array' => ':attribute får inte ha fler än :max objekt.',
        'file' => ':attribute får inte vara större än :max kilobytes.',
        'numeric' => ':attribute får inte vara större än :max.',
        'string' => ':attribute får inte vara längre än :max tecken.',
    ],
    'max_digits' => ':attribute får inte ha fler än :max siffror.',
    'mimes' => ':attribute måste vara en fil av typen: :values.',
    'mimetypes' => ':attribute måste vara en fil av typen: :values.',
    'min' => [
        'array' => ':attribute måste ha minst :min objekt.',
        'file' => ':attribute måste vara minst :min kilobytes.',
        'numeric' => ':attribute måste vara minst :min.',
        'string' => ':attribute måste vara minst :min tecken.',
    ],
    'min_digits' => ':attribute måste ha minst :min siffror.',
    'missing' => ':attribute fältet måste vara tomt.',
    'missing_if' => ':attribute fältet måste vara tomt när :other är :value.',
    'missing_unless' => ':attribute fältet måste vara tomt om inte :other är :value.',
    'missing_with' => ':attribute fältet måste vara tomt när :values är närvarande.',
    'missing_with_all' => ':attribute fältet måste vara tomt när :values är närvarande.',
    'multiple_of' => ':attribute måste vara en multipel av :value.',
    'not_in' => 'Det valda :attribute är ogiltigt.',
    'not_regex' => ':attribute formatet är ogiltigt.',
    'numeric' => ':attribute måste vara ett nummer.',
    'password' => [
        'letters' => ':attribute måste innehålla minst en bokstav.',
        'mixed' => ':attribute måste innehålla minst en stor bokstav och en liten bokstav.',
        'numbers' => ':attribute måste innehålla minst en siffra.',
        'symbols' => ':attribute måste innehålla minst en symbol.',
        'uncompromised' => 'Den angivna :attribute har förekommit i en dataläcka. Vänligen välj en annan :attribute.',
    ],
    'present' => ':attribute fältet måste vara närvarande.',
    'prohibited' => ':attribute fältet är förbjudet.',
    'prohibited_if' => ':attribute fältet är förbjudet när :other är :value.',
    'prohibited_unless' => ':attribute fältet är förbjudet om inte :other är i :values.',
    'prohibits' => ':attribute fältet förbjuder att :other är närvarande.',
    'regex' => ':attribute formatet är ogiltigt.',
    'required' => ':attribute fältet är obligatoriskt.',
    'required_array_keys' => ':attribute fältet måste innehålla poster för: :values.',
    'required_if' => ':attribute fältet är obligatoriskt när :other är :value.',
    'required_if_accepted' => ':attribute fältet är obligatoriskt när :other accepteras.',
    'required_unless' => ':attribute fältet är obligatoriskt om inte :other finns i :values.',
    'required_with' => ':attribute fältet är obligatoriskt när :values är närvarande.',
    'required_with_all' => ':attribute fältet är obligatoriskt när :values är närvarande.',
    'required_without' => ':attribute fältet är obligatoriskt när :values inte är närvarande.',
    'required_without_all' => ':attribute fältet är obligatoriskt när ingen av :values är närvarande.',
    'same' => ':attribute och :other måste matcha.',
    'size' => [
        'array' => ':attribute måste innehålla :size objekt.',
        'file' => ':attribute måste vara :size kilobytes.',
        'numeric' => ':attribute måste vara :size.',
        'string' => ':attribute måste vara :size tecken.',
    ],
    'starts_with' => ':attribute måste börja med något av följande: :values.',
    'string' => ':attribute måste vara en sträng.',
    'timezone' => ':attribute måste vara en giltig tidszon.',
    'unique' => ':attribute är redan upptaget.',
    'uploaded' => ':attribute misslyckades att ladda upp.',
    'uppercase' => ':attribute måste vara versaler.',
    'url' => ':attribute måste vara en giltig URL.',
    'ulid' => ':attribute måste vara en giltig ULID.',
    'uuid' => ':attribute måste vara en giltig UUID.',

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
            'rule-name' => 'anpassat-meddelande',
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

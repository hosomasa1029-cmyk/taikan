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

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeは有効なURLではありません。',
    'after' => ':attributeには:dateより後の日付を指定してください。',
    'after_or_equal' => ':attributeには:date以降の日付を指定してください。',
    'alpha' => ':attributeには英字のみ使用できます。',
    'alpha_dash' => ':attributeには英数字、ハイフン、アンダースコアのみ使用できます。',
    'alpha_num' => ':attributeには英数字のみ使用できます。',
    'array' => ':attributeには配列を指定してください。',
    'ascii' => ':attributeには半角の英数字や記号のみ使用できます。',
    'before' => ':attributeには:dateより前の日付を指定してください。',
    'before_or_equal' => ':attributeには:date以前の日付を指定してください。',
    'between' => [
        'array' => ':attributeの項目数は:min個から:max個の間にしてください。',
        'file' => ':attributeのファイルサイズは:min KBから:max KBの間にしてください。',
        'numeric' => ':attributeには:minから:maxまでの数値を指定してください。',
        'string' => ':attributeは:min文字から:max文字の間で指定してください。',
    ],
    'boolean' => ':attributeには真偽値を指定してください。',
    'confirmed' => ':attributeと確認用の値が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeは有効な日付ではありません。',
    'date_equals' => ':attributeは:dateと同じ日付を指定してください。',
    'date_format' => ':attributeの形式は:formatと一致しません。',
    'decimal' => ':attributeは小数点以下:decimal桁の数値を指定してください。',
    'declined' => ':attributeを拒否してください。',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否してください。',
    'different' => ':attributeと:otherには異なる値を指定してください。',
    'digits' => ':attributeは:digits桁の数字を指定してください。',
    'digits_between' => ':attributeは:min桁から:max桁の数字を指定してください。',
    'dimensions' => ':attributeの画像サイズが無効です。',
    'distinct' => ':attributeに重複した値が存在します。',
    'doesnt_end_with' => ':attributeは次のいずれかで終わってはいけません。: :values',
    'doesnt_start_with' => ':attributeは次のいずれかで始まってはいけません。: :values',
    'email' => ':attributeには有効なメールアドレスを指定してください。',
    'ends_with' => ':attributeは次のいずれかで終わる必要があります。: :values',
    'enum' => '選択された:attributeは無効です。',
    'exists' => '選択された:attributeは無効です。',
    'file' => ':attributeにはファイルを指定してください。',
    'filled' => ':attributeには値を指定してください。',
    'gt' => [
        'array' => ':attributeの項目数は:value個より多くなければなりません。',
        'file' => ':attributeのファイルサイズは:value KBより大きくなければなりません。',
        'numeric' => ':attributeは:valueより大きくなければなりません。',
        'string' => ':attributeは:value文字より長くなければなりません。',
    ],
    'gte' => [
        'array' => ':attributeの項目数は:value個以上でなければなりません。',
        'file' => ':attributeのファイルサイズは:value KB以上でなければなりません。',
        'numeric' => ':attributeは:value以上でなければなりません。',
        'string' => ':attributeは:value文字以上でなければなりません。',
    ],
    'image' => ':attributeには画像ファイルを指定してください。',
    'in' => '選択された:attributeは無効です。',
    'in_array' => ':attributeが:otherに存在しません。',
    'integer' => ':attributeには整数を指定してください。',
    'ip' => ':attributeには有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeには有効なIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには有効なIPv6アドレスを指定してください。',
    'json' => ':attributeには有効なJSON文字列を指定してください。',
    'lowercase' => ':attributeは小文字のみ使用できます。',
    'lt' => [
        'array' => ':attributeの項目数は:value個より少なくなければなりません。',
        'file' => ':attributeのファイルサイズは:value KBより小さくなければなりません。',
        'numeric' => ':attributeは:valueより小さくなければなりません。',
        'string' => ':attributeは:value文字より短くなければなりません。',
    ],
    'lte' => [
        'array' => ':attributeの項目数は:value個以下でなければなりません。',
        'file' => ':attributeのファイルサイズは:value KB以下でなければなりません。',
        'numeric' => ':attributeは:value以下でなければなりません。',
        'string' => ':attributeは:value文字以下でなければなりません。',
    ],
    'mac_address' => ':attributeには有効なMACアドレスを指定してください。',
    'max' => [
        'array' => ':attributeの項目数は:max個以下でなければなりません。',
        'file' => ':attributeのファイルサイズは:max KB以下でなければなりません。',
        'numeric' => ':attributeは:max以下でなければなりません。',
        'string' => ':attributeは:max文字以下でなければなりません。',
    ],
    'max_digits' => ':attributeは:max桁以下でなければなりません。',
    'mimes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'min' => [
        'array' => ':attributeの項目数は:min個以上でなければなりません。',
        'file' => ':attributeのファイルサイズは:min KB以上でなければなりません。',
        'numeric' => ':attributeは:min以上でなければなりません。',
        'string' => ':attributeは:min文字以上でなければなりません。',
    ],
    'min_digits' => ':attributeは:min桁以上でなければなりません。',
    'missing' => ':attributeは存在してはいけません。',
    'missing_if' => ':otherが:valueの場合、:attributeは存在してはいけません。',
    'missing_unless' => ':otherが:valueでない場合、:attributeは存在してはいけません。',
    'missing_with' => ':valuesが存在する場合、:attributeは存在してはいけません。',
    'missing_with_all' => ':valuesが存在する場合、:attributeは存在してはいけません。',
    'multiple_of' => ':attributeは:valueの倍数でなければなりません。',
    'not_in' => '選択された:attributeは無効です。',
    'not_regex' => ':attributeの形式が無効です。',
    'numeric' => ':attributeには数値を指定してください。',
    'password' => [
        'letters' => ':attributeは少なくとも1つの文字を含まなければなりません。',
        'mixed' => ':attributeは少なくとも大文字と小文字を1つずつ含まなければなりません。',
        'numbers' => ':attributeは少なくとも1つの数字を含まなければなりません。',
        'symbols' => ':attributeは少なくとも1つの記号を含まなければなりません。',
        'uncompromised' => '指定された:attributeは漏洩している可能性があります。別の:attributeを選択してください。',
    ],
    'present' => ':attributeが存在している必要があります。',
    'prohibited' => ':attributeは禁止されています。',
    'prohibited_if' => ':otherが:valueの場合、:attributeは禁止されています。',
    'prohibited_unless' => ':otherが:valuesでない場合、:attributeは禁止されています。',
    'prohibits' => ':attributeは:otherの入力を禁止しています。',
    'regex' => ':attributeの形式が無効です。',
    'required' => ':attributeは必須です。',
    'required_array_keys' => ':attributeには:valuesのエントリーが含まれている必要があります。',
    'required_if' => ':otherが:valueの場合、:attributeは必須です。',
    'required_if_accepted' => ':otherが承認された場合、:attributeは必須です。',
    'required_unless' => ':otherが:valuesでない場合、:attributeは必須です。',
    'required_with' => ':valuesが存在する場合、:attributeは必須です。',
    'required_with_all' => ':valuesが存在する場合、:attributeは必須です。',
    'required_without' => ':valuesが存在しない場合、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない場合、:attributeは必須です。',
    'same' => ':attributeと:otherが一致しません。',
    'size' => [
        'array' => ':attributeの項目数は:size個でなければなりません。',
        'file' => ':attributeのファイルサイズは:size KBでなければなりません。',
        'numeric' => ':attributeは:sizeでなければなりません。',
        'string' => ':attributeは:size文字でなければなりません。',
    ],
    'starts_with' => ':attributeは次のいずれかで始まる必要があります。: :values',
    'string' => ':attributeには文字列を指定してください。',
    'timezone' => ':attributeには有効なタイムゾーンを指定してください。',
    'unique' => ':attributeの値は既に存在しています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeは大文字のみ使用できます。',
    'url' => ':attributeには有効なURLを指定してください。',
    'ulid' => ':attributeは有効なULIDでなければなりません。',
    'uuid' => ':attributeは有効なUUIDでなければなりません。',

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

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
        'name' => 'お名前',
    ],
];

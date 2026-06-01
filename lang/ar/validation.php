<?php

return [
    'required'  => 'حقل :attribute مطلوب.',
    'string'    => 'يجب أن يكون :attribute نصاً.',
    'max'       => ['string' => 'يجب ألا يتجاوز :attribute :max حرفاً.'],
    'min'       => ['numeric' => 'يجب أن لا يقل :attribute عن :min.'],
    'email'     => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'unique'    => ':attribute مستخدم بالفعل.',
    'numeric'   => 'يجب أن يكون :attribute رقماً.',
    'integer'   => 'يجب أن يكون :attribute عدداً صحيحاً.',
    'image'     => 'يجب أن يكون :attribute صورة.',
    'mimes'     => 'يجب أن يكون :attribute ملفاً من نوع: :values.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'boolean'   => 'يجب أن يكون :attribute صحيحاً أو خاطئاً.',
    'in'        => 'القيمة المختارة في :attribute غير صالحة.',
    'attributes'=> [
        'name'             => 'الاسم',
        'email'            => 'البريد الإلكتروني',
        'password'         => 'كلمة المرور',
        'price'            => 'السعر',
        'stock'            => 'المخزون',
        'customer_name'    => 'اسم العميل',
        'customer_phone'   => 'رقم الهاتف',
        'customer_address' => 'عنوان التوصيل',
    ],
];

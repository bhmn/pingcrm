<?php

use App\Rules\IsValidEmailAddressRule;
use Illuminate\Support\Facades\Validator;


//اگه همه متدهای این فایل گروه لارال کست بودن میتونی اینه برا همه اضافه کنی و تک تک گروپ اضافه نکنی
uses()->group('laracasts');

it('can validate an email', function () {
    $validator = Validator::make(
        ['email' => "me@you.com"],
        ['email' => new IsValidEmailAddressRule()]
    );

    //dd($validator);
    expect($validator->passes())->toBeTrue();
});
//->group('laracasts');

it('throws an exception if the value is not a string', function () {
    $validator = Validator::make(
        ['email' => "me@you.com"],
        ['email' => new IsValidEmailAddressRule()]
    );

    //dd($validator);
    expect($validator->passes())->toBeTrue();
})
    ->skip(fn() => config('app.name') === "foo", "skip this for now")
    //->throws(InvalidArgumentException::class, "value must be string")
    ->group('current');


//it('has better regex support and can catch more email addresses');

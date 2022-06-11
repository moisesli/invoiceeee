<?php

namespace App\Actions\Fortify;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
/*      $empresa = new Empresa();
        $empresa->ruc = $input['ruc'];
        $empresa->razon_social = $input['razon_social'];
        $empresa->save();
        $empresaId = $empresa->id();*/

        $empresa = Empresa::create([
            'ruc' => $input['ruc'],
            'razon_social' => $input['razon_social']
        ]);
        //$empresa_id = $empresa->id;

        //dd($input);
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'empresa_id' => $empresa->id
        ]);
    }
}

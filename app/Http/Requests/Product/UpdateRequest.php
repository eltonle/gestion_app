<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
              'name'=>'required|string|max:50',
               'category_id'=>'integer|exists:App\Models\Category,id',
               'unit_id'=>'integer|exists:App\Models\Unit,id',
        ];

    }

     public function messages()
       {
         return [
            'name.required'=> 'champ nom obligatoire',
            'name.string'=> 'la valeur inscrite incorrecte',
            'name.max'=> 'la valeur ne peut avoir que 50 caracteres',

            'image.image'=>'image incorrect',
            'image.required'=>'image requis',

            'price.required'=>'le pris est requis',


            'category_id.integer'=>'category non existante',
            'category_id.exists'=>'category non existante'
          ];
       }
}

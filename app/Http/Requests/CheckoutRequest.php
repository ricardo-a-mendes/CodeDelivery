<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;
use Session;

class CheckoutRequest extends Request
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
     * @return array
     */
    public function rules(\Illuminate\Http\Request $request)
    {
        $rules = [
            'cupom_code' => 'exists:cupoms,code,used,0'
        ];
        $orderItems = $request->get('orderItems', ['orderItem' => []]);

        foreach ($orderItems as $key => $orderItem)
        {
            $this->buildOrderItemsRule($key, $rules);
        }

        Session::flash('order_id', $request->input('order_id'));

        return $rules;
    }

    public function buildOrderItemsRule($key, array &$rules)
    {
        $rules["orderItems.{$key}.product_id"] = 'required|exists:products,id';
        $rules["orderItems.{$key}.quantity"] = 'required|integer';
    }
}

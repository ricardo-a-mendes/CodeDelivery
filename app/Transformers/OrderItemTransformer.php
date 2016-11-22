<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\OrderItem;

/**
 * Class OrderItemTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderItemTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['product'];
    /**
     * Transform the \OrderItem entity
     * @param \OrderItem $model
     *
     * @return array
     */
    public function transform(OrderItem $model)
    {
        return [
            'price' => $model->price,
            'qtd' => $model->quantity
        ];
    }

    public function includeProduct(OrderItem $orderItem)
    {
        if ($orderItem->product)
            return $this->item($orderItem->product, new ProductTransformer());

        return null;
    }
}

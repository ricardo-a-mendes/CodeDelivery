<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['client', 'orderItems', 'cupom'];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id' => (int)$model->id,
            'total' => $model->total,
            'status' => $model->status,
            'created_at' => $model->created_at,
        ];
    }

    public function includeCupom(Order $order)
    {
        if ($order->cupom) {
            return $this->item($order->cupom, new CupomTransformer());
        }

        return null;
    }

    public function includeOrderItems(Order $order)
    {
        if ($order->orderItems) {
            return $this->collection($order->orderItems, new OrderItemTransformer());
        }

        return null;
    }

    public function includeClient(Order $order)
    {
        if ($order->client) {
            return $this->item($order->client, new ClientTransformer());
        }

        return null;
    }
}

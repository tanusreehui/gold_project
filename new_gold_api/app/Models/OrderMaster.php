<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    /**
     * @var mixed
     */
    private $id;
    /**
     * @var mixed|string
     */
    private $order_number;
    /**
     * @var mixed
     */
    private $agent_id;
    /**
     * @var mixed
     */
    private $person_id;
    /**
     * @var mixed
     */
    private $employee_id;
    /**
     * @var mixed
     */
    private $date_of_order;
    /**
     * @var mixed
     */
    private $date_of_delivery;
    /**
     * @var mixed
     */
    private $discount_percentage;
}

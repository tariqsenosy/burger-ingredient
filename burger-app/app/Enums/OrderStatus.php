<?php
// app/Enums/OrderStatus.php

namespace App\Enums;

// I created it for more redability of the code 
class OrderStatus
{
    const NEW = 1;
    const CONFIRMED = 2;
    const RECEIVED = 3;
    const CANCELED = 4;
    const REFUNDED = 5;
}

<?php

namespace App\Models\Quote;

enum BillingFrequency: string
{
    case Monthly = 'M';
    case Yearly = 'Y';
}

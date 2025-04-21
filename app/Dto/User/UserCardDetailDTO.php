<?php

namespace App\Dto\User;

class UserCardDetailDTO
{
    function __construct(
        public $card_number,
        public $exp,
        public $cvv,
        public $name_on_the_card,
        public $billing_address
    )
    {
    }
}

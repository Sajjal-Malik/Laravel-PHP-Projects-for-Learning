<?php

namespace App\Enums;

enum AgeStatus: string
{
    case KID_FEMALE = 'KID_FEMALE';
    case YOUNG_FEMALE = 'YOUNG_FEMALE';
    case ELDER_FEMALE = 'ELDER_FEMALE';
    case FEMALE = 'FEMALE';

    case KID_MALE = 'KID_MALE';
    case YOUNG_MALE = 'YOUNG_MALE';
    case ELDER_MALE = 'ELDER_MALE';
    case MALE = 'MALE';
}

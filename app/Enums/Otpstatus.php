<?php

namespace App\Enums;

enum Otpstatus: int
{
  case PENDING =   1 ;
  case VERIFIED =  2 ;
  case EXPIRED =  3 ;
  case FAILED =   4 ;
}

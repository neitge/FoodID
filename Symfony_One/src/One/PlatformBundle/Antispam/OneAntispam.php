<?php


namespace One\PlatformBundle\Antispam;

class OneAntispam
{
    
    
     public function isSpam($text)
  {
    return strlen($text) < 50;
  }
}
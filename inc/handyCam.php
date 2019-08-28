<?php

namespace handyCam;


class handyCam
{

    public function  getAppDate($datestr)
    {
        $date = explode('-', $datestr);
        return $date[2].'/'.$date[1].'/'.$date[0];
    }
    public function  parseAppDate($datestr)
    {
        $date = explode('/', $datestr);
        return $date[2].'-'.$date[1].'-'.$date[0];
    }


}
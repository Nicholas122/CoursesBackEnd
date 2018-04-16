<?php

namespace AppBundle\Twig;


class Resize extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('resize', array($this, 'resize')),
        );
    }

    public function resize($photo, $width, $height)
    {
        preg_match('/.+\.(\w+)$/xis', $photo, $pocket);

        if (!empty($pocket) && array_key_exists(1, $pocket)) {

            $extension = '.'.$pocket[1];

            $photo = str_replace($extension, '-'.$width.'x'.$height.$extension, $photo);
        }

        return $photo;
    }
}
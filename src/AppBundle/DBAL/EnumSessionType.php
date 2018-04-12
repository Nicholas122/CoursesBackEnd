<?php

namespace AppBundle\DBAL;

class EnumSessionType extends EnumType
{
    protected $name = 'enum_session_type';

    protected $values = array('withoutEnrollment', 'withEnrollment');
}

<?php

namespace AppBundle\DBAL;

class EnumInstructionalLevelType extends EnumType
{
    protected $name = 'enum_instructional_level_type';

    protected $values = array('all', 'introductory', 'intermediate', 'advanced');
}

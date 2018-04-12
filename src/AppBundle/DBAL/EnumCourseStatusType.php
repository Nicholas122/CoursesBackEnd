<?php

namespace AppBundle\DBAL;

class EnumCourseStatusType extends EnumType
{
    protected $name = 'enum_course_status_type';

    protected $values = array('draft', 'publish');
}

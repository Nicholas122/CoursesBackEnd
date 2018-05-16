<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class MultipleChoiceQuestionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.post_serialize', 'class' => 'AppBundle\Entity\MultipleChoiceQuestion', 'method' => 'onPostSerialize'),
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        /**
         * @var MultipleChoiceQuestion $obj
         */
        $obj = $event->getObject();

        /**
         * @var JsonSerializationVisitor
         */
        $visitor = $event->getVisitor();

        $visitor->setData('type', $obj->getQuestionType());
    }
}

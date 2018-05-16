<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
use AppBundle\Entity\ReadingQuestion;
use AppBundle\Entity\UserInputQuestion;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class UserInputQuestionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.post_serialize', 'class' => 'AppBundle\Entity\UserInputQuestion', 'method' => 'onPostSerialize'),
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        /**
         * @var UserInputQuestion $obj
         */
        $obj = $event->getObject();

        /**
         * @var JsonSerializationVisitor
         */
        $visitor = $event->getVisitor();

        $visitor->setData('type', $obj->getQuestionType());
    }
}

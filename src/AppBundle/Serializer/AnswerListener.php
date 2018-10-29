<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\Answer;
use AppBundle\Entity\MultipleChoiceQuestion;
use AppBundle\Entity\Question;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class AnswerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.post_serialize', 'class' => 'AppBundle\Entity\Answer', 'method' => 'onPostSerialize'),
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        /**
         * @var Answer $obj
         */
        $obj = $event->getObject();

        /**
         * @var JsonSerializationVisitor
         */
        $visitor = $event->getVisitor();

        $visitor->setData('correct', boolval($obj->getIsCorrect()));
        $visitor->setData('questionId', $obj->getQuestion()->getId());
        $visitor->setData('uid', $obj->getId());

    }
}

<?php

namespace gospelcenter\UserBundle\Security\Authorization\Voter;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AccessLevelVoter implements VoterInterface
{
    public function supportsAttribute($attribute)
    {
        return true;
    }

    public function supportsClass($class)
    {
        return true;
    }

    function vote(TokenInterface $token, $post, array $attributes)
    {

        $user = $token->getUser();

        if (in_array("ADMIN", $user->getRoles()) || in_array("ROLE_ADMIN", $user->getRoles())) {
            return VoterInterface::ACCESS_GRANTED;
        }

        $service = "";

        switch (get_class($post)) {

            case 'gospelcenter\AccessBundle\Entity\Access':
                $service = "Access";
                break;

            case 'gospelcenter\AccessBundle\Entity\Unit':
                $service = "Unit";
                break;

            case 'gospelcenter\AccessBundle\Entity\AccessLevel':
                $service = "AccessLevel";
                break;

            case 'gospelcenter\ArticleBundle\Entity\Ad':
                $service = "Ad";
                break;

            case 'gospelcenter\ArticleBundle\Entity\Article':
                $service = "Article";
                break;

            case 'gospelcenter\ArticleBundle\Entity\Link':
                $service = "Link";
                break;

            case 'gospelcenter\CelebrationBundle\Entity\Celebration':
                $service = "Celebration";
                break;

            case 'gospelcenter\CelebrationBundle\Entity\Speaker':
                $service = "Speaker";
                break;

            case 'gospelcenter\CelebrationBundle\Entity\Tag':
                $service = "Tag";
                break;

            case 'gospelcenter\CenterBundle\Entity\Band':
                $service = "Band";
                break;

            case 'gospelcenter\CenterBundle\Entity\Base':
                $service = "Base";
                break;

            case 'gospelcenter\CenterBundle\Entity\Center':
                $service = "Center";
                break;

            case 'gospelcenter\CenterBundle\Entity\Member':
                $service = "Member";
                break;

            case 'gospelcenter\CenterBundle\Entity\Visitor':
                $service = "Visitor";
                break;

            case 'gospelcenter\DateBundle\Entity\Date':
                $service = "Date";
                break;

            case 'gospelcenter\EventBundle\Entity\Event':
                $service = "Event";
                break;

            case 'gospelcenter\ImageBundle\Entity\Image':
                $service = "Image";
                break;

            case 'gospelcenter\LanguageBundle\Entity\Language':
                $service = "Language";
                break;

            case 'gospelcenter\LocationBundle\Entity\Location':
                $service = "Location";
                break;

            case 'gospelcenter\MediaBundle\Entity\Video':
                $service = "Video";
                break;

            case 'gospelcenter\MediaBundle\Entity\Audio':
                $service = "Audio";
                break;

            case 'gospelcenter\PageBundle\Entity\Page':
                $service = "Page";
                break;

            case 'gospelcenter\PageBundle\Entity\Slide':
                $service = "Slide";
                break;

            case 'gospelcenter\PeopleBundle\Entity\Person':
                $service = "Person";
                break;

            case 'gospelcenter\PeopleBundle\Entity\Role':
                $service = "Role";
                break;

            case 'gospelcenter\UserBundle\Entity\User':
                $service = "User";
                break;

        }

        if ($service === "") {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (in_array("ADMIN", $user->getRoles()) || in_array("ROLE_ADMIN", $user->getRoles())) {
            return VoterInterface::ACCESS_GRANTED;
        }

        if (!$user->getPerson()) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed for VIEW or EDIT'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];


        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        foreach ($user->getUnits() as $unit) {
            foreach ($unit->getAccessLevels() as $accessLevel) {

                if (($accessLevel->getLevel() == $attribute || $accessLevel->getLevel() == "MASTER") && $accessLevel->getAccess()->getService() == $service) {
                    return VoterInterface::ACCESS_GRANTED;
                }

            }

        }

        return VoterInterface::ACCESS_DENIED;
    }
}
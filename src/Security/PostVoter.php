<?php
namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class PostVoter extends Voter
{

    const CREATE = 'create';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CREATE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Post) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
// the user must be logged in; if not, deny access
            return false;
        }

// you know $subject is a Post object, thanks to `supports()`
        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($post, $user);

        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canCreate(){

        if ($this->security->isGranted('ROLE_AUTHOR')) {
            return true;
        }
        return false;
    }

}

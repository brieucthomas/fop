<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * The menu builder.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Constructor.
     *
     * @param FactoryInterface $factory
     * @param RequestStack     $requestStack
     */
    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $params = ['year' => date('Y')];

        $menu->addChild('navigation.main.home', ['route' => 'homepage']);
        $menu->addChild('navigation.races', ['route' => 'season_races', 'routeParameters' => $params]);
        $menu->addChild('navigation.teams', ['route' => 'season_teams', 'routeParameters' => $params]);
        $menu->addChild('navigation.standings', ['route' => 'season_standings', 'routeParameters' => $params]);

        return $menu;
    }

    public function createUserMenu(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $storage)
    {
        $menu = $this->factory->createItem('root');

        if ($authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            /* @var $user User */
            $user = $storage->getToken()->getUser();
            $parent = $menu->addChild($user->getUsername());
            $parent->addChild(
                'navigation.user.profile',
                ['route' => 'user', 'routeParameters' => ['slug' => $user->getSlug()]]
            );
            $parent->addChild('navigation.user.logout', ['route' => 'fos_user_security_logout']);
        } else {
            $menu->addChild('navigation.user.login', ['route' => 'fos_user_security_login', 'class']);
            $menu->addChild('navigation.user.register', ['route' => 'fos_user_registration_register']);
        }

        return $menu;
    }

    public function createLocaleSwitcherMenu($languages)
    {
        $request = $this->requestStack->getCurrentRequest();
        $menu = $this->factory->createItem('root');

        $parent = $menu->addChild('navigation.locale_switcher.list');

        foreach ($languages as $local) {
            $child = $parent->addChild(
                $local,
                [
                    'route'           => $request->get('_route'),
                    'routeParameters' => array_merge($request->get('_route_params'), ['_locale' => $local]),
                    /**
                     * @Ignore
                     */
                    'label'           => $local,
                ]
            );
            $child->setLinkAttribute('title', 'navigation.locale_switcher.'.$local);
        }

        return $menu;
    }

    public function createFooterMenu($contactEmail)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('navigation.footer.contact', ['uri' => 'mailto:'.$contactEmail]);

        return $menu;
    }
}

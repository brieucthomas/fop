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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class MenuBuilder
{
    private $menuFactory;
    private $requestStack;
    private $currentYear;

    public function __construct(FactoryInterface $menuFactory, RequestStack $requestStack, int $currentYear)
    {
        $this->menuFactory = $menuFactory;
        $this->requestStack = $requestStack;
        $this->currentYear = $currentYear;
    }

    public function createMainMenu()
    {
        $menu = $this->menuFactory->createItem('root');

        $params = ['year' => $this->currentYear];

        $menu->addChild('navigation.main.home', ['route' => 'homepage']);
        $menu->addChild('navigation.main.calendar', ['route' => 'season_races', 'routeParameters' => $params]);
        $menu->addChild('navigation.main.teams', ['route' => 'season_teams', 'routeParameters' => $params]);

        $standings = $menu->addChild('navigation.main.standings');
        $standings->addChild('navigation.main.user_standings', ['route' => 'season_user_standings', 'routeParameters' => $params]);
        $standings->addChild('navigation.main.driver_standings', ['route' => 'season_driver_standings', 'routeParameters' => $params]);
        $standings->addChild('navigation.main.constructor_standings', ['route' => 'season_constructor_standings', 'routeParameters' => $params]);

        return $menu;
    }

    public function createUserMenu(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $storage)
    {
        $menu = $this->menuFactory->createItem('root');

        if ($authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            /* @var $user User */
            $user = $storage->getToken()->getUser();
            $parent = $menu->addChild($user->getUsername());
            $parent->addChild('navigation.user.my_account', ['route' => 'user', 'routeParameters' => ['slug' => $user->getSlug()]]);
            $parent->addChild('navigation.user.logout', ['route' => 'fos_user_security_logout']);
        } else {
            $menu->addChild('navigation.sign.in', ['route' => 'fos_user_security_login', 'class']);
            $menu->addChild('navigation.sign.up', ['route' => 'fos_user_registration_register']);
        }

        return $menu;
    }

    public function createLocaleSwitcherMenu($languages)
    {
        $request = $this->requestStack->getCurrentRequest();
        $menu = $this->menuFactory->createItem('root');

        $parent = $menu->addChild('navigation.locale_switcher.list');

        foreach ($languages as $local) {
            $child = $parent->addChild(
                $local,
                [
                    'route' => $request->get('_route'),
                    'routeParameters' => array_merge($request->get('_route_params'), ['_locale' => $local]),
                    /*
                     * @Ignore
                     */
                    'label' => $local,
                ]
            );
            $child->setLinkAttribute('title', 'navigation.locale_switcher.'.$local);
        }

        return $menu;
    }

    public function createFooterMenu($contactEmail)
    {
        $menu = $this->menuFactory->createItem('root');

        $menu->addChild('navigation.footer.contact', ['uri' => 'mailto:'.$contactEmail]);

        return $menu;
    }
}

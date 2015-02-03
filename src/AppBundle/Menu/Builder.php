<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Menu;

use AppBundle\Service\RaceServiceInterface;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @param RequestStack $requestStack
     */
    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('navigation.main.home', ['route' => 'homepage']);

        $menu->addChild('navigation.main.last-race', [ 'route' => 'last_race' ]);
        $menu->addChild('navigation.main.next-race', [ 'route' => 'next_race' ]);

        $menu->addChild(
            'navigation.season.last',
            [
                'route'           => 'season_home',
                'routeParameters' => ['year' => date('Y') - 1],
                'extras'          => ['translation_params' => [date('Y') - 1]]
            ]
        );
        $menu->addChild(
            'navigation.season.current',
            [
                'route'           => 'season_home',
                'routeParameters' => ['year' => date('Y')],
                'extras'          => ['translation_params' => [date('Y')]]
            ]
        );

        return $menu;
    }

    public function createUserMenu(AuthorizationCheckerInterface $authorizationChecker)
    {
        $menu = $this->factory->createItem('root');

        if ($authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('navigation.user.logout', ['route' => 'fos_user_security_logout']);
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
                    /** @Ignore */
                    'label'           => $local
                ]
            );
            $child->setLinkAttribute('title', 'navigation.locale_switcher.' . $local);
        }

        return $menu;
    }

    public function createSeasonMenu()
    {
        $request = $this->requestStack->getCurrentRequest();
        $params = ['year' => $request->get('year')];

        $menu = $this->factory->createItem('root');

        $menu->addChild('navigation.season.home', ['route' => 'season_home', 'routeParameters' => $params]);
        $menu->addChild('navigation.season.races', ['route' => 'season_races', 'routeParameters' => $params]);
        $menu->addChild('navigation.season.teams', ['route' => 'season_teams', 'routeParameters' => $params]);
        $menu->addChild('navigation.season.standings', ['route' => 'season_standings', 'routeParameters' => $params]);
        $menu->addChild('navigation.season.graphs', ['route' => 'season_graphs', 'routeParameters' => $params]);

        return $menu;
    }

    public function createFooterMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('navigation.footer.about_us', ['route' => 'homepage']);
        $menu->addChild('navigation.footer.faq', ['route' => 'homepage']);
        $menu->addChild('navigation.footer.privacy', ['route' => 'homepage']);
        $menu->addChild('navigation.footer.contact', ['route' => 'homepage']);

        return $menu;
    }
}

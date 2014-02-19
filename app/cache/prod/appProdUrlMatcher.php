<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        $host = $this->context->getHost();

        if (preg_match('#^gospelcenter\\.local$#s', $host, $hostMatches)) {
            if (0 === strpos($pathinfo, '/admin')) {
                // gospelcenterAdminGlobal_home
                if (rtrim($pathinfo, '/') === '/admin') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'gospelcenterAdminGlobal_home');
                    }

                    return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageGlobalController::listAction',  '_route' => 'gospelcenterAdminGlobal_home',);
                }

                if (0 === strpos($pathinfo, '/admin/pages')) {
                    // gospelcenterAdminGlobal_pages
                    if ($pathinfo === '/admin/pages') {
                        return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageGlobalController::listAction',  '_route' => 'gospelcenterAdminGlobal_pages',);
                    }

                    // gospelcenterAdminGlobal_pages_add
                    if ($pathinfo === '/admin/pages/add') {
                        return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageGlobalController::addAction',  '_route' => 'gospelcenterAdminGlobal_pages_add',);
                    }

                    // gospelcenterAdminGlobal_pages_edit
                    if (0 === strpos($pathinfo, '/admin/pages/edit') && preg_match('#^/admin/pages/edit/(?P<page>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterAdminGlobal_pages_edit')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageGlobalController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/slides')) {
                    // gospelcenterAdminGlobal_slides
                    if ($pathinfo === '/admin/slides') {
                        return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideGlobalController::listAction',  '_route' => 'gospelcenterAdminGlobal_slides',);
                    }

                    // gospelcenterAdminGlobal_slides_add
                    if ($pathinfo === '/admin/slides/add') {
                        return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideGlobalController::addAction',  '_route' => 'gospelcenterAdminGlobal_slides_add',);
                    }

                    // gospelcenterAdminGlobal_slides_edit
                    if (0 === strpos($pathinfo, '/admin/slides/edit') && preg_match('#^/admin/slides/edit/(?P<slide>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterAdminGlobal_slides_edit')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideGlobalController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/images')) {
                    // gospelcenterAdminGlobal_images
                    if ($pathinfo === '/admin/images') {
                        return array (  '_controller' => 'gospelcenterImageBundle:AdminGlobal:list',  '_route' => 'gospelcenterAdminGlobal_images',);
                    }

                    if (0 === strpos($pathinfo, '/admin/images/a')) {
                        // gospelcenterAdminGlobal_images_all
                        if ($pathinfo === '/admin/images/all') {
                            return array (  '_controller' => 'gospelcenterImageBundle:AdminGlobal:all',  '_route' => 'gospelcenterAdminGlobal_images_all',);
                        }

                        // gospelcenterAdminGlobal_images_add
                        if ($pathinfo === '/admin/images/add') {
                            return array (  '_controller' => 'gospelcenterImageBundle:AdminGlobal:add',  '_route' => 'gospelcenterAdminGlobal_images_add',);
                        }

                    }

                    // gospelcenterAdminGlobal_images_edit
                    if (0 === strpos($pathinfo, '/admin/images/edit') && preg_match('#^/admin/images/edit/(?P<image>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterAdminGlobal_images_edit')), array (  '_controller' => 'gospelcenterImageBundle:AdminGlobal:edit',));
                    }

                    // gospelcenterAdminGlobal_images_delete
                    if (0 === strpos($pathinfo, '/admin/images/delete') && preg_match('#^/admin/images/delete/(?P<image>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterAdminGlobal_images_delete')), array (  '_controller' => 'gospelcenterImageBundle:AdminGlobal:delete',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/centers')) {
                    // gospelcenterAdminGlobal_centers
                    if ($pathinfo === '/admin/centers') {
                        return array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminCenterController::listAction',  '_route' => 'gospelcenterAdminGlobal_centers',);
                    }

                    // gospelcenterAdminGlobal_centers_add
                    if ($pathinfo === '/admin/centers/add') {
                        return array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminCenterController::addAction',  '_route' => 'gospelcenterAdminGlobal_centers_add',);
                    }

                    // gospelcenterAdminGlobal_centers_edit
                    if (0 === strpos($pathinfo, '/admin/centers/edit') && preg_match('#^/admin/centers/edit/(?P<center>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterAdminGlobal_centers_edit')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminCenterController::editAction',));
                    }

                }

            }

        }

        if (preg_match('#^(?P<center>lausanne|annecy|montreux|jura)\\.gospelcenter\\.local$#s', $host, $hostMatches)) {
            if (0 === strpos($pathinfo, '/admin')) {
                if (0 === strpos($pathinfo, '/admin/celebrations')) {
                    // gospelcenterAdmin_celebrations
                    if ($pathinfo === '/admin/celebrations') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_celebrations')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminCelebrationController::listAction',));
                    }

                    // gospelcenterAdmin_celebrations_add
                    if ($pathinfo === '/admin/celebrations/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_celebrations_add')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminCelebrationController::addAction',));
                    }

                    // gospelcenterAdmin_celebrations_edit
                    if (0 === strpos($pathinfo, '/admin/celebrations/edit') && preg_match('#^/admin/celebrations/edit/(?P<celebration>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_celebrations_edit')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminCelebrationController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/speakers')) {
                    // gospelcenterAdmin_speakers
                    if ($pathinfo === '/admin/speakers') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_speakers')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::listAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/speakers/a')) {
                        // gospelcenterAdmin_speakers_all
                        if ($pathinfo === '/admin/speakers/all') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_speakers_all')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::allAction',));
                        }

                        // gospelcenterAdmin_speakers_add
                        if ($pathinfo === '/admin/speakers/add') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_speakers_add')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::addAction',));
                        }

                    }

                    // gospelcenterAdmin_speakers_edit
                    if (0 === strpos($pathinfo, '/admin/speakers/edit') && preg_match('#^/admin/speakers/edit/(?P<speaker>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_speakers_edit')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::editAction',));
                    }

                }

                // gospelcenterAdmin_speakers_json
                if ($pathinfo === '/admin/celebrations/speakers.json') {
                    return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_speakers_json')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::jsonAction',));
                }

                // gospelcenterAdmin_speakers_singleJSON
                if (0 === strpos($pathinfo, '/admin/speakers/json') && preg_match('#^/admin/speakers/json/(?P<speaker>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_speakers_singleJSON')), array (  '_controller' => 'gospelcenter\\CelebrationBundle\\Controller\\AdminSpeakerController::singleJSONAction',));
                }

                if (0 === strpos($pathinfo, '/admin/persons')) {
                    // gospelcenterAdmin_persons
                    if ($pathinfo === '/admin/persons') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_persons')), array (  '_controller' => 'gospelcenter\\PeopleBundle\\Controller\\AdminPersonController::listAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/persons/a')) {
                        // gospelcenterAdmin_persons_all
                        if ($pathinfo === '/admin/persons/all') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_persons_all')), array (  '_controller' => 'gospelcenter\\PeopleBundle\\Controller\\AdminPersonController::allAction',));
                        }

                        // gospelcenterAdmin_persons_add
                        if ($pathinfo === '/admin/persons/add') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_persons_add')), array (  '_controller' => 'gospelcenter\\PeopleBundle\\Controller\\AdminPersonController::addAction',));
                        }

                    }

                    // gospelcenterAdmin_persons_edit
                    if (0 === strpos($pathinfo, '/admin/persons/edit') && preg_match('#^/admin/persons/edit/(?P<person>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_persons_edit')), array (  '_controller' => 'gospelcenter\\PeopleBundle\\Controller\\AdminPersonController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/members')) {
                    // gospelcenterAdmin_members
                    if ($pathinfo === '/admin/members') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_members')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminMemberController::listAction',));
                    }

                    // gospelcenterAdmin_members_add
                    if ($pathinfo === '/admin/members/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_members_add')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminMemberController::addAction',));
                    }

                    // gospelcenterAdmin_members_edit
                    if (0 === strpos($pathinfo, '/admin/members/edit') && preg_match('#^/admin/members/edit/(?P<member>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_members_edit')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminMemberController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/visitors')) {
                    // gospelcenterAdmin_visitors
                    if ($pathinfo === '/admin/visitors') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_visitors')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminVisitorController::listAction',));
                    }

                    // gospelcenterAdmin_visitors_add
                    if ($pathinfo === '/admin/visitors/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_visitors_add')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminVisitorController::addAction',));
                    }

                    // gospelcenterAdmin_visitors_edit
                    if (0 === strpos($pathinfo, '/admin/visitors/edit') && preg_match('#^/admin/visitors/edit/(?P<visitor>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_visitors_edit')), array (  '_controller' => 'gospelcenter\\CenterBundle\\Controller\\AdminVisitorController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/events')) {
                    // gospelcenterAdmin_events
                    if ($pathinfo === '/admin/events') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_events')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\AdminController::listAction',));
                    }

                    // gospelcenterAdmin_events_add
                    if ($pathinfo === '/admin/events/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_events_add')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\AdminController::addAction',));
                    }

                    // gospelcenterAdmin_events_edit
                    if (0 === strpos($pathinfo, '/admin/events/edit') && preg_match('#^/admin/events/edit/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_events_edit')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\AdminController::editAction',));
                    }

                    // gospelcenterAdmin_events_publish
                    if (0 === strpos($pathinfo, '/admin/events/publish') && preg_match('#^/admin/events/publish/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_events_publish')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\AdminController::publishAction',));
                    }

                    // gospelcenterAdmin_events_delete
                    if (0 === strpos($pathinfo, '/admin/events/delete') && preg_match('#^/admin/events/delete/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_events_delete')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\AdminController::deleteAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/pages')) {
                    // gospelcenterAdmin_pages
                    if ($pathinfo === '/admin/pages') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_pages')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageController::listAction',));
                    }

                    // gospelcenterAdmin_pages_add
                    if ($pathinfo === '/admin/pages/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_pages_add')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageController::addAction',));
                    }

                    // gospelcenterAdmin_pages_edit
                    if (0 === strpos($pathinfo, '/admin/pages/edit') && preg_match('#^/admin/pages/edit/(?P<page>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_pages_edit')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminPageController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/slides')) {
                    // gospelcenterAdmin_slides
                    if ($pathinfo === '/admin/slides') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_slides')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideController::listAction',));
                    }

                    // gospelcenterAdmin_slides_add
                    if ($pathinfo === '/admin/slides/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_slides_add')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideController::addAction',));
                    }

                    // gospelcenterAdmin_slides_edit
                    if (0 === strpos($pathinfo, '/admin/slides/edit') && preg_match('#^/admin/slides/edit/(?P<slide>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_slides_edit')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\AdminSlideController::editAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/images')) {
                    // gospelcenterAdmin_images
                    if ($pathinfo === '/admin/images') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_images')), array (  '_controller' => 'gospelcenter\\ImageBundle\\Controller\\AdminController::listAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/images/a')) {
                        // gospelcenterAdmin_images_all
                        if ($pathinfo === '/admin/images/all') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_images_all')), array (  '_controller' => 'gospelcenter\\ImageBundle\\Controller\\AdminController::allAction',));
                        }

                        // gospelcenterAdmin_images_add
                        if ($pathinfo === '/admin/images/add') {
                            return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_images_add')), array (  '_controller' => 'gospelcenter\\ImageBundle\\Controller\\AdminController::addAction',));
                        }

                    }

                    // gospelcenterAdmin_images_edit
                    if (0 === strpos($pathinfo, '/admin/images/edit') && preg_match('#^/admin/images/edit/(?P<image>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_images_edit')), array (  '_controller' => 'gospelcenter\\ImageBundle\\Controller\\AdminController::editAction',));
                    }

                    // gospelcenterAdmin_images_delete
                    if (0 === strpos($pathinfo, '/admin/images/delete') && preg_match('#^/admin/images/delete/(?P<image>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_images_delete')), array (  '_controller' => 'gospelcenter\\ImageBundle\\Controller\\AdminController::deleteAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/locations')) {
                    // gospelcenterAdmin_locations
                    if ($pathinfo === '/admin/locations') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_locations')), array (  '_controller' => 'gospelcenter\\LocationBundle\\Controller\\AdminController::listAction',));
                    }

                    // gospelcenterAdmin_locations_add
                    if ($pathinfo === '/admin/locations/add') {
                        return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterAdmin_locations_add')), array (  '_controller' => 'gospelcenter\\LocationBundle\\Controller\\AdminController::addAction',));
                    }

                    // gospelcenterAdmin_locations_edit
                    if (0 === strpos($pathinfo, '/admin/locations/edit') && preg_match('#^/admin/locations/edit/(?P<location>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_locations_edit')), array (  '_controller' => 'gospelcenter\\LocationBundle\\Controller\\AdminController::editAction',));
                    }

                    // gospelcenterAdmin_locations_delete
                    if (0 === strpos($pathinfo, '/admin/locations/delete') && preg_match('#^/admin/locations/delete/(?P<location>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_locations_delete')), array (  '_controller' => 'gospelcenter\\LocationBundle\\Controller\\AdminController::deleteAction',));
                    }

                    // gospelcenterAdmin_locations_singleJSON
                    if (0 === strpos($pathinfo, '/admin/locations/json') && preg_match('#^/admin/locations/json/(?P<location>\\d+)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterAdmin_locations_singleJSON')), array (  '_controller' => 'gospelcenter\\LocationBundle\\Controller\\AdminController::singleJSONAction',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/events')) {
                // gospelcenterEvents_list
                if (rtrim($pathinfo, '/') === '/events') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'gospelcenterEvents_list');
                    }

                    return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterEvents_list')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::listAction',));
                }

                // gospelcenterEvents_event
                if (0 === strpos($pathinfo, '/events/event') && preg_match('#^/events/event/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterEvents_event')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::eventAction',));
                }

                // gospelcenterEvents_add
                if ($pathinfo === '/events/add') {
                    return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterEvents_add')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::addAction',));
                }

                // gospelcenterEvents_edit
                if (0 === strpos($pathinfo, '/events/edit') && preg_match('#^/events/edit/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterEvents_edit')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::editAction',));
                }

                // gospelcenterEvents_delete
                if (0 === strpos($pathinfo, '/events/delete') && preg_match('#^/events/delete/(?P<event>\\d+)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterEvents_delete')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::deleteAction',));
                }

                // gospelcenterEvents_manage
                if ($pathinfo === '/events/manage') {
                    return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterEvents_manage')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::manageAction',));
                }

                // gospelcenterEvents_JSON_MAX
                if (preg_match('#^/events/(?P<nb>\\d+)\\.json$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterEvents_JSON_MAX')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::jsonAction',));
                }

                // gospelcenterEvents_JSON
                if ($pathinfo === '/events/json') {
                    return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterEvents_JSON')), array (  '_controller' => 'gospelcenter\\EventBundle\\Controller\\EventController::jsonAction',  'nb' => 0,));
                }

            }

            // gospelcenterPage_home
            if (rtrim($pathinfo, '/') === '') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'gospelcenterPage_home');
                }

                return $this->mergeDefaults(array_replace($hostMatches, array('_route' => 'gospelcenterPage_home')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\PageController::homeAction',));
            }

            // gospelcenterPage_default
            if (preg_match('#^/(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($hostMatches, $matches, array('_route' => 'gospelcenterPage_default')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\PageController::indexAction',));
            }

        }

        if (preg_match('#^gospelcenter\\.local$#s', $host, $hostMatches)) {
            // gospelcenterPageGlobal_home
            if (rtrim($pathinfo, '/') === '') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'gospelcenterPageGlobal_home');
                }

                return array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\PageGlobalController::indexAction',  'page' => 'home',  '_route' => 'gospelcenterPageGlobal_home',);
            }

            // gospelcenterPageGlobal_default
            if (preg_match('#^/(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'gospelcenterPageGlobal_default')), array (  '_controller' => 'gospelcenter\\PageBundle\\Controller\\PageGlobalController::indexAction',));
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}

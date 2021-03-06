<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** PaginationQueryFactory.php */ 
namespace Cv\Repository\Filter;

use Zend\ServiceManager\FactoryInterface;

class JsonPaginationQueryFactory implements FactoryInterface
{
	public function createService (\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $auth     = $services->get('AuthenticationService');
        $user     = $auth->hasIdentity() ? $auth->getUser() : null;
        $filter   = new JsonPaginationQuery($user);
        
        return $filter;
        
    }

    
}


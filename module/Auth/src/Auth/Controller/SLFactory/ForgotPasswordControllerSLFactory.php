<?php

namespace Auth\Controller\SLFactory;

use Auth\Controller\ForgotPasswordController;
use Auth\Form;
use Auth\Service;
use Zend\Log\LoggerInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForgotPasswordControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ForgotPasswordController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $form    Form\ForgotPassword
         * @var $service Service\ForgotPassword
         * @var $logger  LoggerInterface
         */
        $form = $serviceLocator->get('Auth\Form\ForgotPassword');
        $service = $serviceLocator->get('Auth\Service\ForgotPassword');
        $logger = $serviceLocator->get('Log/Core/Cam');

        return new ForgotPasswordController($form, $service, $logger);
    }
}
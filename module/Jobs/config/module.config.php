<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'odm_default' => array(
                'drivers' => array(
                    'Jobs\Entity' => 'annotation',
                ),
            ),
            'annotation' => array(
                /*
                 * All drivers (except DriverChain) require paths to work on. You
                 * may set this value as a string (for a single path) or an array
                 * for multiple paths.
                 * example https://github.com/doctrine/DoctrineORMModule
                 */
                'paths' => array( __DIR__ . '/../src/Jobs/Entity'),
            ),
        ),
        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array(
                    '\Jobs\Repository\Event\UpdatePermissionsSubscriber',
                ),
            ),
        ),
    ),
    
    'Jobs' => array(
        'dashboard' => array(
            'enabled' => true,
            'widgets' => array(
                'recentJobs' => array(
                    'controller' => 'Jobs/Index',
                    'params' => array(
                        'type' => 'recent'
                    ),
                ),
            ),
        ), 
    ),

	// Translations
	'translator' => array(
			'translation_file_patterns' => array(
					array(
							'type'     => 'gettext',
							'base_dir' => __DIR__ . '/../language',
							'pattern'  => '%s.mo',
					),
			),
	),
    
    
    
      
    'acl' => array(
        'rules' => array(
            'recruiter' => array(
                'allow' => array(
                    'Jobs/Manage',
                    'route/lang/jobs/manage',
                    'Entity/Jobs/Job' => array(
                        'new',
                        'edit' => 'Jobs/Write',
                    ),
                ),
            ),
        ),
        'assertions' => array(
            'invokables' => array(
                'Jobs/Write' => 'Jobs\Acl\WriteAssertion'
            ),
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'jobs' => array(
                'label' =>  /*@translate*/ 'Jobs',
                'route' => 'lang/jobs',
                'order' => '30',
                'pages' => array(
                    'list' => array(
                        'label' => /*@translate*/ 'Overview',
                        'route' => 'lang/jobs',
                    ),
                    'new' => array(
                        'label' => /*@translate*/ 'Create job',
                        'route' => 'lang/jobs/manage',
                        'resource' => 'route/lang/jobs/manage',
                        'params' => array(
                            'action' => 'edit'
                        ),
                        'id' => 'Jobs/new',
                    ),
                    'edit' => array(
                        'label' => /*@translate*/ 'Edit job',
                        'resource' => 'route/lang/jobs/manage',
                        'uri' => '#',
                        'visible' => false,
                        'id' => 'Jobs/edit'
                    ),
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'Jobs/PreviewLinkHydrator' => 'Jobs\Form\Hydrator\PreviewLinkHydrator',
            'Jobs/Listeners'           => 'Jobs\Listener\JobsListener',
            'Jobs/Event'               => 'Jobs\Listener\Events\JobEvent',
            'Jobs/PortalListener'      => 'Jobs\Listener\PortalListener',
        )
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Jobs/Index' => 'Jobs\Controller\IndexController',
            'Jobs/Manage' => 'Jobs\Controller\ManageController',
            'Jobs/Import' => 'Jobs\Controller\ImportController',
            'Jobs/Console' => 'Jobs\Controller\ConsoleController'
        ),
    ),
    
    'view_manager' => array(
        // Map template to files. Speeds up the lookup through the template stack.
        'template_map' => array(
            'jobs/sidebar/index' => __DIR__ . '/../view/sidebar/index.phtml',
            'jobs/form/list-filter' => __DIR__ . '/../view/form/list-filter.phtml',
            'jobs/form/apply-identifier' => __DIR__ . '/../view/form/apply-identifier.phtml',
            'jobs-publish-on-yawik' => __DIR__ . '/../view/modals/yawik.phtml',
            'jobs-publish-on-jobsintown' => __DIR__ . '/../view/modals/jobsintown.phtml',
            'jobs-publish-on-homepage' => __DIR__ . '/../view/modals/homepage.phtml',
            'jobs-terms-and-conditions' => __DIR__ . '/../view/jobs/index/terms.phtml',
            'mail/jobCreatedMail' => __DIR__ . '/../view/mails/jobCreatedMail.phtml',
        ),
    
        // Where to look for view templates not mapped above
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'jobPreviewLink' => 'Jobs\Form\View\Helper\PreviewLink',

        )
    ),
       
    'form_elements' => array(
        'invokables' => array(
            'Jobs/Job'                          => 'Jobs\Form\Job',
            'Jobs/Base'                         => 'Jobs\Form\Base',
            'Jobs/BaseFieldset'                 => 'Jobs\Form\BaseFieldset',
            'Jobs/Employers'                    => 'Jobs\Form\JobEmployers',
            'Jobs/JobEmployersFieldset'         => 'Jobs\Form\JobEmployersFieldset',
            'Jobs/Description'                  => 'Jobs\Form\JobDescription',
            'Jobs/JobDescriptionFieldset'       => 'Jobs\Form\JobDescriptionFieldset',
            'Jobs/ApplyId'                      => 'Jobs\Form\ApplyIdentifierElement',
            'Jobs/Import'                       => '\Jobs\Form\Import',
            'Jobs/ImportFieldset'               => '\Jobs\Form\ImportFieldset',
            'Jobs/ListFilter'                   => '\Jobs\Form\ListFilter',
            'Jobs/ListFilterFieldset'           => 'Jobs\Form\ListFilterFieldset',
            'Jobs/JobDescriptionBenefits'       => '\Jobs\Form\JobDescriptionBenefits',
            'Jobs/JobDescriptionRequirements'   => '\Jobs\Form\JobDescriptionRequirements',
            'Jobs/JobDescriptionQualifications' => '\Jobs\Form\JobDescriptionQualifications',
            'Jobs/JobDescriptionTitle'          => '\Jobs\Form\JobDescriptionTitle',
            'Jobs/Description/Template'         => '\Jobs\Form\JobDescriptionTemplate',
            'Jobs/Preview'                      => 'Jobs\Form\Preview',
            'Jobs/PreviewFieldset'              => 'Jobs\Form\PreviewFieldset',
            'Jobs/PreviewLink'                  => 'Jobs\Form\PreviewLink',
            'Jobs/CompanyName'                  => 'Jobs\Form\CompanyName',
            'Jobs/CompanyNameFieldset'          => 'Jobs\Form\CompanyNameFieldset',
            'Jobs/CompanyNameElement'           => 'Jobs\Form\CompanyNameElement',
            'Jobs/Multipost'                    => 'Jobs\Form\Multipost',
            'Jobs/MultipostFieldset'            => 'Jobs\Form\MultipostFieldset',
            'Jobs/MultipostElement'             => 'Jobs\Form\MultipostElement',

        ),
        'factories' => array(
            'jobs/ListFilterFieldsetExtended' => 'Jobs\Form\ListFilterFieldsetExtendedFactory',
        )
    ),
    
    'input_filters' => array(
        'invokables' => array(
            'Jobs/Location/New'  => 'Jobs\Form\InputFilter\JobLocationNew',
            'Jobs/Location/Edit' => 'Jobs\Form\InputFilter\JobLocationEdit',
        ),
    ),
    
    'filters' => array(
        'factories'=> array(
            'Jobs/PaginationQuery' => '\Jobs\Repository\Filter\PaginationQueryFactory'
        ),
    ),
    
    'validators' => array(
        'factories' => array(
            'Jobs/Form/UniqueApplyId' => 'Jobs\Form\Validator\UniqueApplyIdFactory',
        ),
    ),
);
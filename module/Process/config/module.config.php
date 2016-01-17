<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonProcess for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Process;

return array(
    'controllers' => array(
        'invokables' => array(
            'Process\Controller\AgendamentoController' => 'Process\Controller\AgendamentoController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
            // Rota para agenda
            'agendamento' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/process/agendamento[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Process\Controller',
                        'controller' => 'Process\Controller\AgendamentoController',
                        'entity' => 'Process\Entity\Agendamento',
                        'module' => 'process',
                        'action' => 'index',
                        'caption' => 'Agendamento',
                        'icon' => 'fa-calendar',
                        
                        // Custom templates
                        'template' => array(
                            'add' => 'dataware/crud/add.phtml',
                            'edit' => 'dataware/crud/edit.phtml',
                            'delete' => 'dataware/crud/delete.phtml'
                        )
                    ),
                ),
            ),
           
        ),
    ),
    
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
    ),
    
    'service_process' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

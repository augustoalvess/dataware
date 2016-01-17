<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonRegister for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Register;

return array(
    'controllers' => array(
        'invokables' => array(
            'Register\Controller\ClienteController' => 'Register\Controller\ClienteController',
            'Register\Controller\AnexoController' => 'Register\Controller\AnexoController'
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
            // Rota para perfil
            'cliente' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/cliente[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Register\Controller',
                        'controller' => 'Register\Controller\ClienteController',
                        'action' => 'add'
                    ),
                ),
            ),
            
            // Rota para anexos
            'anexo' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/anexo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Register\Controller',
                        'entity' => 'Register\Entity\Anexo',
                        'controller' => 'Register\Controller\AnexoController',
                        'module' => 'register',
                        'action' => 'index',
                        'caption' => 'Anexos',
                        'icon' => 'fa-paperclip',
                        
                        // Custom templates
                        'template' => array(
                            'index' => 'dataware/crud/index.phtml',
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
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
);

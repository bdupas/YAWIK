<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** ListFilterFieldset.php */ 
namespace Jobs\Form;

use Zend\Form\Fieldset;
use Zend\Form\FormInterface;

/**
 * Defines the formular fields of the job opening search formular
 *
 * @package Jobs\Form
 */
class ListFilterFieldset extends Fieldset
{
    protected $isExtended;
    
    public function __construct($extended = false)
    {
        $this->isExtended = (bool) $extended;
        parent::__construct();
    }
    
    public function init()
    {
        $this->setName('params');
        
        $this->add(array(
            'type' => 'Hidden',
            'name' => 'page',
            'attributes' => array(
                'value' => 1,
            )
        ));
        
        if ($this->isExtended) {
            $this->add(array(
                'type' => 'Radio',
                'name' => 'by',
                'options' => array(
                    'value_options' => array(
                        'all' => /*@translate*/ 'Show all jobs',
                        'me'  => /*@translate*/ 'Show my jobs',
                    ),
                ),
                'attributes' => array(
                    'value' => 'all',
                )
                
            ));
            
            $this->add(array(
                'type' => 'Radio',
                'name' => 'status',
                'options' => array(
                    'value_options' => array(
                        'all' => /*@translate*/ 'All',
                        'active' => /*@translate*/ 'Active',
                        'inactive' => /*@translate*/ 'Inactive',
                    )
                ),
                'attributes' => array(
                    'value' => 'all',
                )
            ));
        }
        $this->add(array(
            'name' => 'search',
            'options' => array(
                'label' => /*@translate*/ 'Job title',
            ),
        ));
    }
    
    public function prepareElement(FormInterface $form)
    {
        foreach ($this->byName as $elementOrFieldset) {
            // Recursively prepare elements
            if ($elementOrFieldset instanceof ElementPrepareAwareInterface) {
                $elementOrFieldset->prepareElement($form);
            }
        }
    }
}


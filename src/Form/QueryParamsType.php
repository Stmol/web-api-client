<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QueryParamsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Param name',
            ))
            ->add('value', 'text', array(
                'label' => 'Param value',
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'query_params';
    }
}
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
use WebApiClient\Client\HttpMethodResolver;

class WebApiFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('method', 'choice', array(
                'choices' => HttpMethodResolver::getMethodsList(),
            ))
            ->add('params', 'collection', array(
                'type'         => new QueryParamsType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'options'  => array(
                    'required' => false,
                ),
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
        return 'web_api_form';
    }
}
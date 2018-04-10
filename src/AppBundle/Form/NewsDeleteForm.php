<?php
/**
 * Created by PhpStorm.
 * User: nikitadada
 * Date: 09.04.18
 * Time: 11:27
 */

namespace AppBundle\Form;

use AppBundle\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsDeleteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class, ['mapped' => false])->add('submit', SubmitType::class, [
            'label' => 'Delete'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', News::class);
    }

}
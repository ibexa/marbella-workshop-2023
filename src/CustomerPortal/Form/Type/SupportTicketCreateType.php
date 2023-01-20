<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form\Type;

use App\CustomerPortal\Form\Data\SupportTicketData;
use App\Model\SupportTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportTicketCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    SupportTicket::TYPE_NONE => SupportTicket::TYPE_NONE,
                    SupportTicket::TYPE_QUESTION => SupportTicket::TYPE_QUESTION,
                    SupportTicket::TYPE_INCIDENT => SupportTicket::TYPE_INCIDENT,
                    SupportTicket::TYPE_PROBLEM => SupportTicket::TYPE_PROBLEM,
                    SupportTicket::TYPE_FEATURE => SupportTicket::TYPE_FEATURE,
                    SupportTicket::TYPE_REFUND => SupportTicket::TYPE_REFUND,
                ],
                'label' => 'Type',
                'required' => true,
            ])
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'Low' => SupportTicket::PRIORITY_LOW,
                    'Medium' => SupportTicket::PRIORITY_MEDIUM,
                    'Heigh' => SupportTicket::PRIORITY_HEIGH,
                    'Urgent' => SupportTicket::PRIORITY_URGENT,
                ],
                'label' => 'Priority',
                'required' => true,
            ]);

        $builder
            ->add(
                'create',
                SubmitType::class,
                [
                    'label' => /** @Desc("Create") */ 'customer_portal.support_ticket.create.submit',
                    'attr' => [
                        'class' => 'ibexa-btn ibexa-btn--primary',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportTicketData::class,
            'translation_domain' => 'forms',
        ]);
    }
}

<?php

namespace App\Form\Frontend;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class SurveyFlow extends FormFlow
{
    protected $allowDynamicStepNavigation = true;

    /**
     * @return string[][]
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'Krok 1',
                'form_type' => SurveyStep1Type::class,
            ],
            [
                'label' => 'Krok 2',
                'form_type' => SurveyStep2Type::class,
            ],
            [
                'label' => 'Krok 3',
                'form_type' => SurveyStep3Type::class,
            ],
            [
                'label' => 'Krok 4',
                'form_type' => SurveyStep4Type::class,
            ],
            [
                'label' => 'Krok 5',
                'form_type' => SurveyStep5Type::class,
            ],
            //[
            //    'label' => 'engine',
            //    'form_type' => CreateVehicleStep2Form::class
            //],
            [
                'label' => 'Podsumowanie',
                'skip' => true
            ],
        ];
    }

}
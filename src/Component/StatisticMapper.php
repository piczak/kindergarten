<?php


namespace App\Component;


class StatisticMapper
{
    public function getLegend(): array
    {
        return [
            'statusFood' => [
                'description' => 'Status zachowań żywieniowych',
                'legend' => [
                    1 => 'Prawidłowy sposób odżywiania',
                    2 => 'Sposób odżywiania wymagający niewielkich modyfikacji',
                    3 => 'Sposób odżywiania wymagający poważnych zmian'
                ]
            ],
            'statusNicotine' => [
                'description' => 'Status nikotynowy',
                'legend' => [
                    1 => 'Brak narażenia na dym tytoniowy',
                    2 => 'Ma miejsce narażenie na dym tytoniowy'
                ]
            ],
            'statusImmune' => [
                'description' => 'Status uodpornienia',
                'legend' => [
                    1 => 'Prawidłowy status uodpornienia',
                    2 => 'Nieprawidłowy status uodpornienia'
                ]
            ],
            'statusSleep' => [
                'description' => 'Status jakości snu i wypoczynku',
                'legend' => [
                    1 => 'Prawidłowa jakość snu i wypoczynku',
                    2 => 'Jakość snu i wypoczynku wymaga poprawy',
                    3 => 'Jakość snu i wypoczynku wymaga całkowitej zmiany'
                ]
            ],
            'statusDigital' => [
                'description' => 'Status higieny cyfrowej',
                'legend' => [
                    1 => 'Prawidłowa higiena cyfrowa',
                    2 => 'Styl adaptacji wymaga poprawy',
                    3 => 'Styl adaptacji wymaga całkowitej zmiany'
                ]
            ],
            'statusAdaptation' => [
                'description' => 'Status kompetencji społecznych – styl adaptacji',
                'legend' => [
                    1 => 'Prawidłowy styl adaptacji',
                    2 => 'Styl adaptacji wymaga poprawy',
                    3 => 'Styl adaptacji wymaga całkowitej zmiany'
                ]
            ],
            'statusExternal' => [
                'description' => 'Status kompetencji społecznych – zachowania eksternalizacyjne',
                'legend' => [
                    1 => 'Prawidłowe zachowania eksternalizacyjne',
                    2 => 'Zachowania eksternalizacyjne wymagają poprawy',
                    3 => 'Zachowania eksternalizacyjne wymagają całkowitej zmiany'
                ]
            ],
            'statusNewness' => [
                'description' => 'Status rozwoju emocjonalnego – reakcja na nowość',
                'legend' => [
                    1 => 'Prawidłowa reakcja na nowość',
                    2 => 'Reakcja na nowość wymaga poprawy',
                    3 => 'Reakcja na nowość wymaga całkowitej zmiany'
                ]
            ],
            'statusFocus' => [
                'description' => 'Status rozwoju emocjonalnego - koncentracja',
                'legend' => [
                    1 => 'Prawidłowa koncentracja uwagi',
                    2 => 'Koncentracja uwagi wymaga poprawy',
                    3 => 'Koncentracja uwagi wymaga całkowitej zmiany'
                ]
            ],
            'statusWeight' => [
                'description' => 'Status masy ciała',
                'legend' => [
                    1 => 'Znaczna niedowaga',
                    2 => 'Niedowaga',
                    3 => 'Szczupłość',
                    4 => 'Masa ciała w normie',
                    5 => 'Nadwaga',
                    6 => 'Otyłość'
                ]
            ],
            'statusActivity' => [
                'description' => 'Status aktywności fizycznej',
                'legend' => [
                    1 => 'Odpowiedni poziom aktywności fizycznej',
                    2 => 'Za niski poziom aktywności fizycznej'
                ]
            ],
            'statusFitness' => [
                'description' => 'Status sprawności fizycznej',
                'legend' => [
                    1 => 'Sprawność fizyczna odpowiednia do wieku',
                    2 => 'Wskazana poprawa sprawności fizycznej',
                    3 => 'Konieczna poprawa sprawności fizycznej'
                ]
            ]
        ];
    }
}
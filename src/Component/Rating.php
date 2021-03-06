<?php

namespace App\Component;

class Rating
{
    public function get_fitness_stand_rating(float $age, string $gender, float $sek):int
    {
        /* OCENY:
        1 = Bardzo niski
        2 = Niski
        3 = Średni
        4 = Wysoki
        5 = Bardzo wysoki
        */

        $dataset = array();
        $agezone = array(3.00, 3.08, 3.17, 3.25, 3.33, 3.42, 3.50, 3.58, 3.67, 3.75, 3.83, 3.92, 4.00, 4.08, 4.17,
            4.25, 4.33, 4.42, 4.50, 4.58, 4.67, 4.75, 4.83, 4.92, 5.00, 5.08, 5.17, 5.25, 5.33, 5.42,
            5.50, 5.58, 5.67, 5.75, 5.83, 5.92, 6.00, 6.08, 6.17, 6.25);
        $a = 0;
        $rating = 5;

        for ($i=39; $i>=0; $i--) {
            if ($age >= $agezone[$i]) {
                $a = $i;
                break;
            }
        }

        if ($gender == 'M') {
            $dataset = array(
                array(0.964,1.463,3.793,7.988),
                array(1.045,1.586,4.111,8.659),
                array(1.126,1.709,4.43,9.331),
                array(1.235,1.874,4.86,10.236),
                array(1.319,2.002,5.19,10.931),
                array(1.405,2.133,5.531,11.649),
                array(1.527,2.318,6.01,12.657),
                array(1.624,2.465,6.391,13.461),
                array(1.727,2.621,6.795,14.312),
                array(1.873,2.843,7.371,15.525),
                array(1.99,3.021,7.832,16.496),
                array(2.114,3.208,8.318,17.519),
                array(2.288,3.473,9.004,18.965),
                array(2.426,3.682,9.547,20.108),
                array(2.57,3.9,10.113,21.299),
                array(2.77,4.204,10.9,22.957),
                array(2.926,4.441,11.515,24.253),
                array(3.088,4.686,12.151,25.592),
                array(3.311,5.025,13.029,27.442),
                array(3.484,5.288,13.711,28.878),
                array(3.662,5.558,14.411,30.352),
                array(3.906,5.928,15.371,32.374),
                array(4.093,6.213,16.108,33.927),
                array(4.284,6.502,16.86,35.51),
                array(4.544,6.896,17.881,37.661),
                array(4.742,7.197,18.66,39.302),
                array(4.942,7.501,19.449,40.963),
                array(5.212,7.911,20.513,43.204),
                array(5.417,8.222,21.318,44.9),
                array(5.623,8.534,22.128,46.606),
                array(5.899,8.953,23.214,48.893),
                array(6.106,9.268,24.031,50.614),
                array(6.314,9.584,24.85,52.338),
                array(6.592,10.006,25.943,54.642),
                array(6.801,10.322,26.764,56.371),
                array(7.009,10.639,27.585,58.099),
                array(7.287,11.061,28.679,60.403),
                array(7.496,11.377,29.499,62.129),
                array(7.704,11.693,30.318,63.855),
                array(7.981,12.114,31.409,66.153)
            );
        }
        elseif ($gender == 'F') {
            $dataset = array(
                array(0.843,1.344,3.659,7.452),
                array(0.957,1.526,4.154,8.46),
                array(1.073,1.71,4.656,9.481),
                array(1.23,1.961,5.339,10.872),
                array(1.351,2.155,5.865,11.945),
                array(1.476,2.354,6.408,13.048),
                array(1.649,2.63,7.158,14.576),
                array(1.784,2.845,7.743,15.768),
                array(1.923,3.067,8.348,16.999),
                array(2.116,3.374,9.184,18.703),
                array(2.266,3.613,9.834,20.027),
                array(2.42,3.859,10.503,21.389),
                array(2.631,4.196,11.422,23.259),
                array(2.794,4.456,12.13,24.701),
                array(2.961,4.722,12.853,26.174),
                array(3.188,5.085,13.841,28.185),
                array(3.363,5.363,14.597,29.726),
                array(3.54,5.645,15.367,31.294),
                array(3.781,6.03,16.414,33.425),
                array(3.965,6.324,17.213,35.053),
                array(4.152,6.621,18.024,36.704),
                array(4.405,7.024,19.121,38.938),
                array(4.597,7.33,19.954,40.634),
                array(4.79,7.639,20.794,42.344),
                array(5.051,8.054,21.924,44.646),
                array(5.247,8.368,22.777,46.384),
                array(5.445,8.683,23.636,48.132),
                array(5.71,9.106,24.787,50.477),
                array(5.91,9.425,25.655,52.243),
                array(6.111,9.744,26.525,54.015),
                array(6.378,10.171,27.686,56.381),
                array(6.579,10.491,28.558,58.155),
                array(6.779,10.811,29.428,59.927),
                array(7.046,11.236,30.586,62.285),
                array(7.246,11.555,31.453,64.05),
                array(7.445,11.873,32.318,65.812),
                array(7.71,12.295,33.469,68.156),
                array(7.909,12.612,34.331,69.912),
                array(8.107,12.928,35.192,71.665),
                array(8.372,13.35,36.34,74.002)
            );
        }

        for ($i=0; $i<4; $i++) {

            if ($sek < $dataset[$a][$i]) {
                $rating = ($i+1);
                break;
            }
        }

        return $rating;

    }

    public function get_fitness_altern_run_rating(float $age, string $gender, float $sek):int
    {

        /* OCENY:
        1 = Bardzo niski
        2 = Niski
        3 = Średni
        4 = Wysoki
        5 = Bardzo wysoki
        */

        $dataset = array();
        $agezone = array(3.00, 3.08, 3.17, 3.25, 3.33, 3.42, 3.50, 3.58, 3.67, 3.75, 3.83, 3.92, 4.00, 4.08, 4.17,
            4.25, 4.33, 4.42, 4.50, 4.58, 4.67, 4.75, 4.83, 4.92, 5.00, 5.08, 5.17, 5.25, 5.33, 5.42,
            5.50, 5.58, 5.67, 5.75, 5.83, 5.92, 6.00, 6.08, 6.17, 6.25);
        $a = 0;
        $rating = 5;

        for ($i=39; $i>=0; $i--) {
            if ($age >= $agezone[$i]) {
                $a = $i;
                break;
            }
        }

        if ($gender == 'M') {
            $dataset = array(
                array(17.419,18.605,21.666,24.755),
                array(17.259,18.421,21.414,24.425),
                array(17.098,18.236,21.163,24.097),
                array(16.883,17.991,20.83,23.666),
                array(16.722,17.807,20.583,23.347),
                array(16.562,17.625,20.339,23.033),
                array(16.352,17.386,20.018,22.62),
                array(16.197,17.209,19.78,22.314),
                array(16.045,17.036,19.546,22.012),
                array(15.845,16.808,19.238,21.616),
                array(15.697,16.639,19.012,21.326),
                array(15.551,16.473,18.79,21.044),
                array(15.358,16.255,18.503,20.682),
                array(15.216,16.095,18.295,20.421),
                array(15.078,15.94,18.095,20.172),
                array(14.901,15.743,17.84,19.856),
                array(14.775,15.602,17.659,19.632),
                array(14.655,15.467,17.486,19.418),
                array(14.502,15.296,17.266,19.146),
                array(14.394,15.175,17.109,18.951),
                array(14.289,15.058,16.958,18.764),
                array(14.155,14.908,16.766,18.528),
                array(14.057,14.799,16.629,18.362),
                array(13.96,14.693,16.498,18.205),
                array(13.835,14.556,16.332,18.009),
                array(13.742,14.457,16.213,17.87),
                array(13.652,14.359,16.099,17.739),
                array(13.534,14.233,15.953,17.574),
                array(13.448,14.142,15.848,17.456),
                array(13.365,14.054,15.748,17.343),
                array(13.261,13.944,15.62,17.198),
                array(13.188,13.865,15.528,17.093),
                array(13.118,13.79,15.439,16.99),
                array(13.029,13.693,15.323,16.854),
                array(12.964,13.622,15.237,16.753),
                array(12.899,13.552,15.151,16.652),
                array(12.813,13.458,15.038,16.519),
                array(12.748,13.388,14.954,16.421),
                array(12.683,13.318,14.87,16.324),
                array(12.595,13.223,14.76,16.197)
            );
        }
        elseif ($gender == 'F') {
            $dataset = array(
                array(18.084,19.427,22.524,26.121),
                array(17.94,19.245,22.245,25.702),
                array(17.794,19.062,21.967,25.292),
                array(17.595,18.816,21.598,24.756),
                array(17.443,18.63,21.321,24.363),
                array(17.288,18.442,21.047,23.978),
                array(17.078,18.189,20.686,23.48),
                array(16.917,17.999,20.419,23.116),
                array(16.755,17.808,20.155,22.762),
                array(16.537,17.554,19.811,22.304),
                array(16.372,17.363,19.559,21.973),
                array(16.207,17.172,19.315,21.653),
                array(15.986,16.92,19.004,21.247),
                array(15.823,16.734,18.784,20.959),
                array(15.662,16.551,18.578,20.688),
                array(15.455,16.317,18.323,20.352),
                array(15.306,16.149,18.146,20.121),
                array(15.164,15.99,17.98,19.907),
                array(14.983,15.79,17.776,19.647),
                array(14.856,15.65,17.633,19.47),
                array(14.735,15.519,17.499,19.307),
                array(14.585,15.357,17.333,19.11),
                array(14.48,15.244,17.215,18.973),
                array(14.381,15.139,17.103,18.844),
                array(14.26,15.01,16.962,18.682),
                array(14.176,14.919,16.86,18.566),
                array(14.095,14.833,16.762,18.454),
                array(13.991,14.723,16.634,18.309),
                array(13.915,14.642,16.54,18.203),
                array(13.839,14.561,16.446,18.099),
                array(13.738,14.455,16.322,17.962),
                array(13.661,14.374,16.229,17.86),
                array(13.583,14.291,16.135,17.756),
                array(13.475,14.178,16.008,17.614),
                array(13.393,14.09,15.911,17.504),
                array(13.311,14.001,15.814,17.39),
                array(13.199,13.881,15.683,17.235),
                array(13.115,13.789,15.583,17.116),
                array(13.03,13.696,15.483,16.995),
                array(12.914,13.57,15.348,16.832)
            );
        }

        for ($i=0; $i<4; $i++) {

            if ($sek < $dataset[$a][$i]) {
                $rating = ($i+1);
                break;
            }
        }

        return $rating;

    }

    public function get_fitness_jump_rating(float $age, string $gender, float $cm):int
    {
        /* OCENY:
        1 = Bardzo niski
        2 = Niski
        3 = Średni
        4 = Wysoki
        5 = Bardzo wysoki
        */

        $dataset = array();
        $agezone = array(3.00, 3.08, 3.17, 3.25, 3.33, 3.42, 3.50, 3.58, 3.67, 3.75, 3.83, 3.92, 4.00, 4.08, 4.17,
            4.25, 4.33, 4.42, 4.50, 4.58, 4.67, 4.75, 4.83, 4.92, 5.00, 5.08, 5.17, 5.25, 5.33, 5.42,
            5.50, 5.58, 5.67, 5.75, 5.83, 5.92, 6.00, 6.08, 6.17, 6.25);
        $a = 0;
        $rating = 5;

        for ($i=39; $i>=0; $i--) {
            if ($age >= $agezone[$i]) {
                $a = $i;
                break;
            }
        }

        if ($gender == 'M') {
            $dataset = array(
                array(34.682,41.977,56.753,67.693),
                array(35.706,43.219,58.403,69.676),
                array(36.733,44.464,60.056,71.665),
                array(38.111,46.136,62.271,74.332),
                array(39.151,47.397,63.94,76.342),
                array(40.192,48.66,65.611,78.355),
                array(41.582,50.347,67.838,81.041),
                array(42.628,51.615,69.511,83.058),
                array(43.673,52.884,71.183,85.076),
                array(45.066,54.574,73.407,87.761),
                array(46.107,55.837,75.067,89.767),
                array(47.144,57.095,76.718,91.762),
                array(48.51,58.753,78.89,94.39),
                array(49.511,59.969,80.479,96.314),
                array(50.485,61.151,82.023,98.185),
                array(51.738,62.672,84.003,100.586),
                array(52.642,63.769,85.428,102.317),
                array(53.516,64.83,86.803,103.988),
                array(54.635,66.19,88.56,106.126),
                array(55.441,67.168,89.821,107.662),
                array(56.217,68.112,91.033,109.141),
                array(57.209,69.315,92.575,111.025),
                array(57.921,70.181,93.679,112.376),
                array(58.61,71.018,94.746,113.681),
                array(59.5,72.099,96.117,115.363),
                array(60.148,72.887,97.114,116.588),
                array(60.783,73.658,98.088,117.784),
                array(61.609,74.662,99.351,119.339),
                array(62.215,75.398,100.275,120.476),
                array(62.809,76.119,101.178,121.59),
                array(63.585,77.062,102.355,123.043),
                array(64.157,77.756,103.219,124.111),
                array(64.72,78.441,104.07,125.163),
                array(65.46,79.339,105.182,126.541),
                array(66.008,80.004,106.004,127.559),
                array(66.551,80.665,106.818,128.57),
                array(67.273,81.54,107.896,129.908),
                array(67.812,82.194,108.699,130.906),
                array(68.35,82.847,109.5,131.901),
                array(69.069,83.72,110.568,133.23)
            );
        }
        elseif ($gender == 'F') {
            $dataset = array(
                array(28.694,35.622,49.829,60.152),
                array(29.69,36.863,51.497,62.203),
                array(30.687,38.104,53.161,64.251),
                array(32.013,39.756,55.367,66.97),
                array(33.001,40.988,57.005,68.993),
                array(33.986,42.214,58.631,71.003),
                array(35.295,43.846,60.786,73.672),
                array(36.273,45.064,62.388,75.659),
                array(37.242,46.270,63.97,77.623),
                array(38.513,47.853,66.034,80.193),
                array(39.45,49.020,67.549,82.082),
                array(40.378,50.175,69.042,83.947),
                array(41.602,51.699,71.002,86.4),
                array(42.509,52.827,72.446,88.21),
                array(43.406,53.942,73.868,89.996),
                array(44.591,55.414,75.735,92.345),
                array(45.471,56.508,77.115,94.085),
                array(46.345,57.593,78.479,95.807),
                array(47.502,59.028,80.273,98.076),
                array(48.36,60.093,81.597,99.754),
                array(49.21,61.145,82.9,101.408),
                array(50.323,62.524,84.595,103.566),
                array(51.143,63.537,85.834,105.145),
                array(51.945,64.529,87.038,106.684),
                array(52.988,65.815,88.588,108.671),
                array(53.748,66.752,89.707,110.11),
                array(54.488,67.664,90.788,111.503),
                array(55.445,68.840,92.17,113.29),
                array(56.14,69.692,93.161,114.577),
                array(56.813,70.518,94.112,115.815),
                array(57.68,71.577,95.319,117.393),
                array(58.304,72.339,96.176,118.518),
                array(58.908,73.074,96.993,119.595),
                array(59.684,74.017,98.028,120.965),
                array(60.249,74.701,98.77,121.951),
                array(60.803,75.371,99.489,122.909),
                array(61.532,76.250,100.423,124.159),
                array(62.076,76.904,101.113,125.083),
                array(62.62,77.558,101.799,126.003),
                array(63.35,78.432,102.711,127.228)
            );
        }

        for ($i=0; $i<4; $i++) {

            if ($cm < $dataset[$a][$i]) {
                $rating = ($i+1);
                break;
            }
        }

        return $rating;

    }

    public function get_fitness_run20_rating(float $age, string $gender, float $sec):int
    {
        /* OCENY:
        1 = Niedostateczny
        2 = Dostateczny
        3 = Dobry
        4 = Bardzo dobry
        */

        $dataset = array();
        $a = 0;
        $rating = 4;

        switch (true) {
            case ($age < 4): $a = 0; break;
            case ($age < 5): $a = 1; break;
            case ($age < 6): $a = 2; break;
            case ($age < 7): $a = 3; break;
            default: $a = 4; break;
        }

        if ($gender == 'F') {
            $dataset = array(
                array(8.01, 7.31, 6.61),
                array(6.91, 6.41, 5.81),
                array(6.21, 5.71, 5.11),
                array(5.71, 5.21, 4.61),
                array(5.31, 4.91, 4.51)
            );
        }
        elseif ($gender == 'M') {
            $dataset = array(
                array(7.61, 6.81, 6.11),
                array(6.51, 6.01, 5.41),
                array(6.11, 5.61, 5.01),
                array(5.61, 5.11, 4.61),
                array(5.11, 4.71, 4.21)
            );
        }

        for ($i=0; $i<3; $i++) {

            if ($sec > $dataset[$a][$i]) {
                $rating = ($i+1);
                break;
            }
        }

        return $rating;
    }
}
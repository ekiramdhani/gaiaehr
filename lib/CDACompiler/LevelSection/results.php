<?php

/**
 * 2.74	Results Section (entries required) (V2)
 *
 * The Results section contains observations of results generated by laboratories, imaging procedures,
 * and other procedures. These coded result observations are contained within a Results Organizer in the
 * Results Section. The scope includes observations such as hematology, chemistry, serology, virology,
 * toxicology, microbiology, plain x-ray, ultrasound, CT, MRI, angiography, echocardiography, nuclear medicine,
 * pathology, and procedure observations. The section often includes notable results such as abnormal values or
 * relevant trends, and could contain all results for the period of time being documented.
 *
 * Laboratory results are typically generated by laboratories providing analytic services in areas such as
 * chemistry, hematology, serology, histology, cytology, anatomic pathology, microbiology, and/or virology.
 * These observations are based on analysis of specimens obtained from the patient and submitted to the laboratory.
 *
 * Imaging results are typically generated by a clinician reviewing the output of an imaging procedure,
 * such as where a cardiologist reports the left ventricular ejection fraction based on the review of a
 * cardiac echocardiogram.
 *
 * Procedure results are typically generated by a clinician to provide more granular information about
 * component observations made during  a procedure, such as where a gastroenterologist reports the size of a
 * polyp observed during a colonoscopy.
 *
 * Contains:
 * Result Organizer (V2)
 *
 */

namespace LevelSection;

use LevelEntry;
use Exception;

class results
{
    /**
     * @param $Data
     * @throws Exception
     */
    private static function Validate($Data)
    {
        // ...
    }

    /**
     * Build the Narrative part of this section
     * @param $Data
     */
    public static function Narrative($Data)
    {

    }

    /**
     * @return array
     */
    public static function Structure()
    {
        return [
            'Results' => [

            ]
        ];
    }

    /**
     * @param $Data
     * @return array|Exception
     */
    public static function Insert($Data)
    {
        try
        {
            // Validate first
            self::Validate($Data);

            $Section = [
                'templateId' => [
                    '@attributes' => [
                        'root' => '2.16.840.1.113883.10.20.22.2.3.1.2'
                    ]
                ],
                'code' => [
                    '@attributes' => [
                        'code' => '30954-2',
                        'displayName' => 'Relevant Diagnostic est and/or Laboratory Data',
                        'codeSystem' => '2.16.840.1.113883.6.1',
                        'codeSystemName' => 'LOINC'
                    ]
                ],
                'title' => 'Relevant Diagnostic est and/or Laboratory Data',
                'text' => self::Narrative($Data)
            ];

            // Health Status Observation (V2)
            // ...
            // Problem Concern Act (Condition) (V2)
            // ...


            return $Section;
        }
        catch (Exception $Error)
        {
            return $Error;
        }
    }

}

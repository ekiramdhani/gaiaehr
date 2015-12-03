<?php

/**
 * 2.39	Instructions Section (V2)
 *
 * The Instructions section records instructions given to a patient. List patient decision aids here.
 *
 * Contains:
 * Instruction (V2)
 *
 */

namespace LevelSection;

use LevelEntry;
use Exception;

class instructions
{

    /**
     * @param $Data
     */
    private static function Validate($Data)
    {

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
            'Instructions' => [

            ]
        ];
    }

    /**
     * @param $PortionData
     * @param $CompleteData
     * @return array|Exception
     */
    public static function Insert($PortionData, $CompleteData)
    {
        try
        {
            // Validate first
            self::Validate($PortionData);

            $Section = [
                'component' => [
                    'section' => [
                        'templateId' => [
                            '@attributes' => [
                                'root' => '2.16.840.1.113883.10.20.21.2.45.2',
                                'extension' => $PortionData['Instructions']['date']
                            ]
                        ],
                        'code' => [
                            '@attributes' => [
                                'code' => '69730-0',
                                'codeSystem' => '2.16.840.1.113883.6.1',
                                'codeSystemName' => 'LOINC',
                                'displayName' => 'INSTRUCTIONS'
                            ]
                        ],
                        'title' => 'Instructions',
                        'text' => self::Narrative($PortionData)
                    ]
                ]
            ];

            // 3.48	Instruction (V2) [0..*]
            foreach($PortionData['Instructions']['Activity'] as $Activity) {
                $Section['component']['section']['entry'][] = [
                    '@attributes' => [
                        'typeCode' => 'DRIV'
                    ],
                    'act' => LevelEntry\instruction::Insert($Activity, $CompleteData)
                ];
            }

            return $Section;
        }
        catch (Exception $Error)
        {
            return $Error;
        }
    }

}

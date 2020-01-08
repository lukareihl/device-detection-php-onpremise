<?php
/* *********************************************************************
 * This Original Work is copyright of 51 Degrees Mobile Experts Limited.
 * Copyright 2019 51 Degrees Mobile Experts Limited, 5 Charlotte Close,
 * Caversham, Reading, Berkshire, United Kingdom RG4 7BY.
 *
 * This Original Work is licensed under the European Union Public Licence (EUPL) 
 * v.1.2 and is subject to its terms as set out below.
 *
 * If a copy of the EUPL was not distributed with this file, You can obtain
 * one at https://opensource.org/licenses/EUPL-1.2.
 *
 * The 'Compatible Licences' set out in the Appendix to the EUPL (as may be
 * amended by the European Commission) shall be deemed incompatible for
 * the purposes of the Work and the provisions of the compatibility
 * clause in Article 5 of the EUPL shall not apply.
 * 
 * If using the Work as, or as part of, a network application, by 
 * including the attribution notice(s) required under Article 5 of the EUPL
 * in the end user terms of the application under an appropriate heading, 
 * such notice(s) shall fulfill the requirements of that article.
 * ********************************************************************* */

namespace fiftyone\pipeline\devicedetection;

use fiftyone\pipeline\engines\aspectData;
use fiftyone\pipeline\engines\aspectPropertyValue;

class swigData extends aspectData {

    public function __construct($engine, $result){

        $this->result = $result;
        
        parent::__construct(...func_get_args());
        
    }

    public function getInternal($key){

        $key = strtolower($key);

        if(isset($this->flowElement->properties[$key])){

            $property = $this->flowElement->properties[$key];

            $value = null;

            switch ($property["meta"]["type"]) {
                case "bool":                
                    $value = $this->result->getValueAsBool($property["meta"]["name"]);
                    break;
                case "string":
                    $value = $this->result->getValueAsString($property["meta"]["name"]);
                    break;
                case "javascript":
                    $value = $this->result->getValueAsString($property["meta"]["name"]);
                    break;
                case "int":
                    $value = $this->result->getValueAsInteger($property["meta"]["name"]);
                    break;
                case "double":
                    $value = $this->result->getValueAsDouble($property["meta"]["name"]);
                    break;
                case "string[]":
                    $value = [];
                    $list = $this->result->getValues($property["meta"]["name"]);
                    for ($j = 0; $j < $list->size(); $j++) {
                        $value[$j] = $list.get($j);
                    }
                    break;
            }

            $result;

            if ($value->hasValue())
            {
                $result = new aspectPropertyValue(null, $value->getValue());
            }
            else
            {
                $result = new aspectPropertyValue($value->getNoValueMessage());
            }

            return $result;

        }

    }

}

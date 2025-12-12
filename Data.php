<?php
/**
 * Open Source GPLv3
 */
declare(strict_types=1);
namespace iZiTA
{
    date_default_timezone_set('UTC');
    defined('iZiTA>Data') or die();
    /**
     * iZiTA::Data<br>
     * Script version: 0.0.0.12<br>
     * PHP Version: 8.5<br>
     * <b>Details</b>: Data converting, checking library for iZiTA<br>
     * @package iZiTA::Data
     * @author : TheTimeAuthority
     */
    Final Class Data
    {
        //<editor-fold desc="Final Array Functions">
        /**
         * Recursively get all array elements and values and return them as a string.
         * @param array $Array <p> The array to process.
         * @param String $Separator [optional]<p>
         * The separator to use between elements.<br>
         * Defaults to an empty string.</p>
         * @return String a string containing a string representation of all the array
         * elements in the same order, with the glue string between each element.
         */
        Final Function Array_To_String(Array $Array, String $Separator = ''): String
        {
            $Needle = '';
            $Needle = ($this->Array_Recursive_Get_Flat($Array, $Separator, True, '') ?? '') ?: $Needle = '';
            return $Needle;
        }
        //</editor-fold>
        //<editor-fold desc="Private Array Functions">
        /**
         * Recursively get all array elements and values.<br>
         * @param array $Array <p> The array to process</p>
         * @param String $Separator [optional]<p>
         *  The separator to be used between elements.<br>
         *  <i>> Defaults to an empty string.</i></p>
         * @param bool $As_String <p> Indicates if the function will be parsed and returned as string or array.<br>
         *  <i>> Defaults to True.</i></p>
         * @param String $Prefix <p>
         * This is a prefix that is set by the function when calling itself to result in the full array element path.<br>
         * <i>> Defaults to an empty string. Do not change.</i></p>
         * @return array|String
         */
        Private Function Array_Recursive_Get_Flat(Array $Array, String $Separator = '', Bool $As_String = True, String $Prefix = ''): Array|String
        {#
            if($As_String === True)
            {# Return the result as string
                $Result = '';
            }else
            {# Return the result as array
                $Result = [];
            }
            $Prefix = (String)$Prefix;
            $Array_Keys = array_keys($Array);
            $Count = count($Array_Keys);
            foreach($Array_Keys as $K => $Key)
            {# Process each element of the array
                $Value = $Array[$Key];
                $Prefix_Length = strlen($Prefix);
                if($Prefix_Length > 0)
                {# Build the current key path //
                    $Current_Key = $Prefix.$Separator.(String)$Key;
                }else
                {# Build the current key path
                    $Current_Key = (String)$Key;
                }
                $isLast = ($K === $Count - 1);
                if(is_array($Value) === True)
                {# Recursively process nested arrays.
                    if($As_String === True)
                    {# Flatten the result when requested as a string
                        $nestedResult = $this->Array_Recursive_Get_Flat($Value, $Separator, True, $Current_Key);
                        if(is_array($nestedResult) === True)
                        {# On error empty nesterResult
                            $nestedResult = '';
                        }
                        $Result .= $nestedResult;
                        if($isLast === False)
                        {
                            $Result .= $Separator;
                        }
                    }else
                    {
                        $nestedResult = $this->Array_Recursive_Get_Flat($Value, $Separator, False, $Current_Key);
                        $Result[$Key] = $nestedResult;
                    }
                }else
                {# Handle non-array values.
                    if($As_String === True)
                    {
                        if(strlen($Result) > 0)
                        {
                            $Result .= $Separator;
                        }
                        $Result .= (String)$Current_Key;
                        if(empty($Value) === False)
                        {
                            $Result .= $Separator.(String)$Value;
                        }
                    }else
                    {# Preserve the key-value pair if not in string mode.
                        $Result[$Key] = $Value;
                    }
                }
            }
            return $Result;
        }
        //</editor-fold>
    }
}
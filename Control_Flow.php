<?php
/**
 * Open Source GPLv3
 */
declare(strict_types=1);
namespace iZiTA
{
    //<editor-fold desc="Initialization Process">
    //<editor-fold desc="Check Startup">
    $included_files = False;
    ((__FILE__ ?? $included_files = True) === (get_included_files()[0] ?? $included_files = True)) ? True : ($included_files === False ? False : True) and exit;
    //</editor-fold>
    defined('iZiTA>Control_Flow') or exit;
    define('iZiTA>Data', False);
    //</editor-fold>
    date_default_timezone_set('UTC');
    //<editor-fold desc="Test Use Settings">
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    #error_reporting(9);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    //</editor-fold>
    /**
     * iZiTA::Control_Flow<br>
     * Script version: 25.12.0.61<br>
     * PHP Version: 8.5<br>
     * Details: iZiTA::Control Flow is a library to manage execution and variable reads/writes based on access, usage state and execution.
     * @package iZiTA::Control_Flow
     * @author : TheTimeAuthority
     */
    Final Class Control_Flow
    {
        //<editor-fold desc="Initialize">
        /**
         * The constructor for iZiTA::Control_Flow
         * @param String $Token_Database_Path is the path to load the configuration file from.<br>
         * If a file is not provided the script will exit.
         */
        Final Function __construct(String $Token_Database_Path = '')
        {
            echo PHP_EOL.' [ I ] ( Control_Flow Class )               Initializing Control Flow Class';
            (require_once 'Data.php' ?? exit) ?: exit;
            (require_once 'Logger.php' ?? exit) ?: exit;
            (class_exists(\iZiTA\Data::class, False) && enum_exists(\iZiTA\Data::class, False) === False) ? (($this->Data = new Data() ?? exit) ? (($this->is_Data = True ?? exit) ?: exit) : exit) : exit;
            (class_exists(\iZiTA\Logger::class, False) && enum_exists(\iZiTA\Logger::class, False) === False) ?: exit;
            $is_configuration_loaded = False;
            $is_configuration_loaded = ($this->Load_Configuration($Token_Database_Path) ?? False) ?: ($is_configuration_loaded = False);
            if(is_array($is_configuration_loaded) === True and empty($is_configuration_loaded) === False and isset($this->Control_Flow_Database) === False)
            {
                $this->Control_Flow_Database = $is_configuration_loaded ?: exit;
                if(isset($this->Control_Flow_Database) === True and $this->Control_Flow_Database === $is_configuration_loaded)
                {
                    $this->is_configuration_loaded = True ?: exit;
                    echo PHP_EOL.' [ I ] ( Control_Flow Class )               Control Flow Database was loaded successfully.';
                }else
                {
                    echo PHP_EOL.' [ I ] ( Control_Flow Class )               Initializing Control Flow Class Failed. Error: Failed to load Control Flow Database rules. Exiting.';
                    exit;
                }
            }else
            {
                echo PHP_EOL.' [ I ] ( Control_Flow Class )               Initializing Control Flow Class Failed. Error: Failed loading Control Flow Database rules. Exiting.';
                exit;
            }
            unset($is_configuration_loaded);
        }
        /**
         * Loads the configuration file to be used for the Control_Flow of the Class.
         * @param String $Token_Database_Path Is the path to load the configuration from.
         * @return array | Bool Returns the database in array format False otherwise.
         */
        Private Function Load_Configuration(String $Token_Database_Path = ''): array|Bool
        {
            $OK_Status = False;
            if(isset($this->is_configuration_loaded) === False and isset($this->Control_Flow_Database) === False and empty($this->Shadow_Control_Flow_Database) === True)
            {
                if(isset($Token_Database_Path) === True and empty($Token_Database_Path) === False and is_string($Token_Database_Path) === True and mb_detect_encoding($Token_Database_Path, 'UTF-8', true) === 'UTF-8')
                {
                    $Token_Database_Path_Extension = '';
                    $Token_Database_Path_Length = strlen($Token_Database_Path);
                    if($Token_Database_Path_Length > 5)
                    {# Get extension from the path string
                        $Token_Database_Path_Extension = ($Token_Database_Path[$Token_Database_Path_Length-6].$Token_Database_Path[$Token_Database_Path_Length-5].$Token_Database_Path[$Token_Database_Path_Length-4].$Token_Database_Path[$Token_Database_Path_Length-3].$Token_Database_Path[$Token_Database_Path_Length-2].$Token_Database_Path[$Token_Database_Path_Length-1] ?? '');
                    }
                    $Token_Database_Path_Length = 0;
                    unset($Token_Database_Path_Length);
                    clearstatcache(True, $Token_Database_Path);
                    if($Token_Database_Path_Extension === '.izita' and file_exists($Token_Database_Path) === True and filetype($Token_Database_Path) === 'file')
                    {# Load Execution Database and proceed.
                        $Token_Database_Path_Extension = '';
                        unset($Token_Database_Path_Extension);
                        $Token_Database_Size = (filesize($Token_Database_Path) ?? 0) ?: ($Token_Database_Size = 0);
                        if(is_int($Token_Database_Size) === False or $Token_Database_Size < 128 or $Token_Database_Size > 8192)
                        {# Exit on wrong database file size.
                            $this->Execution_Expelliarmus = True;
                        }
                        $Token_Database_Size = 0;
                        unset($Token_Database_Size);
                        $Load_Token_Database = '';
                        $Load_Token_Database = (file_get_contents($Token_Database_Path) ?? '') ?: ($Load_Token_Database = '');
                        $Token_Database_Path = '';
                        unset($Token_Database_Path);
                        if(empty($Load_Token_Database) === False and is_string($Load_Token_Database) === True and mb_detect_encoding($Load_Token_Database, 'UTF-8', true) === 'UTF-8' and str_contains($Load_Token_Database, '.') === True)
                        {#  . | ; =
                            $Load_Token_Database = preg_replace("/[^A-Z_|=:;.]/", '', $Load_Token_Database) ?: $Load_Token_Database = '';
                            $Load_Token_Database = (explode('.', $Load_Token_Database) ?? '') ?: $Load_Token_Database = '';
                            $Control_Flow_Database = [];
                            $Positive_X = 0;
                            foreach($Load_Token_Database as $Current_Script_Depth)
                            {# Build Control_Flow_Database from the provided data. ( . is the Script_Depth )     ( explode | [0] is $Current_Script_Access )     ( Sub_Script_Depth is ; )
                                if($Current_Script_Depth === '' or empty($Current_Script_Depth))
                                {
                                    continue;
                                }
                                # # # START Struct
                                $Current_Action = '';
                                $Other_Actions = '';
                                $Equals_Sign_Key = '';
                                $Equals_Sign_Value = '';
                                [$Current_Action, $Other_Actions] = (explode('|', $Current_Script_Depth, 2) ?? '') ?: ($Current_Action = '')($Other_Actions = '');
                                if(empty($Current_Action) === False)
                                {
                                    $Current_Action = (preg_replace("/[^A-Z_]/", '', $Current_Action)  ?? '') ?: $Current_Action = '';
                                }
                                if(empty($Other_Actions) === False)
                                {
                                    $Other_Actions = (preg_replace("/[^A-Z_=:;]/", '', $Other_Actions) ?? '') ?: $Other_Actions = '';
                                    $Equals_Sign_Key = (explode('=', $Other_Actions, 1)[0] ?? '') ?: $Equals_Sign_Key = '';
                                    $Equals_Sign_Value = (explode('=', $Other_Actions, 2)[1] ?? '') ?: $Equals_Sign_Value = '';
                                }
                                $is_valid_entry = false;
                                # # # END Struct
                                if(empty($Current_Script_Depth) === False and empty($Current_Action) === False and empty($Other_Actions) === False and isset($Equals_Sign_Key[0]) === True and isset($Equals_Sign_Value[0]) === True and isset($Equals_Sign_Value[1]) === True and $Equals_Sign_Value[strlen($Equals_Sign_Value)-1] === ';')
                                {# Validates execution control flow database
                                    $Other_Actions = (explode(';', $Other_Actions) ?? '') ?: $Other_Actions = '';
                                    foreach($Other_Actions as $Other_Action)
                                    {
                                        $Sub_Action = '';
                                        $Sub_Action_Value = '';
                                        [$Sub_Action, $Sub_Action_Value] = (explode('=', $Other_Action, 2) ?? '') ?: ($Sub_Action = False)($Sub_Action_Value = False);
                                        if(isset($Sub_Action) === True and empty($Sub_Action) === False and is_string($Sub_Action) === True and isset($Sub_Action_Value) === True and empty($Sub_Action_Value) === False and is_string($Sub_Action_Value) === True and isset($Sub_Action_Value[60]) === False)
                                        {# Validates and adds the sub script depth to the control flow database
                                            $is_valid_entry = true;
                                            $Control_Flow_Database[$Positive_X][$Current_Action][] = [$Sub_Action => $Sub_Action_Value];
                                            $Sub_Action = '';
                                            $Sub_Action_Value = '';
                                        }
                                    }
                                    if($is_valid_entry === True)
                                    {# Add array key index only if everything was valid.
                                        $Positive_X++;
                                    }
                                    $Current_Action = '';
                                    $Other_Actions = '';
                                    $Sub_Script_Depth = 0;
                                }
                            }
                            $Positive_X = 0;
                            unset($Positive_X);
                            $Load_Token_Database = [];
                            unset($Load_Token_Database);
                            if(empty($Control_Flow_Database) === False and is_array($Control_Flow_Database) === True)
                            {
                                $OK_Status = $Control_Flow_Database;
                                $Control_Flow_Database = [];
                            }
                            unset($Control_Flow_Database);
                        }
                    }else
                    {
                        echo PHP_EOL.' [ ! ] ( CF_LOAD_CONFIG )                   Failed verifying the configuration file.';
                        exit;
                    }
                }else
                {
                    echo ' [ ! ] ( CF_LOAD_CONFIG )                   Empty configuration file.';
                }
            }else
            {
                echo ' [ ! ] ( CF_LOAD_CONFIG )                   Configuration already loaded.';
            }
            if(is_array($OK_Status) === True)
            {
                return $OK_Status;
            }else
            {
                return False;
            }
        }
        //</editor-fold>
        //<editor-fold desc="Terminate">
        /**
         * Spell caller.<br>
         * @var bool This bool is used to stop the script execution on control flow validation error.
         */
        Private Bool $Execution_Expelliarmus = False
            {
                get
                {
                    $trampoline = $this->Execution_Expelliarmus;
                    $trampoline = null;
                    unset($trampoline);
                    return False;
                }
                set(Bool $Expelliarmus)
                {
                    echo 'SS';
                    $this->Execution_Expelliarmus = True;
                    exit;
                }
            }
        //</editor-fold>
        //<editor-fold desc="Private Hooked Class Objects [v3]">
        //<editor-fold desc="Private fail-safe indicators [v1]">
        Private ReadOnly Bool $is_Data;
        //</editor-fold>
        /**
         * @var Object
         * This is the <b>iZiTA::Data</b> class object.<br>
         * It will be used to access the shared functions inside the class.
         */
        Private Object $Data
            {
                get
                {
                    return $this->Data;
                }
                set(Object $Data_Object)
                {
                    if(isset($this->is_Data) === False and empty($this->Data) === True and isset($Data_Object) === True and ($Data_Object instanceof Data) === True)
                    {
                        $Data_Object = null;
                        unset($Data_Object);
                        $this->Data = new Data();
                    }
                }
            }
        //</editor-fold>
        //<editor-fold desc="Shared ReadOnly Structure Identifier Variables [v1]">
        /**
         * @var bool The value specifies if the database loaded successfully.
         */
        Final ReadOnly Bool $is_configuration_loaded;
        //</editor-fold>
        //<editor-fold desc="Private Structure Execution Controller Variables [v1]">
        Private Bool $Current_Script_Set = False;
        /**
         * [ P ] Disables write access to the Execution Tokens.<br>
         * When the boolean is True shared functions won't execute writes to the specified internal objects/variables/functions.
         */
        Private Bool $is_Execution_Tokens_Writable = True;
        /**
         * [ P ] Disables access to the Execution Guard function for shared classes.
         */
        Private Bool $OK_Access_Execution_Guard = False;
        /**
         * @var bool This variable is set to True when the execution of the selected variable is completed from inside the variable.
         */
        Private Bool $Shadow_Execution_Token_OK_Status = False;
        /**
         * @var bool When this is set to True it returns the status (isset, empty, strlen, etc.) of the selected variable bypassing the getter code execution like emptying the variable on read.
         */
        Private Bool $Shadow_Execution_Token_Bypass_Return = False;
        Private Bool $Execution_Token_OK_Status = False;
        /**
         * @var bool When this is set to True call to Execution Token bypass the validation and return check.
         */
        Private Bool $Execution_Token_Bypass_Return = False;
        //</editor-fold>
        //<editor-fold desc="Control Flow: Private Shadow Hooked Variables">
        /**
         * Execution_Guard with this verifies that you don't use future points to execute.<br>
         * This is a Guard protection that enroll the next array points dynamically on execution for the <i>$Shadow_Control_Flow_Database</i>.
         * @var array
         */
        Private array $Shadow_Enroll_Guard = []
            {
                get
                {
                    echo PHP_EOL.' [ + ] ( Shadow_Enroll_Guard )              Called Shadow Enroll Guard';
                    if(isset($this->Shadow_Enroll_Guard[0][0][1]['00101']) === True)
                    {
                        $this->Execution_Expelliarmus = True;
                    }
                    # Get Script Access Details
                    $Script_Depth = ($this->Script_Depth ?? 0);
                    $Current_Script_Access = ($this->Current_Script_Access ?? '');
                    $Sub_Script_Depth = ($this->Sub_Script_Depth ?? 0);
                    # / Get Script Access Details
                    if(isset($this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth]) === True)
                    {# This array index exists.
                        if(isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth]) === False and isset($this->Shadow_Enroll_Guard[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth]) === False)
                        {# This array index for Shadow_Control_Flow and Shadow_Enroll_Guard should not exist.
                            $Control_Flow_Database = $this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth];
                            $Shadow_Next_Array_Index = (key($Control_Flow_Database) ?? '') ?: '';
                            $Shadow_Next_Array_Key = (current($Control_Flow_Database) ?? '') ?: '';
                            if($Sub_Script_Depth > 0)
                            {
                                if(isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth - 1]) === True and isset($this->Shadow_Enroll_Guard[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth - 1]) === True and isset($this->Shadow_Enroll_Guard[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth][$Shadow_Next_Array_Index][$Shadow_Next_Array_Key]) === False)
                                {# The Shadow_Control_Flow_Database index in pos - 1 from this one should exist
                                    $Out_Of_Bounds = False;
                                    if($Sub_Script_Depth - 2 > 0)
                                    {# Scan the array to verify that tokes exist before enrolling next shadow array index
                                        $Shadow_Control_Flow_Database = $this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access];
                                        $Shadow_Control_Flow_Database = '#'.$this->Data->Array_To_String($Shadow_Control_Flow_Database, '#') ?: $Shadow_Control_Flow_Database = '';
                                        $is_Token = 0;
                                        $is_Depth = 0;
                                        $Dagger = substr_count($Shadow_Control_Flow_Database, '#');
                                        while(true)
                                        {
                                            $is_Depth += 1;
                                            if($is_Depth > $Sub_Script_Depth -1)
                                            {
                                                break;
                                            }
                                            $is_Token += 4;
                                            if($is_Token > $Dagger)
                                            {
                                                echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Error: Script Depth Scanning out of bound access.';
                                                break;
                                            }
                                            if(strlen(explode('#', $Shadow_Control_Flow_Database)[$is_Token]) !== 64)
                                            {
                                                $Out_Of_Bounds = True;
                                                break;
                                            }
                                        }
                                    }
                                    if($Out_Of_Bounds === False)
                                    {
                                        $Set_Shadow_Control_Flow_Database = [];
                                        $Set_Shadow_Control_Flow_Database = ($this->Shadow_Control_Flow_Database ?? []);
                                        $Set_Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth][$Shadow_Next_Array_Index][$Shadow_Next_Array_Key] = '';
                                        $this->Shadow_Control_Flow_Database = $Set_Shadow_Control_Flow_Database;
                                        if($this->Shadow_Control_Flow_Database === $Set_Shadow_Control_Flow_Database)
                                        {# Set the array out of order.
                                            $this->Shadow_Enroll_Guard[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth][$Shadow_Next_Array_Index][$Shadow_Next_Array_Key] = '';
                                        }else
                                        {#
                                            echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Critical: Error enrolling Shadow Control Flow.';
                                        }
                                        $Set_Shadow_Control_Flow_Database = [];
                                        unset($Set_Shadow_Control_Flow_Database);
                                    }else
                                    {# Error: Out of bound database execution.
                                        echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Critical: Error with Shadow Control Flow. Executions have been bypassed.';
                                    }
                                }else
                                {# Previous line does not exist.
                                    echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Previous line does not exist.';
                                }
                            }elseif($Sub_Script_Depth === 0)
                            {# We are at the beginning of a script depth.
                                echo PHP_EOL.' [ + ] ( Shadow_Enroll_Guard )              Setting line for the begin of a script depth.';
                                $Set_Shadow_Control_Flow_Database = $this->Shadow_Control_Flow_Database;
                                $Set_Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth][$Shadow_Next_Array_Index][$Shadow_Next_Array_Key] = '';
                                $this->Shadow_Control_Flow_Database = $Set_Shadow_Control_Flow_Database;
                                if($this->Shadow_Control_Flow_Database === $Set_Shadow_Control_Flow_Database)
                                {# Set the array out of order.
                                    $this->Shadow_Enroll_Guard[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth][$Shadow_Next_Array_Index][$Shadow_Next_Array_Key] = '';
                                }else
                                {#
                                    echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Critical: Error enrolling Shadow Control Flow.';
                                }
                            }
                        }else
                        {
                            echo PHP_EOL.' [ !! ] ( Shadow_Enroll_Guard )             Critical: The database is out of order.'.PHP_EOL;
                        }
                    }else
                    {
                        echo PHP_EOL.' [ !! ] ( Shadow_Enroll_Guard )             Error enrolling next control flow in: '.$Script_Depth.' : '.$Current_Script_Access.' : '.$Sub_Script_Depth;
                    }
                    return [''];
                }
                set(array $value)
                {
                    $this->Shadow_Enroll_Guard[0][0][1] = '00101';
                }
            }
        /**
         * Execution_Guard with this verifies that script do not use the same used tokens.
         * @var array
         */
        Private array $Shadow_Control_Flow_Tokens = []
            {
                get
                {
                    return $this->Shadow_Control_Flow_Tokens;
                }
                set(array $value)
                {
                    if(isset($this->Shadow_Control_Flow_Tokens[';']) === False)
                    {
                        $this->Shadow_Control_Flow_Tokens[';'] = '';
                        $Set_Shadow_Control_Flow_Token = (array_key_last($value) ?? []) ?: $Set_Shadow_Control_Flow_Token = [];
                        $Shadow_Control_Flow_Tokens = $this->Shadow_Control_Flow_Tokens;
                        unset($Shadow_Control_Flow_Tokens[';']);
                        $Shadow_Control_Flow_Tokens[$Set_Shadow_Control_Flow_Token] = '';
                        if($Shadow_Control_Flow_Tokens === $value and strlen($Set_Shadow_Control_Flow_Token) === 64)
                        {
                            if(isset($this->Shadow_Control_Flow_Tokens[';']) === True)
                            {
                                echo PHP_EOL.' [ + ] ( Shadow_Control_Flow_Tokens )       TOKEN ENROLLED: '.$Set_Shadow_Control_Flow_Token;
                                unset($this->Shadow_Control_Flow_Tokens[';']);
                                $this->Shadow_Control_Flow_Tokens[] = $Set_Shadow_Control_Flow_Token;
                            }
                        }else
                        {
                            unset($this->Shadow_Control_Flow_Tokens[';']);
                            echo PHP_EOL.' [ ! ] ( Shadow_Control_Flow_Tokens )       Error writing tokens.';
                        }
                    }else
                    {
                        echo PHP_EOL.' [ ! ] ( Shadow_Control_Flow_Tokens )       Error writing: In Use.';
                    }
                }
            }
        /**
         * Execution_Guard with this verifies that you are not in another used flow point.
         * @var array
         */
        Private array $Shadow_Control_Flow_Database = []
            {
                get
                {
                    return $this->Shadow_Control_Flow_Database;
                }
                set(array $value)
                {# Can find the location verify it and set.
                    if(empty($value) === False)
                    {
                        $Set_Shadow_Control_Flow_Database = $this->Data->Array_To_String($value, '#');
                        $Shadow_Control_Flow_Database = $this->Data->Array_To_String($this->Shadow_Control_Flow_Database, '#');
                        $Shadow_Previous_Array_Value = '0';
                        $Shadow_Previous_Array_Index = '0';
                        $Current_Script_Access = $this->Current_Script_Access;
                        if(empty($this->Shadow_Control_Flow_Database) === False)
                        {
                            $Script_Depth = $this->Script_Depth;
                            $Sub_Script_Depth = $this->Sub_Script_Depth;
                            if(isset($this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth - 1]) === True and isset($this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth]) === True)
                            {# Setting value ^ | Already exists ^
                                $Control_Flow_Database = $this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth - 1];
                                $Shadow_Previous_Array_Key = key($Control_Flow_Database);
                                $Shadow_Previous_Array_Value = current($Control_Flow_Database);
                                $Shadow_Previous_Array_Index = $this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$Sub_Script_Depth - 1][$Shadow_Previous_Array_Key][$Shadow_Previous_Array_Value];
                            }
                        }
                        if($Shadow_Control_Flow_Database != $Set_Shadow_Control_Flow_Database and str_contains($Set_Shadow_Control_Flow_Database, $Shadow_Control_Flow_Database) === True)
                        {# Write the used token value.
                            $Separators = substr_count($Set_Shadow_Control_Flow_Database, '#');
                            if($Separators > 3)
                            {
                                $Sub_Index_OK_Message = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators];
                                $minus_val = 0;
                                if(strlen($Sub_Index_OK_Message) === 64)
                                {
                                    if($Separators > 4)
                                    {
                                        $minus_val = 1;
                                    }
                                }
                                $Sub_Index_OK_Message = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - $minus_val];
                                $minus_val += 1;
                                $Sub_Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - $minus_val];
                                $minus_val += 1;
                                $Index_Sub_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - $minus_val];
                                $minus_val += 1;
                                $Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - $minus_val];
                                $minus_val += 1;
                                $Control_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - $minus_val];
                                if(isset($value[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === True and isset($this->Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier]) === True and $this->Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier] === $Sub_Index_OK_Message)
                                {
                                    $OK_Message_Status = $value[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message];
                                    if(is_string($OK_Message_Status) === True and $OK_Message_Status === '' and isset($this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === False)
                                    {# Create the next exec
                                        $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] = $OK_Message_Status;
                                        echo PHP_EOL.' [ + ] ( Shadow_Control_Flow_Database )     Added:         { '.$Control_Index.' '.$Index_Identifier.' '.$Index_Sub_Index.' '.$Sub_Index_Identifier.' '.$Sub_Index_OK_Message.' } to the database.';
                                    }elseif(is_string($OK_Message_Status) === True and strlen($OK_Message_Status) === 64 and isset($this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === True and $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] === '')
                                    {# Add the token to the database
                                        $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] = $OK_Message_Status;
                                        echo PHP_EOL.' [ + ] ( Shadow_Control_Flow_Database )     Added to:      { '.$Control_Index.' '.$Index_Identifier.' '.$Index_Sub_Index.' '.$Sub_Index_Identifier.' '.$Sub_Index_OK_Message.' } this: '.$OK_Message_Status;
                                    }else
                                    {# Failed to enrol into the Database
                                        echo PHP_EOL.' [ ! ] ( Shadow_Control_Flow_Database )     Array not written. Verification message error.';
                                    }
                                }else
                                {
                                    echo PHP_EOL.' [ !! ] ( Shadow_Control_Flow_Database )    Error writing access path. This access path does not exist.';
                                }
                            }
                        }elseif($Shadow_Previous_Array_Index === '')
                        {# Backwards write the used token value.
                            $Separators = substr_count($Set_Shadow_Control_Flow_Database, '#');
                            if($Separators > 10)
                            {
                                $Sub_Index_OK_Message = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators];
                                if(strlen($Sub_Index_OK_Message) === 64)
                                {
                                    $Sub_Index_OK_Message = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 1];
                                    $Sub_Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 2];
                                    $Index_Sub_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 3];
                                    $Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 4];
                                    $Control_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 5];
                                    if(isset($value[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === True and isset($this->Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier]) === True and $this->Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier] === $Sub_Index_OK_Message)
                                    {
                                        $OK_Message_Status = $value[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message];
                                        if(is_string($OK_Message_Status) === True and strlen($OK_Message_Status) === 64 and isset($this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === True and $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] === $OK_Message_Status)
                                        {
                                            $OK_Message_Status = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 6];
                                            $Sub_Index_OK_Message = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 7];
                                            $Sub_Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 8];
                                            $Index_Sub_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 9];
                                            $Index_Identifier = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 10];
                                            $Control_Index = explode('#', $Set_Shadow_Control_Flow_Database)[$Separators - 11];
                                            if(strlen($OK_Message_Status) === 64 and isset($this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message]) === True and $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] === '')
                                            {
                                                echo PHP_EOL.' [ + ] ( Shadow_Control_Flow_Database )     Added to prev: { '.$Control_Index.' '.$Index_Identifier.' '.$Index_Sub_Index.' '.$Sub_Index_Identifier.' '.$Sub_Index_OK_Message.' } this: '.$OK_Message_Status;
                                                $this->Shadow_Control_Flow_Database[$Control_Index][$Index_Identifier][$Index_Sub_Index][$Sub_Index_Identifier][$Sub_Index_OK_Message] = $OK_Message_Status;
                                            }
                                        }
                                    }
                                }else
                                {
                                    echo PHP_EOL.' [ ! ] ( Shadow_Enroll_Guard )              Failed to write backwards in Shadow_Control_Flow_Database.';
                                }
                            }
                        }else
                        {
                            echo PHP_EOL.' [ !! ] ( Shadow_Enroll_Guard )             Failed to write Shadow_Control_Flow_Database: '.$Set_Shadow_Control_Flow_Database;
                        }
                    }
                }
            }
        /**
         * @var string value is a verification execution token to be used for action validation.<br>
         * Notice: The value is emptied after being read twice and can't be written while not empty.
         */
        Private String $Shadow_Execution_Token = ''
            {
                get
                {
                    if($this->Shadow_Execution_Token_Bypass_Return === True)
                    {# Bypasses the execution of get.
                        echo PHP_EOL.' [ N ] ( Shadow_Execution_Token )           Notice: Return bypass.';
                        $this->Shadow_Execution_Token_Bypass_Return = False;
                        if(empty($this->Shadow_Execution_Token) === False)
                        {# Fixes empty, strlen checks etc.
                            return 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                        }else
                        {
                            return '';
                        }
                    }
                    $trampoline = $this->Shadow_Execution_Token;
                    if(str_contains($trampoline, ':') === True)
                    {
                        echo PHP_EOL.' [ P ] ( Shadow_Execution_Token )           Returned token { '.$trampoline.' } and emptied.';
                        $this->Shadow_Execution_Token = '';
                        $this->Shadow_Execution_Token_OK_Status = True;
                        return explode(':', $trampoline)[0];
                    }else
                    {
                        echo PHP_EOL.' [ P ] ( Shadow_Execution_Token )           Returned token { '.$trampoline.' }.';
                        if(empty($this->Shadow_Execution_Token) === False)
                        {
                            $this->Shadow_Execution_Token = $trampoline.':';
                        }
                        $this->Shadow_Execution_Token_OK_Status = True;
                        return $trampoline;
                    }
                }
                set(String $SET_Value)
                {
                    $this->Shadow_Execution_Token_OK_Status = False;
                    if(empty($this->Shadow_Execution_Token) === True and isset($SET_Value) === True and is_string($SET_Value) === True and strlen($SET_Value) === 64 and str_contains($SET_Value, ':') === False)
                    {
                        echo PHP_EOL.' [ + ] ( Shadow_Execution_Token )           Wrote Shadow Execution Token { '.$SET_Value.' }.';
                        $this->Shadow_Execution_Token_OK_Status = True;
                        $this->Shadow_Execution_Token = $SET_Value;
                    }else
                    {
                        if(empty($this->Shadow_Execution_Token) === False)
                        {
                            echo PHP_EOL.' [ - ] ( Shadow_Execution_Token )           Failed at writing to Shadow Execution Token: Not empty.';
                        }else
                        {
                            echo PHP_EOL.' [ - ] ( Shadow_Execution_Token )           Failed at writing to Shadow Execution Token.';
                        }
                    }
                }
            }
        //</editor-fold>
        //<editor-fold desc="Control Flow: Private ReadOnly Variables">
        /**
         * This array defines the allowed control flow of the data that get checked.<br>
         * This is a <b>set once</b> array.
         */
        Private ReadOnly array $Control_Flow_Database;
        //</editor-fold>
        //<editor-fold desc="Control Flow: Private Hooked Variables">
        /**
         * @var int The current depth inside the script.<br>
         * The result is in what function you are in from the ones checked.
         */
        Private Int $Script_Depth = 0
            {
                get
                {
                    return $this->Script_Depth;
                }
                set(Int $value)
                {
                    $is_depth = $this->Script_Depth + 1;
                    if($is_depth === $value)
                    {# Allow only +1 values
                        $Current_Script_Access = ($this->Current_Script_Access ?? '');
                        $is_Sub_Script_Depth = ($this->Sub_Script_Depth ?? 0);
                        if(isset($this->Control_Flow_Database[$is_depth]) === True and isset($this->Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth]) === True and isset($this->Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth + 1]) === False and isset($this->Shadow_Control_Flow_Database[$is_depth]) === False and isset($this->Shadow_Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth]) === True and isset($this->Shadow_Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth + 1]) === False)
                        {# Checks before adding: next depth exist, if no next place exist, is at last depth.
                            $Shadow_Data = $this->Shadow_Control_Flow_Database;
                            $Enrol_Next_Depth = False;
                            $Shadow_Corruption_Status = 0;
                            if(is_array($Shadow_Data) === True and empty($Shadow_Data) === False)
                            {
                                $is_Shadow_Data = ($this->Data->Array_To_String($Shadow_Data, '#') ?? '');
                                $z = 0;
                                if(str_contains($is_Shadow_Data, '#') === True)
                                {
                                    $Enrol_Next_Depth = True;
                                    $z = substr_count($is_Shadow_Data,'#');
                                    $is_Shadow_Data = explode('#', $is_Shadow_Data);
                                }
                                for($x = 5; $x <= $z; $x += 6)
                                {# Validate all the Shadow_Control_Flow_Database
                                    $Shadow_Corruption_Status++;
                                    if(isset($is_Shadow_Data[$x]) === False or strlen($is_Shadow_Data[$x]) !== 64)
                                    {
                                        $Enrol_Next_Depth = False;
                                        break;
                                    }
                                }
                            }
                            if($Enrol_Next_Depth === True)
                            {
                                if($this->Script_Depth < 9999)
                                {
                                    echo PHP_EOL.' [ + ] ( Script_Depth )                     Adding +1 to Script Depth.';
                                    $this->Script_Depth += 1;
                                }else
                                {
                                    echo PHP_EOL.' [ ! ] ( Script_Depth )                     The Script_Depth have exceeded the allowed execution limit.';
                                    $this->Execution_Expelliarmus = True;
                                }
                            }else
                            {
                                echo PHP_EOL.' [ ! ] ( Script_Depth )                     Corruption at sub script depth. Script bypassed without verification at length: '.$Shadow_Corruption_Status;
                                $this->Execution_Expelliarmus = True;
                            }
                        }else
                        {
                            echo PHP_EOL.' [ ! ] ( Script_Depth )                     Script depth can\'t be changed. Depth: '.$is_depth.'->'.$is_Sub_Script_Depth;
                        }
                    }else
                    {
                        echo PHP_EOL.' [ ! ] ( Script_Depth )                     Script depth can\'t be changed. Depth: '.$is_depth;
                    }
                }
            }
        /**
         * @var int The current depth (sub script depth) inside a script depth.<br>
         * The result is where inside an execution of a function the script is, in what sub execution (only the calls that validates).
         */
        Private Int $Sub_Script_Depth = 0
            {
                get
                {
                    return $this->Sub_Script_Depth;
                }
                set(Int $value)
                {
                    $Script_Depth = ($this->Script_Depth ?? 0);
                    $is_Sub_Script_Depth = $this->Sub_Script_Depth + 1;
                    $Current_Script_Access = ($this->Current_Script_Access ?? '');
                    if($value === 0)
                    {# Set up the next Script_Depth.
                        $Script_Depth_Minus = 0;
                        $Sub_Depth_Start = $is_Sub_Script_Depth;
                        if($Script_Depth > 0)
                        {
                            $Script_Depth_Minus = $Script_Depth - 1;
                        }elseif ($Script_Depth === 0)
                        {
                            $Sub_Depth_Start = 'fail';
                        }
                        $Old_Script_Access = $this->Control_Flow_Database[$Script_Depth_Minus];
                        $Old_Script_Access = ($this->Data->Array_To_String($Old_Script_Access, '#') ?? '');
                        $Old_Script_Access = (explode('#', $Old_Script_Access)[0] ?? '');
                        /*
                         * If on the previous script depth on Control and Shadow Flow Databases no more sub script depth exist
                         * and on current Shadow the first script depth does not exist THEN PROCEED
                         * [!] Else the script depth will be out of order and execution will stop.
                         */
                        if(isset($this->Control_Flow_Database[$Script_Depth_Minus][$Old_Script_Access]) === True and isset($this->Control_Flow_Database[$Script_Depth_Minus][$Old_Script_Access][$Sub_Depth_Start]) === False and isset($this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][0]) === True and isset($this->Shadow_Control_Flow_Database[$Script_Depth_Minus][$Old_Script_Access][$this->Sub_Script_Depth+1]) === False and isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][0]) === False and isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$this->Sub_Script_Depth+1]) === False)
                        {
                            echo PHP_EOL.' [ + ] ( Sub_Script_Depth )                 Changing Script Depth to the begin of a script depth.';
                            $this->Sub_Script_Depth = 0;
                            $tmp_void = ($this->Shadow_Enroll_Guard ?? False) ?: False;
                            if(is_array($tmp_void) === False)
                            {
                                echo PHP_EOL.' [ ! ] ( Sub_Script_Depth )                 Failed enrolling guard.';
                            }
                            $tmp_void = null;
                            unset($tmp_void);
                        }else
                        {
                            echo PHP_EOL.' [ ! ] ( Sub_Script_Depth )                 Exiting: Out of bounds. [ ' . $this->Script_Depth.':' . $this->Sub_Script_Depth . ' ]';
                            $this->Execution_Expelliarmus = True;
                        }
                    }elseif($is_Sub_Script_Depth === $value)
                    {# Set up the next Sub_Script_Depth
                        if(isset($this->Control_Flow_Database[$Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth]) === True and isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth]) === False and isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth-1]) === True)
                        {# If next Sub_Script_Depth that is to be enrolled is in readonly Control_Flow_Database database and isn't in Shadow_Control_Flow_Database and on Shadow the current one exist
                            $is_to_Enroll = False;
                            if(isset($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth - 2]) === True)
                            {# [$is_Sub_Script_Depth - 2]
                                $Get_ = $this->Data->Array_To_String($this->Shadow_Control_Flow_Database[$Script_Depth][$Current_Script_Access][$is_Sub_Script_Depth - 2], '#');
                                if(substr_count($Get_, '#') === 2 and strlen(explode('#', $Get_)[2]) === 64)
                                {
                                    $is_to_Enroll = True;
                                }
                            }else
                            {
                                $is_to_Enroll = True;
                            }
                            if($is_to_Enroll === True)
                            {
                                if($this->Sub_Script_Depth < 9999)
                                {
                                    echo PHP_EOL.' [ + ] ( Sub_Script_Depth )                 Adding +1 to Sub_Script_Depth.';
                                    $this->Sub_Script_Depth += 1;
                                    $tmp_void = ($this->Shadow_Enroll_Guard ?? False) ?: False;
                                }else
                                {
                                    echo PHP_EOL.' [ ! ] ( Sub_Script_Depth )                 The Sub_Script_Depth have exceeded the allowed execution limit.';
                                }
                            }else
                            {
                                echo PHP_EOL.' [ !! ] ( Sub_Script_Depth )                The Sub_Script_Depth isn\'t to be enrolled my b.';
                            }
                        }else
                        {
                            echo PHP_EOL.' [ ! ] ( Sub_Script_Depth )                 Not setting value.';
                        }
                    }else
                    {
                        echo PHP_EOL.' [ !! ] ( Sub_Script_Depth )                Illegal value set.';
                    }
                }
            }
        /**
         * @var string The execution token to be used for execution verification.<br>
         * / This execution token verifies the execution of actions. Example: Reading writing to Client variables, executing functions or actions inside functions.
         */
        Private String $Execution_Token = 'ac0e8e46f3fc327491d4a56ca3410b4e9f5d7294556ee38bc62e3d403b1fc5e4'#
            {
                get
                {
                    if(isset($this->Execution_Token_Bypass_Return) === True and $this->Execution_Token_Bypass_Return === True)
                    {
                        echo PHP_EOL.' [ N ] ( Execution_Token )                  Notice: Return bypass.';
                        $this->Execution_Token_Bypass_Return = False;
                        if(empty($this->Execution_Token) === False)
                        {# Fixes empty, strlen checks etc.
                            return 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                        }else
                        {
                            return '';
                        }
                    }
                    $this->Execution_Token_OK_Status = False;
                    $is_exec_token = $this->Execution_Token;
                    $is_bypassed = '';
                    $this->Shadow_Execution_Token_Bypass_Return = False;
                    $is_bypassed = ($this->Shadow_Execution_Token ?? False) ?: False;
                    $Current_Script_Access = ($this->Current_Script_Access ?? '') ?: '';
                    if($is_bypassed === $is_exec_token)
                    {# Tokens match.
                        $is_script_depth = ($this->Script_Depth ?? False) ?: False;
                        $is_sub_script_depth = ($this->Sub_Script_Depth ?? False) ?: False;
                        if(isset($this->Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth+1]['READ_EXECUTION_TOKEN']) === True and isset($this->Shadow_Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth+1]) === False)
                        {# Enrol the next sub script depth to read the Execution Token when needed.
                            $this->Sub_Script_Depth += 1;
                        }else
                        {
                            echo PHP_EOL.' --- Untrue';
                        }
                        $is_sub_script_depth = ($this->Sub_Script_Depth ?? False) ?: False;
                        if(isset($this->Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']) === True)
                        {
                            if(isset($this->Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth-1]['READ_EXECUTION_TOKEN']) === False)
                            {# If last command is read do not empty Shadow Token because it is needed to verify the action.
                                $tmp_void = $this->Shadow_Execution_Token;
                                $tmp_void = '';
                                unset($tmp_void);
                            }
                            $is_Shadow = '';
                            $is_Shadow = isset($this->Shadow_Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']['OK_READ_EXEC_TOKEN:']);
                            $is_Shadow_Text = $this->Shadow_Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']['OK_READ_EXEC_TOKEN:'] ?: $is_Shadow_Text = False;
                            if($is_Shadow === True and is_string($is_Shadow_Text) === True and empty($is_Shadow_Text) === True)
                            {# Set execution token for the action
                                $Set_Completed_Value = $this->Shadow_Control_Flow_Tokens;
                                $Set_Completed_Value[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']['OK_READ_EXEC_TOKEN:'] = $this->Execution_Token;
                                $this->Shadow_Control_Flow_Tokens = $Set_Completed_Value;
                            }
                            if(isset($this->Shadow_Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]) === True and isset($this->Shadow_Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth + 1]) === False)
                            {# Set token if previous execution flow exist and next doesn't
                                if(isset($this->Control_Flow_Database[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']) === True and $is_Shadow === True and empty($is_Shadow_Text) === True)
                                {# Write the execution token for this execution
                                    echo PHP_EOL.' [ + ] ( Execution_Token )                  Bypassed read : Script_Depth: '.$is_script_depth.' | Sub_Script_Depth: '.$is_sub_script_depth.' | Current Sub_Script_Depth: '.$this->Sub_Script_Depth;
                                    $Shadow_Clone = [];
                                    $Shadow_Clone = $this->Shadow_Control_Flow_Database;
                                    $Shadow_Clone[$is_script_depth][$Current_Script_Access][$is_sub_script_depth]['READ_EXECUTION_TOKEN']['OK_READ_EXEC_TOKEN:'] = $this->Execution_Token;
                                    $this->Shadow_Control_Flow_Database = $Shadow_Clone;
                                    if($this->Shadow_Control_Flow_Database !== $Shadow_Clone)
                                    {
                                        echo PHP_EOL.' [ ! ] ( Execution_Token )                  Critical: Failed to set the token on the shadow control flow database.';
                                    }
                                }else
                                {
                                    echo PHP_EOL.' [ ! ] ( Execution_Token )                  Execution token failed to set the token.';
                                }
                            }
                            $this->Execution_Token_OK_Status = True;
                            return $is_exec_token;
                        }else
                        {
                            echo PHP_EOL.' [ ! ] ( Execution_Token )                  Not bypassed. : '.$is_sub_script_depth.' : '.$this->Sub_Script_Depth;
                        }
                    }else
                    {
                        echo PHP_EOL.' [ ! ] ( Execution_Token )                  Not bypassed. Depth: [ '.$this->Sub_Script_Depth . ' ] Execution Token: [' . $is_exec_token .' ] Shadow Execution Token: '. $is_bypassed;
                    }
                    return '';
                }
                set(String $value)
                {
                    $this->Execution_Token_OK_Status = False;
                    $is_depth = 0;
                    $is_exec_token = $this->Execution_Token;
                    $Current_Script_Access = $this->Current_Script_Access;
                    if($Current_Script_Access === 'WRITE_EXECUTION_TOKEN')
                    {# Check if we are on Script_Depth or Sub_Script_Depth
                        $is_depth = $this->Script_Depth;
                        $this->Shadow_Execution_Token = $is_exec_token;
                        $this->Shadow_Execution_Token_OK_Status = False;
                    }else
                    {# Sub_Script_Depth level
                        $is_depth = $this->Sub_Script_Depth;
                    }
                    $is_successful = $this->Execution_Guard($is_exec_token, 'WRITE_EXECUTION_TOKEN');
                    $is_Shadow_Execution_Token = '';
                    $is_Shadow_Execution_Token = ($this->Shadow_Execution_Token ?? null) ?: ($is_Shadow_Execution_Token = '');
                    $has_Write_Failed = True;
                    if(empty($is_exec_token) === False and empty($is_Shadow_Execution_Token) === False and is_string($is_exec_token) === True and is_string($is_Shadow_Execution_Token) === True and strlen($is_exec_token) === 64 and strlen($is_Shadow_Execution_Token) === 64)
                    {
                        if($is_successful === 'OK_WRITE_EXEC_TOKEN:'.$is_exec_token.':'.$is_Shadow_Execution_Token)
                        {
                            if(strlen($this->Execution_Token) > 0)
                            {
                                if(isset($value) === True and is_string($value) === True and strlen($value) === 64)
                                {
                                    $has_Write_Failed = False;
                                    echo PHP_EOL.' [ + ] ( Execution_Token )                  Wrote execution token successfully: '.$value;
                                    $this->Execution_Token_OK_Status = True;
                                    $this->Execution_Token = $value;
                                }
                            }
                        }
                    }
                    if($has_Write_Failed === True)
                    {
                        echo PHP_EOL.' [ - ] ( Execution_Token )                  Failed to write execution token: '.$value;
                    }
                }
            }
        /**
         * @var string Is the current script action that the script performs.<br>
         */
        Private String $Current_Script_Access = 'NO_ACCESS'
            {
                get
                {
                    $trampoline = $this->Current_Script_Access;
                    if(str_contains($trampoline, ':') === True and substr_count($trampoline, ':') === 1 and isset(explode(':', $trampoline)[1]) === True and strlen($trampoline) < 75)
                    {
                        $Sub_Script_Depth = explode(':', $trampoline)[1];
                        if($Sub_Script_Depth < 99999999)
                        {
                            $Sub_Script_Depth = (int)$Sub_Script_Depth + 1;
                        }
                        $New_Script_Depth = explode(':', $trampoline)[0].':'.$Sub_Script_Depth;
                        if(!($trampoline === $New_Script_Depth) === True)
                        {
                            $this->Current_Script_Access = $New_Script_Depth;
                            return explode(':', $trampoline)[0];
                        }
                    }else
                    {
                        $this->Current_Script_Access = $trampoline.':1';
                        return $trampoline;
                    }
                    return $this->Current_Script_Access.':X';
                }
                set(String $value)
                {
                    if(str_contains($value, ':') === False)
                    {# Value can't contain special character.
                        $Current_Script_Access = (explode(':', $this->Current_Script_Access)[0] ?? '') ?: ($Current_Script_Access = $this->Current_Script_Access);
                        if(isset($this->Control_Flow_Database[$this->Script_Depth + 1][$value][0]) === True and isset($this->Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$this->Sub_Script_Depth + 1]) === False and isset($this->Shadow_Control_Flow_Database[$this->Script_Depth][$Current_Script_Access][$this->Sub_Script_Depth]) === True)
                        {# If special value found then proceed with updating status check. Do not change value if Control Flow Database is not at the end.
                            $Current_Script_Depth = $this->Script_Depth;
                            $this->Script_Depth += 1;
                            if($Current_Script_Depth += 1 === $this->Script_Depth)
                            {
                                $this->Current_Script_Access = $value;
                                $this->Sub_Script_Depth = 0;# Set this first to fix enrol.
                                if($this->Sub_Script_Depth === 0)
                                {
                                    echo PHP_EOL . ' [ + ] ( Current_Script_Access )            Current Script Access Set Done.';
                                    $this->Current_Script_Set = True;
                                }else
                                {
                                    $this->Current_Script_Set = False;
                                    echo ' [ ! ] ( Current_Script_Access )            Failed to set sub script depth to 0 killing program.';
                                    $this->Execution_Expelliarmus = True;
                                }
                            }else
                            {
                                echo ' [ ! ] ( Current_Script_Access )            Failed to change script depth ignoring further actions.';
                            }
                        }elseif(isset($this->Script_Depth) === True and isset($this->Sub_Script_Depth) === True and $this->Script_Depth === 0 and $this->Sub_Script_Depth === 0 and isset($this->Control_Flow_Database[0][$value][0]) === True and isset($this->Shadow_Control_Flow_Database[0][$value][0]) === False)
                        {# Set the beginning of the execution control flow
                            echo PHP_EOL . ' [ + ] ( Current_Script_Access )            Current Script Access Set Done.';
                            $this->Current_Script_Set = True;
                            $this->Current_Script_Access = $value;
                            $this->Sub_Script_Depth = 0;
                        }else
                        {
                            echo PHP_EOL . ' [ ! ] ( Current_Script_Access )            Could not set Current Script Access';
                        }
                    }
                }
            }
        //</editor-fold>
        //<editor-fold desc="Private Functions">
        //<editor-fold desc="Private Guard Functions">
        /**
         * * Details: Grands execution for specific script actions like
         * > Variable (Read, Write)<br>
         * > Other Code Execution
         * * Warning:
         * If the function isn't called in order or get called more times than expected,
         * then execution of the script will be terminated.<br>
         * @param String $Execution_Token Is a token that was sent to proceed with the execution.
         * @param String $Action Is the action that requested for execution access.
         * @return String It returns a validation message in the format: OK $Execution_Token $Validation_Token
         * this string validates the action if the control flow is correct.
         */
        Private Function Execution_Guard(String $Execution_Token, String $Action): String
        {
            echo PHP_EOL.' [ R ] ( Execution_Guard )                  Called Execution Guard.';
            $get_ScriptDepth = 0;
            $get_ScriptDepth = ($this->Script_Depth ?? 0) ?: 0;
            $get_Sub_Script_Depth = 0;
            $get_Sub_Script_Depth = ($this->Sub_Script_Depth ?? 0) ?: 0;
            $get_Current_Script_Access = 'None';
            $get_Current_Script_Access = ($this->Current_Script_Access ?? '') ?: '';
            $read_Master = [];
            $read_Master = ($this->Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth] ?? []) ?: $read_Master = [];
            if(empty($read_Master) === False and is_array($read_Master) === True)
            {# Check if the script depth is out of order.
                $Shadow_array_master_key = (key($read_Master) ?? '') ?: '';
                $Shadow_array_child_key = (current($read_Master) ?? '') ?: '';
                $Get_Shadow_Status = ($this->Shadow_Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Shadow_array_master_key][$Shadow_array_child_key] ?? '') ?: '';
                if(is_int($get_Sub_Script_Depth) === True and $get_Sub_Script_Depth != 0 and isset($this->Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth + 1][$Action]) === True and is_string($Get_Shadow_Status) === True and strlen($Get_Shadow_Status) === 64)
                {
                    echo PHP_EOL.' [ + ] ( Execution_Guard )                  Calling Sub Script Depth Add From Execution Guard to fix out of order.';
                    $this->Sub_Script_Depth += 1;
                    if($this->Sub_Script_Depth === $get_Sub_Script_Depth or $this->Sub_Script_Depth != $get_Sub_Script_Depth+1)
                    {
                        echo PHP_EOL.' [ !! ] ( Execution_Guard )                 Calling Sub Script Depth Add From Execution Guard failed.';
                        $this->Execution_Expelliarmus = True;
                    }
                    $get_Sub_Script_Depth = $this->Sub_Script_Depth;
                }
                $Shadow_array_master_key = '';
                $Shadow_array_child_key = '';
                $Get_Shadow_Status = '';
                unset($Shadow_array_master_key);
                unset($Shadow_array_child_key);
                unset($Get_Shadow_Status);
            }
            $read_Master = [];
            unset($read_Master);
            if(empty($Execution_Token) === False and strlen($Execution_Token) === 64 and $this->Execution_Token === $Execution_Token)
            {# Validate Execution
                if(isset($this->Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action]) === True and empty($this->Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action]) === False)
                {
                    $OK_MESSAGE = '';
                    $OK_MESSAGE = ($this->Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action] ?? '') ?: $OK_MESSAGE = '';
                    if(isset($OK_MESSAGE) === True and empty($OK_MESSAGE) === False and is_string($OK_MESSAGE) === True and isset($OK_MESSAGE[50]) === False and isset($this->Shadow_Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action][$OK_MESSAGE]) === True and empty($this->Shadow_Control_Flow_Database[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action][$OK_MESSAGE]) === True and isset($this->Shadow_Control_Flow_Tokens[$Execution_Token]) === False)
                    {
                        $temp_token = '';
                        $temp_token = $this->GenerateHash() ?: $temp_token = '';
                        $Shadow_Clone = [];
                        $Shadow_Clone = $this->Shadow_Control_Flow_Database;
                        $Shadow_Clone[$get_ScriptDepth][$get_Current_Script_Access][$get_Sub_Script_Depth][$Action][$OK_MESSAGE] = $temp_token;
                        $this->Shadow_Control_Flow_Database = $Shadow_Clone;
                        if($this->Shadow_Control_Flow_Database === $Shadow_Clone)
                        {
                            $Shadow_Clone = [];
                            unset($Shadow_Clone);
                            $this->Shadow_Execution_Token = $temp_token ?: $temp_token = 'Error.';
                            if($temp_token !== 'Error.')
                            {
                                $temp_token = '';
                                echo PHP_EOL.' [ + ] ( Execution_Guard )                  Execution OK.';
                                return $OK_MESSAGE.$Execution_Token.':'.$this->Shadow_Execution_Token;
                            }
                        }else
                        {
                            echo ' [ D ] ( Execution_Guard )                  Cast Expelliarmus.';
                            $this->Execution_Expelliarmus = True;
                        }
                    }else
                    {
                        echo PHP_EOL.' [ D ] ( Execution_Guard )                  Action';
                    }
                }else
                {
                    echo PHP_EOL.' [ D ] ( Execution_Guard )                  Killing execution for: '.$get_ScriptDepth.$get_Current_Script_Access.$get_Sub_Script_Depth.$Action.' : '.$this->Sub_Script_Depth;
                    $this->Execution_Expelliarmus = True;
                }
            }
            return '';
        }
        //</editor-fold>
        Private Function GenerateHash(): String
        {
            return (hash('sha3-256', rand(1000000,9999999).rand(1000000000,9999999999).rand(10000000000000,99999999999999).rand(1000000,9999999).rand(10000000000000,99999999999999).rand(1000000000,9999999999).rand(1000000,9999999)) ?: 'Error');
        }
        //</editor-fold>
        //<editor-fold desc="Shared Functions">
        //<editor-fold desc="Final Shared Getter Setter Functions">
        /**
         * Controls reads and write to the $Current_Script_Access variable.
         * @param String $Current_Access
         * @return String|bool
         */
        Final Function Current_Script_Access(String $Current_Access = ''): String|Bool
        {
            if(empty($Current_Access) === True)
            {
                $Get_Current_Script_Access = '';
                $Get_Current_Script_Access = ($this->Current_Script_Access ?? null) ?: ($Get_Current_Script_Access = False);
                if(is_string($Get_Current_Script_Access) === True)
                {
                    return $Get_Current_Script_Access;
                }else
                {
                    echo PHP_EOL.PHP_EOL.' [ Shared ] ( Current_Script_Access )        Warning: Failed to get Current Script Access';
                }
            }elseif(empty($Current_Access) === False)
            {
                $Current_Access_Length = strlen($Current_Access);
                if($Current_Access_Length > 5 and $Current_Access_Length < 65)
                {
                    $this->Current_Script_Set = False;
                    if($this->Current_Script_Access = $Current_Access)
                    {
                        if($this->Current_Script_Set === True)
                        {
                            return True;
                        }
                    }
                }else
                {
                    echo PHP_EOL.PHP_EOL.' [ Shared ] ( Current_Script_Access )        Critical: Failed to change Current Script Access Scope'.PHP_EOL.'Error: Scope String Length mismatch';
                }
            }
            return False;
        }
        Final Function Shadow_Control_Flow_Tokens(array $Shadow_Control_Flow_Tokens = []): array|Bool
        {
            if(empty($Shadow_Control_Flow_Tokens) === True)
            {
                $Get_Shadow_Control_Flow_Tokens = [];
                if(isset($this->Shadow_Control_Flow_Tokens) and empty($this->Shadow_Control_Flow_Tokens) === False)
                {
                    $Get_Shadow_Control_Flow_Tokens = ($this->Shadow_Control_Flow_Tokens ?? null) ?: ($Get_Shadow_Control_Flow_Tokens = False);
                    if(is_array($Get_Shadow_Control_Flow_Tokens) === True and $Get_Shadow_Control_Flow_Tokens === $this->Shadow_Control_Flow_Tokens)
                    {
                        return $Get_Shadow_Control_Flow_Tokens;
                    }
                }else
                {
                    return [];
                }
            }elseif(empty($Shadow_Control_Flow_Tokens) === False)
            {
                if(isset($this->Shadow_Control_Flow_Tokens) === True and $this->Shadow_Control_Flow_Tokens = $Shadow_Control_Flow_Tokens)
                {
                    if($this->Shadow_Control_Flow_Tokens === $Shadow_Control_Flow_Tokens)
                    {
                        return True;
                    }
                }
            }
            return False;
        }
        /**
         * Controls reads and write to the $Shadow_Execution_Token variable.
         * @param String $Execution_Token Sets the Execution_Token to the current value. Leave empty to get the current Shadow_Execution_Token.
         * @return String|bool Returns string with the $Shadow_Execution_Token, True on success or False on any failure.
         */
        Final Function Shadow_Execution_Token(String $Execution_Token = ''): String|Bool
        {
            if(empty($Execution_Token) === True)
            {
                echo PHP_EOL.' [ Shared ] ( Shadow_Execution_Token )      - Asked to get value.';
                $this->Shadow_Execution_Token_Bypass_Return = True;
                if(isset($this->Shadow_Execution_Token) === True)
                {
                    $Shadow_Exec_Token = '';
                    $Shadow_Exec_Token = $this->Shadow_Execution_Token ?: ($Shadow_Exec_Token = '');
                    if(is_string($Shadow_Exec_Token) === True and isset($this->Shadow_Execution_Token_OK_Status) === True and $this->Shadow_Execution_Token_OK_Status === True)
                    {
                        $this->Shadow_Execution_Token_OK_Status = False;
                        return $Shadow_Exec_Token;
                    }
                }
            }elseif(empty($Execution_Token) === False)
            {
                echo PHP_EOL.' [ Shared ] ( Shadow_Execution_Token )      - Asked to write value.';
                if(isset($this->is_Execution_Tokens_Writable) === True and $this->is_Execution_Tokens_Writable === True)
                {
                    $this->Shadow_Execution_Token_Bypass_Return = True;
                    if(isset($this->Shadow_Execution_Token) === True)
                    {
                        $this->Shadow_Execution_Token = $Execution_Token;
                        if(isset($this->Shadow_Execution_Token_OK_Status) === True and $this->Shadow_Execution_Token_OK_Status === True)
                        {
                            $this->Shadow_Execution_Token_OK_Status = False;
                            return True;
                        }
                    }
                }
            }
            return False;
        }
        /**
         * Controls reads and write to the $Execution_Token variable.
         * @param String $Execution_Token Sets the Execution_Token to the current value. Leave empty to get the current Execution_Token.
         * @return String|bool Returns string with the Execution_Token, True on success or False on any failure.
         */
        Final Function Execution_Token(String $Execution_Token = ''): String|Bool
        {
            if(empty($Execution_Token) === True)
            {
                echo PHP_EOL.' [ Shared ] ( Execution_Token )             - Asked to get value.';
                $this->Execution_Token_Bypass_Return = True;
                if(isset($this->Execution_Token) === True)
                {
                    $Execution_Token = '';
                    $Execution_Token = ($this->Execution_Token ?? null) ?: ($Execution_Token = '');
                    if(is_string($Execution_Token) === True and $this->Execution_Token_OK_Status === True)
                    {# Succeeded at reading the Execution_Token
                        $this->Execution_Token_OK_Status = False;
                        return $Execution_Token;
                    }
                }
            }elseif(empty($Execution_Token) === False)
            {
                echo PHP_EOL.' [ Shared ] ( Execution_Token )             - Asked to write value.';
                if(isset($this->is_Execution_Tokens_Writable) === True and $this->is_Execution_Tokens_Writable === True)
                {
                    $this->Execution_Token_Bypass_Return = True;
                    if(isset($this->Execution_Token) === True)
                    {
                        $this->Execution_Token = $Execution_Token;
                        if(isset($this->Execution_Token_OK_Status) === True and $this->Execution_Token_OK_Status === True)
                        {
                            $this->Execution_Token_OK_Status = False;
                            return True;
                        }
                    }
                }
            }
            return False;
        }
        //</editor-fold>
        //<editor-fold desc="Final Shared Getter Functions">
        /**
         * Returns the Shadow_Control_Flow_Database array or false on failure.
         * @return array|bool
         */
        Final Function Get_Shadow_Control_Flow_Database(): array|Bool
        {
            if(isset($this->Shadow_Control_Flow_Database) === True)
            {
                $Shadow_Control_Flow_Database = [];
                $Shadow_Control_Flow_Database = ($this->Shadow_Control_Flow_Database ?? []) ?: ($Shadow_Control_Flow_Database = []);
                if(is_array($Shadow_Control_Flow_Database) === True and $Shadow_Control_Flow_Database === $this->Shadow_Control_Flow_Database)
                {
                    return $Shadow_Control_Flow_Database;
                }
            }
            return False;
        }
        /**
         * Returns the Script Depth or false on failure.
         * @return Int|bool Returns the Script_Depth variable value or False on failure.
         */
        Final Function Get_Script_Depth(): Int|Bool
        {
                return ($this->Script_Depth ?? False);
        }
        //</editor-fold>
        //<editor-fold desc="Final Shared Functions">
        Final Function Call_Execution_Guard(String $Execution_Token, String $Action): String|Bool
        {
            if(isset($this->OK_Access_Execution_Guard) === True and $this->OK_Access_Execution_Guard === False)
            {
                $this->OK_Access_Execution_Guard = True;
                $Execution_Status = '';
                $Execution_Status = ($this->Execution_Guard($Execution_Token, $Action) ?? '') ?: $Execution_Status = '';
                $this->OK_Access_Execution_Guard = False;
                return $Execution_Status;
            }
            return False;
        }
        //</editor-fold>
        //</editor-fold>
    }
}

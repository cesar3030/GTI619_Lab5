<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configuration';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number_attempt_allowed','time_restriction', 'number_last_password_disallowed','password_time_life','password_min_length','password_lower_case_required','password_upper_case_required','password_special_characters_required','password_number_required'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];



    /**
     * Function that set the maximum number of attempts
     * @param $nbAttempts
     */
    public static function setNumberAttemptAllowed($nbAttempts){
        Configuration::where('id', 1)
            ->update(['number_attempt_allowed' => $nbAttempts]);
    }

    /**
     * Function that the time restriction in seconds before a new attempt after a too number of try
     * @param $nbSeconds
     */
    public static function setTimeRestriction($nbSeconds){
        Configuration::where('id', 1)
            ->update(['time_restriction' => $nbSeconds]);
    }

    /**
     * Function that disallow the user to use his x last passwords.
     * @param $nbPasswordDisallow
     */
    public static function setNumberLastPasswordDisallowed($nbPasswordDisallow){
        Configuration::where('id', 1)
            ->update(['number_last_password_disallowed' => $nbPasswordDisallow]);
    }


    /**
     * Function that set the number of days that a password can be use for login
     * @param $nbDays
     */
    public static function setPasswordTimeLife($nbDays){
        Configuration::where('id', 1)
            ->update(['password_time_life' => $nbDays]);
    }

    /**
     * Function that set the minimum length accepted for a password
     * @param $length
     */
    public static function setPasswordMinLength($length){
        Configuration::where('id', 1)
            ->update(['password_min_length' => $length]);
    }

    /**
     * Function that set if at least a lower case is required for a password
     * @param $isRequired  1 -> yes / 0 -> no
     */
    public static function setPasswordLowerCaseRequired($isRequired){
        Configuration::where('id', 1)
            ->update(['password_lower_case_required' => $isRequired]);
    }

    /**
     * Function that set if at least an upper case is required for a password
     * @param $isRequired  1 -> yes / 0 -> no
     */
    public static function setPasswordUpperCaseRequired($isRequired){
        Configuration::where('id', 1)
            ->update(['password_upper_case_required' => $isRequired]);
    }

    /**
     * Function that set if at least a special character is required for a password
     * @param $isRequired  1 -> yes / 0 -> no
     */
    public static function setPasswordSpecialCharactersRequired($isRequired){
        Configuration::where('id', 1)
            ->update(['password_special_characters_required' => $isRequired]);
    }

    /**
     * Function that set if at least a number is required for a password
     * @param $isRequired  1 -> yes / 0 -> no
     */
    public static function setPasswordNumberRequired($isRequired){
        Configuration::where('id', 1)
            ->update(['password_number_required' => $isRequired]);
    }

    /**
     * Function that set max times that an account can be blocked before to be desactivate
     * @param $nb
     */
    public static function setNumberMaxBlocked($nb){
        Configuration::where('id', 1)
            ->update(['nb_max_times_bloked' => $nb]);
    }


    /**
     * Function that return the regex that the password need match
     * @return the regex
     */
    public static function getPasswordCriteria(){
        $config = Configuration::where('id', 1)->first();

        $regex = "/^";

        if($config->password_lower_case_required == 1){
            $regex.="(?=.*[a-z])";
        }

        if($config->password_upper_case_required == 1){
            $regex.="(?=.*[A-Z])";
        }

        if($config->password_special_characters_required == 1){
            $regex.="(?=.*[!$#%*&])";
        }

        if($config->password_number_required == 1){
            $regex.="(?=.*[0-9])";
        }

        if($config->password_min_length > 6){
            $regex.=".{".$config->password_min_length.",}$";
        }
        else{
            $regex.=".{6,}$";
        }

        return $regex."/m";
    }






}

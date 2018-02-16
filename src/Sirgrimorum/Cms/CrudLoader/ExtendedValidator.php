<?php

namespace Sirgrimorum\Cms\CrudLoader;

use Illuminate\Validation\Validator;
use Sirgrimorum\Cms\CrudLoader\CrudGenerator;
use Illuminate\Support\Arr;

class ExtendedValidator extends Validator {

    // Laravel uses this convention to look for validation rules, this function will be triggered 
    // for composite_unique
    public function validateUniqueComposite($attribute, $value, $parameters) {
        $this->requireParameterCount(2, $parameters, 'unique_composite');

        $data = $this->getData();
        // remove first parameter and assume it is the table name
        $table = array_shift($parameters);

        // start building the conditions
        $fields = [ $attribute => $value]; // current field, the first in wich the rule is aplied
        // iterates over the other parameters and build the conditions for all the required fields
        while ($field = array_shift($parameters)) {
            $fields[$field] = Arr::get($data, $field);
        }

        // query the table with all the conditions
        $result = \DB::table($table)->select(\DB::raw(1))->where($fields)->first();

        return empty($result); // true if empty
    }

    public function replaceUniqueComposite($message, $attribute, $rule, $parameters){
        // remove first parameter and assume it is the table name
            $table = array_shift($parameters);
            $modeloM = ucfirst(substr($table, 0, strlen($table) - 1));

            $config = config(config("sirgrimorum_cms.admin_routes." . $modeloM));
            $config = CrudGenerator::translateConfig($config);
            if (array_has($config, "campos." . $attribute . ".label")) {
                $campos = '"' . array_get($config, "campos." . $attribute . ".label") . '"';
            } else {
                $campos = '"' . $attribute . '"';
            }
            $prefix = ", ";
            foreach ($parameters as $parameter) {
                if (array_has($config, "campos." . $parameter . ".label")) {
                    $campos.= $prefix . '"' . array_get($config, "campos." . $parameter . ".label") . '"';
                } else {
                    $campos.= $prefix . '"' . $parameter . '"';
                }
            }
            return str_replace(":fields", $campos, $message);
    }
    
}

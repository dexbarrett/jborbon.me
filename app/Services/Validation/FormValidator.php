<?php
namespace DexBarrett\Services\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

abstract class FormValidator
{
    protected $validator;
    protected $data = [];
    protected $rules = [];
    protected $errors = [];
    protected $friendlyNames = [];

    public function __construct(ValidatorFactory $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $data)
    {
        $this->data = $data;
        $validator = $this->validator->make($this->data, $this->rules);

        $this->setFriendlyLabels($validator);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;

    }

    public function errors()
    {
        return $this->errors;
    }

    protected function setFriendlyLabels(Validator $validator)
    {
        if (count($this->friendlyNames) > 0) {
            $validator->setAttributeNames($this->friendlyNames);
        }
    }
}
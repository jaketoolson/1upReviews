<?php

/**
 * Copyright 2017 Cloud Creativity Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace CloudCreativity\LaravelJsonApi\Validators;

use CloudCreativity\JsonApi\Contracts\Store\StoreInterface;
use CloudCreativity\JsonApi\Contracts\Validators\ValidatorErrorFactoryInterface;
use CloudCreativity\JsonApi\Validators\ValidatorFactory as BaseFactory;
use CloudCreativity\LaravelJsonApi\Contracts\Validators\ValidatorFactoryInterface;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class ValidatorFactory
 *
 * @package CloudCreativity\LaravelJsonApi
 */
class ValidatorFactory extends BaseFactory implements ValidatorFactoryInterface
{

    /**
     * @var ValidatorErrorFactoryInterface
     */
    protected $validationErrors;

    /**
     * @var Factory
     */
    private $validatorFactory;

    /**
     * ValidatorFactory constructor.
     *
     * @param ValidatorErrorFactoryInterface $validationErrors
     * @param StoreInterface $store
     * @param Factory $validatorFactory
     */
    public function __construct(
        ValidatorErrorFactoryInterface $validationErrors,
        StoreInterface $store,
        Factory $validatorFactory
    ) {
        parent::__construct($validationErrors, $store);
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @inheritdoc
     */
    public function attributes(
        array $rules,
        array $messages = [],
        array $customAttributes = [],
        callable $callback = null,
        callable $extractor = null
    ) {
        return new AttributesValidator(
            $this->validatorFactory,
            $this->validationErrors,
            $rules,
            $messages,
            $customAttributes,
            $callback,
            $extractor
        );
    }

    /**
     * @inheritdoc
     */
    public function queryParameters(
        array $rules,
        array $messages = [],
        array $customAttributes = [],
        callable $callback = null
    ) {
        return new QueryValidator(
            $this->validatorFactory,
            $this->validationErrors,
            $rules,
            $messages,
            $customAttributes,
            $callback
        );
    }

}

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

namespace CloudCreativity\JsonApi\Contracts\Store;

use CloudCreativity\JsonApi\Contracts\Object\ResourceIdentifierInterface;
use CloudCreativity\JsonApi\Contracts\Pagination\PageInterface;
use CloudCreativity\JsonApi\Exceptions\RecordNotFoundException;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;
use Traversable;

/**
 * Interface StoreInterface
 *
 * @package CloudCreativity\JsonApi
 */
interface StoreInterface
{

    /**
     * Is the supplied resource type valid?
     *
     * @param $resourceType
     * @return bool
     */
    public function isType($resourceType);

    /**
     * Query the store for records using the supplied parameters.
     *
     * @param $resourceType
     * @param EncodingParametersInterface $params
     * @return Traversable|array|PageInterface|object|null
     */
    public function query($resourceType, EncodingParametersInterface $params);

    /**
     * Does the record this resource identifier refers to exist?
     *
     * @param ResourceIdentifierInterface $identifier
     * @return bool
     */
    public function exists(ResourceIdentifierInterface $identifier);

    /**
     * @param ResourceIdentifierInterface $identifier
     * @return object|null
     *      the record, or null if it does not exist.
     */
    public function find(ResourceIdentifierInterface $identifier);

    /**
     * @param ResourceIdentifierInterface $identifier
     * @return object
     *      the record
     * @throws RecordNotFoundException
     *      if the record does not exist.
     */
    public function findRecord(ResourceIdentifierInterface $identifier);

}

<?php
/**
 * @copyright   Copyright (c) http://www.manadev.com
 * @license     http://www.manadev.com/license  Proprietary License
 */

namespace Manadev\ProductCollection\Facets\Swatch;

use Manadev\ProductCollection\Facets\Dropdown\BaseFacet;

class StandardFacet extends BaseFacet
{
    public function getType() {
        return 'swatch_standard';
    }
}

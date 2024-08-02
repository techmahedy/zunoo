<?php

namespace Mii;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Abstract base class for all Eloquent models in the Mii namespace.
 * 
 * This class extends the Laravel Eloquent Model to provide a base
 * implementation for all models used in the Mii application. It is
 * intended to be extended by concrete model classes specific to 
 * the application's domain. It does not add any new behavior or 
 * properties but establishes a common base for all Eloquent models.
 * 
 * @property-read int $id Unique identifier for the model
 * @property string $created_at Timestamp when the model was created
 * @property string $updated_at Timestamp when the model was last updated
 */
abstract class Model extends BaseModel
{
    // No additional methods or properties are added here as this
    // class serves as a base class for other models. Any common
    // functionality or properties should be defined in subclasses.

    // PHP 8.3 improvements:
    // - Use readonly properties if any model properties should be immutable
    // - Attributes can be used for automatic property definitions
}

<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_mm_user";
$def->class = "erLhcoreClassModelMattermostUser";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['lhc_user_id'] = new ezcPersistentObjectProperty();
$def->properties['lhc_user_id']->columnName   = 'lhc_user_id';
$def->properties['lhc_user_id']->propertyName = 'lhc_user_id';
$def->properties['lhc_user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['mm_user_id'] = new ezcPersistentObjectProperty();
$def->properties['mm_user_id']->columnName   = 'mm_user_id';
$def->properties['mm_user_id']->propertyName = 'mm_user_id';
$def->properties['mm_user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
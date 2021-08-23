<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_mm_setting";
$def->class = "erLhcoreClassModelMattermostSetting";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['dep_id'] = new ezcPersistentObjectProperty();
$def->properties['dep_id']->columnName   = 'dep_id';
$def->properties['dep_id']->propertyName = 'dep_id';
$def->properties['dep_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['active'] = new ezcPersistentObjectProperty();
$def->properties['active']->columnName   = 'active';
$def->properties['active']->propertyName = 'active';
$def->properties['active']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['settings'] = new ezcPersistentObjectProperty();
$def->properties['settings']->columnName   = 'settings';
$def->properties['settings']->propertyName = 'settings';
$def->properties['settings']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
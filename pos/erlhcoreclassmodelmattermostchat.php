<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_mm_chat";
$def->class = "erLhcoreClassModelMattermostChat";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['ctime'] = new ezcPersistentObjectProperty();
$def->properties['ctime']->columnName   = 'ctime';
$def->properties['ctime']->propertyName = 'ctime';
$def->properties['ctime']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['chat_id'] = new ezcPersistentObjectProperty();
$def->properties['chat_id']->columnName   = 'chat_id';
$def->properties['chat_id']->propertyName = 'chat_id';
$def->properties['chat_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['mm_ch_id'] = new ezcPersistentObjectProperty();
$def->properties['mm_ch_id']->columnName   = 'mm_ch_id';
$def->properties['mm_ch_id']->propertyName = 'mm_ch_id';
$def->properties['mm_ch_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
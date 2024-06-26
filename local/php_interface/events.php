<?php

/**
 * This file contains a full list of custom event handlers
 * Code the handlers need NOT be contained in this file.
 * It needs to be made relevant to the PSR-[0-4] structure, classes
 */

$eventManager = \Bitrix\Main\EventManager::getInstance();

/**
 * For new core of bitrix use
 *     $eventManager->addEventHandler( #module#, #handler#, [#namespace#, #function#]);
 *
 * For old core of bitrix use
 *     $eventManager->addEventHandlerCompatible( #module#, #handler#, [#namespace#, #function#]);
 */

//$eventManager->addEventHandlerCompatible( 'tasks', #handler#, [#namespace#, #function#]);
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ["\\Autolife\\Rest\\ListSynchronization", 'OnRestServiceBuildDescription']);
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ["\\Autolife\\Rest\\Timeman1CDevelopers", 'OnRestServiceBuildDescription']);
$eventManager->addEventHandlerCompatible('main', 'OnUserTypeBuildList', ["\\Autolife\\Crm\\UserFields\\MyCustomField", 'getUserTypeDescription']);


/* End of file. Do not past code after this line! */
unset($eventManager);
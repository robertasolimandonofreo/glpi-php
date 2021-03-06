<?php
/**
 -------------------------------------------------------------------------
 oauthimap plugin for GLPI
 Copyright (C) 2018-2020 by the oauthimap Development Team.
 -------------------------------------------------------------------------

 LICENSE

 This file is part of oauthimap.

 oauthimap is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 oauthimap is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with oauthimap. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');

$authorization = new PluginOauthimapAuthorization();
$application   = new PluginOauthimapApplication();

if (isset($_POST['id']) && isset($_POST['delete'])) {
   $authorization->check($_POST['id'], DELETE);
   $authorization->delete($_POST);

   Html::back();
} else if (isset($_POST['id']) && isset($_POST['update'])) {
   $authorization->check($_POST['id'], UPDATE);
   if ($authorization->update($_POST)
      && $application->getFromDB($authorization->fields[$application->getForeignKeyField()])) {
      Html::redirect($application->getLinkURL());
   }

   Html::back();
} else if (isset($_REQUEST['id']) && isset($_REQUEST['diagnose'])) {
   $authorization->check($_REQUEST['id'], READ);

   $authorization = new PluginOauthimapAuthorization();
   $application   = new PluginOauthimapApplication();

   Html::popHeader($application::getTypeName(Session::getPluralNumber()));
   $authorization->check($_REQUEST['id'], READ);

   $authorization->showDiagnosticForm($_POST);

   Html::popFooter();
} else if (isset($_GET['id'])) {
   $application = new PluginOauthimapApplication();
   $application->displayHeader();
   $authorization->display(
      [
         'id' => $_GET['id'],
      ]
   );
   Html::footer();
} else {
   Html::displayErrorAndDie('lost');
}

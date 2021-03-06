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

namespace GlpiPlugin\Oauthimap\Provider;

use GlpiPlugin\Oauthimap\Oauth\OwnerDetails;
use League\OAuth2\Client\Token\AccessToken;

interface ProviderInterface {

   /**
    * Return provider name.
    *
    * @return string
    */
   public static function getName(): string;

   /**
    * Return provider icon (Font-Awesome identifier).
    *
    * @return string
    */
   public static function getIcon(): string;

   /**
    * Return token owner details.
    *
    * @param AccessToken $token
    *
    * @return OwnerDetails|null
    */
   public function getOwnerDetails(AccessToken $token): ?OwnerDetails;

   /**
    * Returns default host for IMAP connection.
    *
    * @return string
    */
   public function getDefaultHost(): string;

   /**
    * Returns default port for IMAP connection.
    *
    * @return int|null
    */
   public function getDefaultPort(): ?int;

   /**
    * Returns default SSL flag ('SSL', 'TLS' or null) for IMAP connection.
    *
    * @return string|null
    */
   public function getDefaultSslFlag(): ?string;
}

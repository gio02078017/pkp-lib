<?php

/**
 * @file controllers/grid/settings/library/LibraryFileAdminGridDataProvider.inc.php
 *
 * Copyright (c) 2000-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FilesGridDataProvider
 * @ingroup controllers_grid_settings_library
 *
 * @brief The data provider for the admin library files grid.
 */


import('lib.pkp.classes.controllers.grid.CategoryGridDataProvider');

class LibraryFileAdminGridDataProvider extends CategoryGridDataProvider {

	/** the context for this library **/
	var $_context;

	/** whether or not this grid is editable **/
	var $_canEdit;

	/**
	 * Constructor
	 */
	function LibraryFileAdminGridDataProvider($canEdit) {
		$this->_canEdit = $canEdit;
		parent::CategoryGridDataProvider();
	}


	//
	// Getters and Setters
	//

	/**
	 * @copydoc GridDataProvider::getAuthorizationPolicy()
	 */
	function getAuthorizationPolicy($request, $args, $roleAssignments) {
		$this->_context = $request->getContext();
		import('lib.pkp.classes.security.authorization.PkpContextAccessPolicy');
		return new PkpContextAccessPolicy($request, $roleAssignments);
	}

	/**
	 * @copydoc GridDataProvider::getRequestArgs()
	 */
	function getRequestArgs() {
		return array('canEdit' => $this->getCanEdit());
	}

	/**
	 * get the current context
	 * @return $context Context
	 */
	function &getContext() {
		return $this->_context;
	}


	/**
	 * get whether or not this grid is editable (has actions).
	 * @return boolean $canEdit
	 */
	function getCanEdit() {
		return $this->_canEdit;
	}


	/**
	 * @copydoc CategoryGridHandler::getCategoryData()
	 */
	function getCategoryData(&$fileType, $filter = null) {

		// Elements to be displayed in the grid
		$libraryFileDao = DAORegistry::getDAO('LibraryFileDAO');
		$context = $this->getContext();
		$libraryFiles = $libraryFileDao->getByContextId($context->getId(), $fileType);

		return $libraryFiles->toAssociativeArray();
	}
}

?>

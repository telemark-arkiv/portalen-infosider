<?php

	namespace Craft;

	/**
	* 
	*/
	class Tfk_portalen_searchVariable
	{

		/**
		 * @param  [type]
		 * @param  [type]
		 * @return [type]
		 */
		public function getSearchResult($strSearchString,$nOffset) {

			return craft()->tfk_portalen_search_get->getSearchResult($strSearchString,$nOffset);
			
		}


		/**
		 * @return [type]
		 */
		public function getHitsPerPage() {
			return craft()->tfk_portalen_search_api->getMySetting('hitsPerPage');
		}

	}

?>
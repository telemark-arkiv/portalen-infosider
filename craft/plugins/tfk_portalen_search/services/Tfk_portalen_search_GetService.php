<?php
namespace Craft;

class Tfk_portalen_search_GetService extends BaseApplicationComponent
{


	private $arrResult = array();

	private $strSearchString = "";
	private $strSearchUrl = "";

	private $nHitsPerPage = null;
	private $nOffset =0;



	public function buildSearchUrl(){

		$this->strSearchUrl = craft()->tfk_portalen_search_api->getMySetting('searchUrl');
		$this->nHitsPerPage = craft()->tfk_portalen_search_api->getMySetting('hitsPerPage');
	}

	/**
	 * Get json data from search
	 *
	 * 
	 * @param  [string]
	 * @return [obj]
	 */
	public function getSearchResult($strSearchString,$nOffset=0) {

		$this->strSearchString = $strSearchString;
		$this->nOffset = $nOffset;

		$this->buildSearchUrl();
		
		// get search url from settings
		
		$nFrom = 0;
		if($this->nOffset >0)
			$nFrom = $this->nOffset*$this->nHitsPerPage;

		$strSearchString = str_replace(" ","+",$strSearchString);
		$jsonData = file_get_contents($this->strSearchUrl."?query=".$strSearchString."&size=".$this->nHitsPerPage."&from=".$nFrom);
		$objResult = json_decode($jsonData);
	

		$arrResult['hits'] = $objResult->hits->total;
		$arrResult['nCurrentPage'] = $this->nOffset;
		$arrResult['result'] = array();
		$arrResult['nLastPage'] = round($objResult->hits->total/$this->nHitsPerPage);
		$arrResult['nTo'] = ($this->nOffset+1)*$this->nHitsPerPage;

		$arrResult['nFrom'] = 1;
		if($nFrom != 0)
			$arrResult['nFrom'] =$arrResult['nTo']-$this->nHitsPerPage+1;
		if($arrResult['nTo'] > $arrResult['hits'])
			$arrResult['nTo']	= $arrResult['hits'];


		
		//print "<pre>";
		//print_r($objResult);

		$nCounter = 1;
		foreach($objResult->hits->hits as $objOneHit) {

			$arrResult['result'][$nCounter]['title'] =$objOneHit->_source->title;
			$arrResult['result'][$nCounter]['description'] =$objOneHit->_source->description;
			$arrResult['result'][$nCounter]['url'] =$objOneHit->_source->url;

			$nCounter++;
		}
		
		
		return $arrResult;
	}


	
}
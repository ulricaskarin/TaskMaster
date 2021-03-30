<?php
/**
 * ★ Page Helper ★
 *
 * Helps paginate resultSets
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace helpers;

class PageHelper
{
  /**
   * Array of results (that is needed to paginate)
   */
  private $resultSet;

  /**
   * Number of results to be listed per page
   */
  public $resultsPerPage;

  /**
   * The total count of results within a resultSet.
   */
  public $resultCount;

  /**
   * Number of Pages to display (i.e 1, 3, 4, ...)
   * @var [type]
   */
  private $numberOfPages;

  /**
   * Offset
   */
  private $offSet;

  /**
   * Current page
   */
  private $currentPage;

  /**
   * Static Properties
   */
  private static $page = 'page';
  private static $url = '?page=';

  /**
   * Page Helper Constructor
   * @param array $resultSet      - array of Results
   * @param int   $resultsPerPage - results to list per page
   * @param int   $resultCount    - total count of results
   */
  public function __construct(array $resultSet, int $resultsPerPage, int $resultCount)
  {
    $this->resultSet = $resultSet;
    $this->resultsPerPage = $resultsPerPage;
    $this->resultCount = $resultCount;

    $this->numberOfPages = $this->getNumberOfPages();
    $this->offSet = $this->getOffset();
    $this->currentPage = $this->getCurrentPage();
  }

  /**
   * Gets Number of pages to display (how many page links: 1, 2, 3..)
   *
   * For example: If total number of results is 15 and we want to display 3 results
   * per page - The number of pages to display would be 5
   *
   * @return float
   */
  private function getNumberOfPages()
  {
    return ceil($this->resultCount / $this->resultsPerPage);
  }

  /**
   * Gets Current page user is at
   *
   * @return string [description]
   */
  private function getCurrentPage()
  {
    $this->isGetRequest() && isset($_GET[self::$page]) ? $currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) : $currentPage = 1;

    $currentPage < 1 ? $currentPage = 1 : '';

    $currentPage > $this->numberOfPages ? $currentPage = $this->numberOfPages : '';

		return $currentPage;
  }

  /**
   * Gets Offset
   */
  private function getOffset()
  {
    return ($this->getCurrentPage() - 1) * $this->resultsPerPage;
  }

  /**
   * Paginates results
   *
   * @return string - a string of page links (1, 2, 3...)
   */
  public function paginate()
  {
    $pages = '';

    for($page = ($this->currentPage - $this->resultCount); $page < (($this->currentPage + $this->resultCount)+1); $page++) {

			if(($page <= $this->numberOfPages) && ($page > 0)) {

				if($this->resultCount <= $this->resultsPerPage) {$pages .= '';}

				elseif($page == $this->currentPage) {$pages .= $page."\n";}

				else {$pages .= '<a href="'.$_SERVER['PHP_SELF'].self::$url. $page.'">'.$page.'</a>'."\n";}
			}
		}
    return $pages;
  }

  /**
   * Is GET request?
   * @return boolean - true if GET
   */
  private function isGetRequest () // TODO move this to RouterHelper.class? Or Model?
  {
    return isset($_GET) && ($_SERVER['REQUEST_METHOD'] === 'GET');
  }

  /**
   * Sets Results of Pagination
   */
  public function setResults()
  {
    $result = array_slice($this->resultSet, $this->offSet, $this->resultsPerPage, true);
    return $result;
  }
}

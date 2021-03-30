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
  private $resultsPerPage;

  /**
   * The total count of results within a resultSet.
   */
  private $resultCount;

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
  }




}

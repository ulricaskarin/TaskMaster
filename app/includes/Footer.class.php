<?php
/**
 * ★ Footer ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace includes;

class Footer
{
  private $copyNotice = 'Copyright &copy; 2020-';
  private $copyOwner = ' Ulrica Skarin';

  public function renderYear()
  {
    return date("Y");
  }

  /**
   * Renders <footer> on all pages where included.
   * Starts with footer tag and ends with closing html tag.
   * @return string
   */
  public function renderFooter()
  {
    return
    '<footer><hr>'
    .$this->copyNotice.$this->renderYear().$this->copyOwner.
    '</footer>
    </body></html>';
  }
}

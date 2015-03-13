<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/9/2015
 * Time: 7:23 AM
 */

namespace Drupal\tops\Plugin\Block;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Class TopsTestBlock
 * @package Drupal\tops\Plugin\Block
 *
 * @Block(id="tops_test_block",admin_label="Hello Tops")
 */
class TopsTestBlock extends BlockBase{

    /**
     * Builds and returns the renderable array for this block plugin.
     *
     * @return array
     *   A renderable array representing the content of the block.
     *
     * @see \Drupal\block\BlockViewBuilder
     */
    public function build()
    {
        $SQL = "SELECT * FROM attenders_2012";
        return array(
            '#markup' => $this->t("I am the tops block")
        );
    }

    public function access(AccountInterface $account, $return_as_object = FALSE)
    {
        return AccessResult::allowed();
    }
}
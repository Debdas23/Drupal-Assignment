<?php
namespace Drupal\conditional_article_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Article Block' block.
 *
 * @Block(
 *   id = "article_block",
 *   admin_label = @Translation("Article Custom Block"),
 * )
 */
class ArticleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $configFactory;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  public function build() {
    return [
      '#markup' => $this->t('This is the custom block for Articles.'),
      '#cache' => [
        'contexts' => ['route'],
        'tags' => ['config:system.site'],
      ],
    ];
  }

  public function getCacheContexts() {
    return ['route'];
  }

  public function getCacheTags() {
    return ['config:system.site'];
  }

  public function access(AccountInterface $account, $return_as_object = FALSE) {
    $route_match = \Drupal::routeMatch();
    $node = $route_match->getParameter('node');
  
    if ($node instanceof NodeInterface && $node->bundle() === 'article') {
      $enabled = $this->configFactory->get('system.site')->get('custom_article_block_display');
      $result = $enabled ? AccessResult::allowed() : AccessResult::forbidden();
      return $return_as_object ? $result : $result->isAllowed();
    }
  
    $result = AccessResult::forbidden();
    return $return_as_object ? $result : $result->isAllowed();
  }
}

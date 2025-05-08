<?php

namespace Drupal\conditional_article_block\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Extend Site Information Form to add field.
 */
class ExtendedSiteInformationForm extends SiteInformationForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $site_config = $this->config('system.site');

    $form['custom_article_block_display'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display Custom Block on Article pages'),
      '#default_value' => $site_config->get('custom_article_block_display') ?? 0,
      '#description' => $this->t('Enable to display the custom article block on article pages.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::service('config.factory')->getEditable('system.site');
    $config->set('custom_article_block_display', $form_state->getValue('custom_article_block_display'));
    $config->save();

		parent::submitForm($form, $form_state);
  }
}

<?php

declare(strict_types=1);

namespace Drupal\dreamsteps\Hook;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Hook implementations for dreamSteps theme.
 */
class ThemeSettingsHooks {

  use StringTranslationTrait;

  /**
   * Implements hook_form_FORM_ID_alter() for system_theme_settings.
   */
  #[Hook('form_system_theme_settings_alter')]
  public function formSystemThemeSettingsAlter(&$form, FormStateInterface $form_state): void {
    //$wizard_completed = \Drupal::state()->get('dreamsteps.wizard_completed', FALSE);
$wizard_completed = false; // Set to false for testing purposes. Change to true when testing completion message.
    $form['installation_wizard'] = [
      '#type' => 'details',
      '#title' => $this->t('Installation Wizard'),
      '#open' => !$wizard_completed,
      '#weight' => -100,
    ];

    if (!$wizard_completed) {
      $wizard_url = Url::fromRoute('dreamsteps_installer.installation_wizard')->toString();
      $form['installation_wizard']['wizard_info'] = [
        '#type' => 'markup',
        '#markup' => '<div class="messages messages--warning">
          <h3>' . $this->t('Complete the Installation Wizard') . '</h3>
          <p>' . $this->t('It looks like you haven\'t completed the installation wizard yet. The wizard will help you set up your theme with pre-built templates, content, and configurations.') . '</p>
          <p><a href="@url" class="button button--primary">@button</a></p>
        </div>',
        '#allowed_tags' => ['div', 'h3', 'p', 'a'],
      ];
      $form['installation_wizard']['wizard_info']['#markup'] = str_replace(
        ['@url', '@button'],
        [$wizard_url, $this->t('Launch Installation Wizard')],
        $form['installation_wizard']['wizard_info']['#markup']
      );
    }
    else {
      $selected_template = \Drupal::state()->get('dreamsteps.selected_template', 'None');
      $message = $this->t('Installation Wizard completed. Selected template: <strong>@template</strong>', [
        '@template' => $selected_template,
      ]);
      $form['installation_wizard']['wizard_completed'] = [
        '#type' => 'markup',
        '#markup' => '<div class="messages messages--status"><p>' . $message . '</p></div>',
        '#allowed_tags' => ['div', 'p', 'strong'],
      ];
    }
  }

}

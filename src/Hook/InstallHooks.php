<?php

declare(strict_types=1);

namespace Drupal\dreamsteps\Hook;

use Drupal\Core\Url;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Install and uninstall hooks for dreamSteps theme.
 */
class InstallHooks {

  use StringTranslationTrait;

  /**
   * Implements hook_install().
   */
  #[Hook('install')]
  public function install(): void {
    // Set a message to guide users to the installation wizard.
    \Drupal::messenger()->addStatus($this->t('dreamSteps theme has been installed. Please complete the <a href="@wizard">Installation Wizard</a> to configure your theme.', [
      '@wizard' => Url::fromRoute('dreamsteps_installer.installation_wizard')->toString(),
    ]));

    // Store a flag indicating the wizard needs to be completed.
    \Drupal::state()->set('dreamsteps.wizard_completed', FALSE);
  }

  /**
   * Implements hook_uninstall().
   */
  #[Hook('uninstall')]
  public function uninstall(): void {
    // Clean up stored configuration.
    \Drupal::state()->delete('dreamsteps.wizard_completed');
    \Drupal::state()->delete('dreamsteps.selected_template');
  }

}

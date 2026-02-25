<?php

namespace Drupal\dreamsteps;

/**
 * Trait for Installation Wizard forms.
 */
trait WizardStepsTrait {

  /**
   * Get the step indicator markup.
   *
   * @param int $current_step
   *   The current step number (1-5).
   *
   * @return array
   *   Render array for the step indicator.
   */
  protected function getStepIndicator($current_step) {
    $steps = [
      1 => $this->t('Template'),
      2 => $this->t('Pages'),
      3 => $this->t('Media'),
      4 => $this->t('Layout'),
      5 => $this->t('Review'),
    ];

    $step_items = '';
    foreach ($steps as $step_num => $step_label) {
      $class = '';
      if ($step_num < $current_step) {
        $class = 'completed';
      }
      elseif ($step_num == $current_step) {
        $class = 'active';
      }

      $step_items .= '<div class="ds-step ' . $class . '">
        <div class="ds-step-number">' . $step_num . '</div>
        <div class="ds-step-label">' . $step_label . '</div>
      </div>';
    }

    return [
      '#type' => 'markup',
      '#markup' => '<div class="ds-step-indicator">' . $step_items . '</div>',
    ];
  }

  /**
   * Get the wizard header with logo.
   *
   * @return array
   *   Render array for the wizard header.
   */
  protected function getWizardHeader() {
    return [
      '#type' => 'markup',
      '#markup' => '<div class="ds-wizard-logo">
        <div>
          <h1>dreamSteps</h1>
          <div class="ds-tagline">' . $this->t('Installation Wizard') . '</div>
        </div>
      </div>',
    ];
  }

  /**
   * Wrap content in wizard container.
   *
   * @param array $form
   *   The form array.
   *
   * @return array
   *   The wrapped form.
   */
  protected function wrapInContainer(array $form) {
    $form['#prefix'] = '<div class="ds-wizard-container">';
    $form['#suffix'] = '</div>';
    return $form;
  }

}

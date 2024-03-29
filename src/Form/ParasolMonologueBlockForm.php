<?php

namespace Drupal\parasol\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class ParasolMonologueBlockForm extends FormBase {

  public function getFormID() {
    return 'parasol_monologue_form';
  }

  public function BuildForm(array $form, FormStateInterface $form_state) {
    //
    $options = array_combine(range(1, 10), range(1, 10));
    $form['paragraphs'] = [
      '#type' => 'select',
      '#title' => $this->t('Paragraphs'),
      '#options' => $options,
      '#default_value' => 2,
      'description' => $this->t('how many paragraphs of gibberish you want?')
    ];

    $form['phrases'] = [
      '#type' => 'textfield',
      '#title'=> 'Phrases',
      '#default_value'=> '4',
      '#description'=> $this->t('how many nonsense sentences you need?')
    ];

    $form['submit'] = [
      '#type'=>'submit',
      '#title'=> $this->t('go')
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $err_msg = '';
    $phrases = $form_state->getValue('phrases');

    if (!is_numeric($phrases)) {
      $err_msg = 'numeric input only';
    }

    if (floor($phrases) != $phrases) {
      $err_msg = 'integers only';
    }

    if (intval($phrases) < 1) {
      $err_msg = 'positive integers only';
    }

    if ($err_msg) {
      $form_state->setErrorByName('phrases', $this->t( $err_msg ));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('parasol.generate', [
      'paragraphs' => $form_state->getValue('paragraphs'),
      'phrases' => $form_state->getValue('phrases')
    ]);
  }


}

?>

<?php
/**
 * The default srbac controller
 */
class DefaultController extends Controller {
  /**
   * The default action if no route is specified
   */
	public function actionIndex() {
		//$this->render('index');
    $this->redirect(array('authitem/frontpage'));
	}
 }
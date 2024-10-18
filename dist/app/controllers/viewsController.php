<?php

namespace app\controllers;
use app\models\viewsModel;

class viewsController extends viewsModel
{
  public function getViewsController($view)
  {
    if ($view != "") {
      $respond = $this->getViewsModel($view);
    } else {
      $respond = "login";
    }
    return $respond;
  }
}

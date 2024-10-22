<?php

namespace app\models;

class viewsModel
{
  protected function getViewsModel($view)
  {
    $whitelist = ["dashboard", "userNew", "userList", "userSearch", "userUpdate", "userAvatar", "logOut"];

    if (in_array($view, $whitelist)) {
      if (is_file("./app/views/content/" . $view . "-view.php")) {
        $content = "./app/views/content/" . $view . "-view.php";
      } else {
        $content = "404";
      }
    } elseif ($view == "login" || $view == "index") {
      $content = "login";
    } else {
      $content = "404";
    }
    return $content;
  }
}

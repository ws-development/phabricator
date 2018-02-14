<?php

final class PhabricatorDatasourceEngine extends Phobject {

  private $viewer;

  public function setViewer(PhabricatorUser $viewer) {
    $this->viewer = $viewer;
    return $this;
  }

  public function getViewer() {
    return $this->viewer;
  }

  public function getAllQuickSearchDatasources() {
    return PhabricatorDatasourceEngineExtension::getAllQuickSearchDatasources();
  }

  public function newJumpURI($query) {
    $viewer = $this->getViewer();
    $extensions = PhabricatorDatasourceEngineExtension::getAllExtensions();

    foreach ($extensions as $extension) {
      $jump_uri = id(clone $extension)
        ->setViewer($viewer)
        ->newJumpURI($query);

      if ($jump_uri !== null) {
        return $jump_uri;
      }
    }

    return null;
  }

}

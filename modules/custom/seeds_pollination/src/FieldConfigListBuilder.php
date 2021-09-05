<?php

namespace Drupal\seeds_pollination;

use Drupal\Core\Entity\EntityInterface;
use Drupal\field_ui\FieldConfigListBuilder as FieldUIListBuilder;

class FieldConfigListBuilder extends FieldUIListBuilder {
    /**
     * {@inheritDoc}
     */
    public function buildHeader() {
        $headers = parent::buildHeader();
        $headers['admin_description'] = $this->t('Administrative Description');
        return $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function buildRow(EntityInterface $field_config) {
        /** @var \Drupal\Core\Field\FieldConfigInterface $field_config */
        $row = parent::buildRow($field_config);
        $row['data']['admin_description'] = $field_config->getThirdPartySetting('seeds_pollination', 'description');
        return $row;
    }
}
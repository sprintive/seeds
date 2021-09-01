<?php

namespace Drupal\seeds_pollination;

use Drupal\Core\Entity\EntityInterface;
use Drupal\field_ui\EntityFormModeListBuilder;

class SeedsFormModeListBuilder extends EntityFormModeListBuilder {
    /**
     * {@inheritDoc}
     */
    public function buildHeader() {
        $headers = parent::buildHeader();
        unset($headers['operations']);
        $headers['admin_description'] = $this->t('Administrative Description');
        $headers['operations'] = $this->t('Operations');
        return $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function buildRow(EntityInterface $field_config) {
        /** @var \Drupal\Core\Field\FieldConfigInterface $field_config */
        $row = parent::buildRow($field_config);
        $operations = $row['operations'];
        unset($row['operations']);
        $row['admin_description'] = $field_config->getThirdPartySetting('seeds_pollination', 'description');
        $row['operations'] = $operations;
        return $row;
    }
}
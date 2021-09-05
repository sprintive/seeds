<?php

namespace Drupal\seeds_pollination;

use Drupal\Core\Entity\EntityInterface;
use Drupal\entityqueue\EntityQueueListBuilder;

class SeedsEntityQueueListBuilder extends EntityQueueListBuilder {
    /**
     * {@inheritDoc}
     */
    public function buildHeader() {
        $headers = parent::buildHeader();
        unset($headers['operations']);
        $headers['admin_description'] = $this->t('Description');
        $headers['operations'] = $this->t('Operations');
        return $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function buildRow(EntityInterface $field_config) {
        /** @var \Drupal\Core\Field\FieldConfigInterface $field_config */
        $row = parent::buildRow($field_config);
        $operations = $row['data']['operations'];
        unset($row['data']['operations']);
        $row['data']['admin_description'] = $field_config->getThirdPartySetting('seeds_pollination', 'description');
        $row['data']['operations'] = $operations;
        return $row;
    }
}
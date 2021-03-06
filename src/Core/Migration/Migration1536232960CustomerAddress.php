<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536232960CustomerAddress extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536232960;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE `customer_address` (
              `id` BINARY(16) NOT NULL,
              `customer_id` BINARY(16) NOT NULL,
              `country_id` BINARY(16) NOT NULL,
              `country_state_id` BINARY(16) NULL,
              `company` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
              `department` VARCHAR(35) COLLATE utf8mb4_unicode_ci NULL,
              `salutation` VARCHAR(30) COLLATE utf8mb4_unicode_ci NULL,
              `title` VARCHAR(100) COLLATE utf8mb4_unicode_ci NULL,
              `first_name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `last_name` VARCHAR(60) COLLATE utf8mb4_unicode_ci NOT NULL,
              `street` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
              `zipcode` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `city` VARCHAR(70) COLLATE utf8mb4_unicode_ci NOT NULL,
              `vat_id` VARCHAR(50) COLLATE utf8mb4_unicode_ci NULL,
              `phone_number` VARCHAR(40) COLLATE utf8mb4_unicode_ci NULL,
              `additional_address_line1` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
              `additional_address_line2` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
              `attributes` JSON NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
               PRIMARY KEY (`id`),
               CONSTRAINT `fk.customer_address.country_id` FOREIGN KEY (`country_id`)
                 REFERENCES `country` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
               CONSTRAINT `fk.customer_address.country_state_id` FOREIGN KEY (`country_state_id`)
                 REFERENCES `country_state` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
               CONSTRAINT `fk.customer_address.customer_id` FOREIGN KEY (`customer_id`)
                 REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
               CONSTRAINT `json.attributes` CHECK (JSON_VALID(`attributes`))
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}

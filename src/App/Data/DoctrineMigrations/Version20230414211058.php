<?php

declare(strict_types=1);

namespace App\Data\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230414211058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds saga_state table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        CREATE TABLE saga_state (
            id CHAR(36) NOT NULL COLLATE utf8mb4_general_ci COMMENT '(DC2Type:guid)',
            done tinyint(1) default 0 not null,
            sagaId varchar(255) not null,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE saga_state');
    }
}

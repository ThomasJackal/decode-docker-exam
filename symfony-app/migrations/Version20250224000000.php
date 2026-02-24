<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\ParameterType;
use Doctrine\Migrations\AbstractMigration;

final class Version20250224000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create todo table and insert 10 rows';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE todo (id SERIAL PRIMARY KEY, titre VARCHAR(255) NOT NULL, done BOOLEAN NOT NULL DEFAULT false)');
        $todos = [
            ['Lire le sujet du TP', true],
            ['Créer les Dockerfiles', true],
            ['Écrire les docker-compose', true],
            ['Créer le projet Symfony', true],
            ['Implémenter l\'entité Todo', true],
            ['Créer l\'endpoint API', false],
            ['Afficher les todos sur le front', false],
            ['Tester avec la BDD', false],
            ['Préparer la soutenance', false],
            ['Partager le repo GitHub', false],
        ];
        foreach ($todos as $t) {
            $this->addSql(
                'INSERT INTO todo (titre, done) VALUES (:titre, :done)',
                ['titre' => $t[0], 'done' => $t[1]],
                ['titre' => ParameterType::STRING, 'done' => ParameterType::BOOLEAN]
            );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE todo');
    }
}

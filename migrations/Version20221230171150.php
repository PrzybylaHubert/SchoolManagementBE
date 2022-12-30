<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230171150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parents_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE teacher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classes (id INT NOT NULL, code VARCHAR(255) NOT NULL, profile VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, student_id INT NOT NULL, subject_id INT NOT NULL, teacher_id INT NOT NULL, value INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_595AAE34CB944F1A ON grade (student_id)');
        $this->addSql('CREATE INDEX IDX_595AAE3423EDC87 ON grade (subject_id)');
        $this->addSql('CREATE INDEX IDX_595AAE3441807E1D ON grade (teacher_id)');
        $this->addSql('COMMENT ON COLUMN grade.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, subject_id INT NOT NULL, teacher_id INT NOT NULL, class_id INT NOT NULL, week_day INT NOT NULL, lesson_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F323EDC87 ON lesson (subject_id)');
        $this->addSql('CREATE INDEX IDX_F87474F341807E1D ON lesson (teacher_id)');
        $this->addSql('CREATE INDEX IDX_F87474F3EA000B10 ON lesson (class_id)');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, recipient_id_id INT NOT NULL, addresse_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, send_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F2B6945EC ON message (recipient_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FC2360D68 ON message (addresse_id_id)');
        $this->addSql('CREATE TABLE parents (id INT NOT NULL, student_id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD501D6ACB944F1A ON parents (student_id)');
        $this->addSql('CREATE INDEX IDX_FD501D6A9D86650F ON parents (user_id_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, user_id_id INT NOT NULL, class_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF339D86650F ON student (user_id_id)');
        $this->addSql('CREATE INDEX IDX_B723AF33EA000B10 ON student (class_id)');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0F6A6D59D86650F ON teacher (user_id_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, first_login BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3423EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3441807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F323EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2B6945EC FOREIGN KEY (recipient_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC2360D68 FOREIGN KEY (addresse_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6ACB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF339D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D59D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE classes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parents_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE teacher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE34CB944F1A');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE3423EDC87');
        $this->addSql('ALTER TABLE grade DROP CONSTRAINT FK_595AAE3441807E1D');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F323EDC87');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F3EA000B10');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F2B6945EC');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FC2360D68');
        $this->addSql('ALTER TABLE parents DROP CONSTRAINT FK_FD501D6ACB944F1A');
        $this->addSql('ALTER TABLE parents DROP CONSTRAINT FK_FD501D6A9D86650F');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF339D86650F');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF33EA000B10');
        $this->addSql('ALTER TABLE teacher DROP CONSTRAINT FK_B0F6A6D59D86650F');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE parents');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE "user"');
    }
}

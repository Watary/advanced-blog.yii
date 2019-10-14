<?php

use yii\db\Migration;

/**
 * Class m191007_125527_create_tables_for_blog
 */
class m191007_125527_create_tables_for_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id'                    =>  $this->primaryKey(),
            'id_owner'              =>  $this->integer()->notNull(),
            'id_parent'             =>  $this->integer(),
            'title'                 =>  $this->string(255)->notNull(),
            'description'           =>  $this->text()->defaultValue(NULL),
            'alias'                 =>  $this->string(255)->notNull()->unique(),
            'status'                =>  $this->integer(255)->defaultValue(10),
            'id_deleted'            =>  $this->integer()->defaultValue(NULL),
            'created_at'            =>  $this->integer(11)->notNull(),
            'updated_at'            =>  $this->integer(11),
            'deleted_at'            =>  $this->integer(11)->defaultValue(NULL),
        ]);

        $this->createTable('{{%articles}}', [
            'id'                    =>  $this->primaryKey(),
            'id_category'           =>  $this->integer()->defaultValue(NULL),
            'id_author'             =>  $this->integer()->notNull(),
            'title'                 =>  $this->string(255)->notNull(),
            'text'                  =>  $this->text()->notNull(),
            'excerpt'               =>  $this->text()->defaultValue(NULL),
            'image'                 =>  $this->text()->defaultValue(NULL),
            'alias'                 =>  $this->string(255)->notNull()->unique(),
            'status'                =>  $this->integer(255)->defaultValue(10),
            'count_show_all'        =>  $this->integer()->notNull()->defaultValue(0),
            'count_show'            =>  $this->integer()->notNull()->defaultValue(0),
            'count_comments'        =>  $this->integer()->notNull()->defaultValue(0),
            'mark'                  =>  $this->double()->defaultValue(NULL),
            'id_deleted'            =>  $this->integer()->defaultValue(NULL),
            'created_at'            =>  $this->integer(11)->notNull(),
            'updated_at'            =>  $this->integer(11),
            'deleted_at'            =>  $this->integer(11)->defaultValue(NULL),
        ]);

        $this->createTable('{{%article_mark}}', [
            'id'                    =>  $this->primaryKey(),
            'id_article'            =>  $this->integer()->notNull(),
            'id_user'               =>  $this->integer()->notNull(),
            'mark'                  =>  $this->integer()->notNull(),
            'created_at'            =>  $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%articles_show}}', [
            'id'                    =>  $this->primaryKey(),
            'id_article'            =>  $this->integer()->notNull(),
            'id_user'               =>  $this->integer()->defaultValue(NULL),
            'ip'                    =>  $this->string(255)->defaultValue(NULL),
            'created_at'            =>  $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%tags}}', [
            'id'                    =>  $this->primaryKey(),
            'id_owner'              =>  $this->integer()->notNull(),
            'title'                 =>  $this->string(255)->notNull()->unique(),
            'alias'                 =>  $this->string(255)->notNull()->unique(),
            'description'           =>  $this->text(),
            'created_at'            =>  $this->integer(11)->notNull(),
            'updated_at'            =>  $this->integer(11),
        ]);

        $this->createTable('{{%article_tag}}', [
            'id'                    =>  $this->primaryKey(),
            'id_article'            =>  $this->integer()->notNull(),
            'id_tag'                =>  $this->integer()->notNull(),
            'created_at'            =>  $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%comments}}', [
            'id'                    =>  $this->primaryKey(),
            'id_owner'              =>  $this->integer()->notNull(),
            'id_articles'           =>  $this->integer()->notNull(),
            'id_comment'            =>  $this->integer(),
            'text'                  =>  $this->text()->notNull(),
            'status'                =>  $this->integer(255)->defaultValue(10),
            'created_at'            =>  $this->integer(11)->notNull(),
            'updated_at'            =>  $this->integer(11),
        ]);

        $this->createTable('{{%setting}}', [
            'id'                    =>  $this->primaryKey(),
            'key'                   =>  $this->string(255)->notNull()->unique(),
            'value'                 =>  $this->string(255)->notNull(),
            'title'                 =>  $this->string(255)->notNull(),
            'description'           =>  $this->text()->defaultValue(NULL),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_mark}}');
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%articles_show}}');
        $this->dropTable('{{%comments}}');
        $this->dropTable('{{%tags}}');
        $this->dropTable('{{%articles}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%setting}}');
    }

}

<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

use Domino\{
    Column,
    Blueprint
};

$conn = $container->get(Domino\Connector::class);

$blueprint = new Blueprint($conn);

$blueprint->table('users')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('name')->notNull())
          ->add(Column::date('birth_date')->notNull())
          ->add(Column::string('gender')->notNull())
          ->add(Column::text('description')->default(NULL))
          ->add(Column::string('email')->notNull()->isUnique())
          ->add(Column::string('longitude')->notNull())
          ->add(Column::string('latitude')->notNull())
          ->add(Column::integer('distance')->notNull())
          ->add(Column::integer('min_age')->notNull())
          ->add(Column::integer('max_age')->notNull())
          ->add(Column::string('password')->notNull())
          ->add(Column::text('token')->default(NULL))
          ->add(Column::datetime('created_on')->notNull())
          ->create();


$blueprint->table('images')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('user_id')->notNull())
          ->add(Column::string('path')->notNull())
          ->add(Column::datetime('created_on')->notNull())
          ->create();


$blueprint->table('events')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::text('payload')->notNull())
          ->add(Column::datetime('occured_on')->notNull())
          ->create();

$blueprint->table('actions')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('type')->notNull())
          ->add(Column::string('sender_id')->notNull())
          ->add(Column::string('receiver_id')->notNull())
          ->add(Column::datetime('created_on')->notNull())
          ->create();

$blueprint->table('messages')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('match_id')->notNull())
          ->add(Column::string('sender')->notNull())
          ->add(Column::string('receiver')->notNull())
          ->add(Column::text('body')->notNull())
          ->add(Column::datetime('created_on'))
          ->create();

$blueprint->table('matches')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('first_user_id')->notNull())
          ->add(Column::string('second_user_id')->notNull())
          ->add(Column::datetime('created_on'))
          ->create();

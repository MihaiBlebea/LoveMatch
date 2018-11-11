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
          ->add(Column::string('email')->notNull())
          ->add(Column::string('password')->notNull())
          ->create();

$blueprint->table('events')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::text('payload')->notNull())
          ->add(Column::datetime('occured_on')->notNull())
          ->create();

$blueprint->table('passes')
          ->add(Column::string('id')->primaryKey())
          ->add(Column::string('owner')->notNull())
          ->add(Column::string('receiver')->notNull())
          ->add(Column::datetime('created_on')->notNull())
          ->create();

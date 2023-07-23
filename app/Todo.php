<?php

namespace App;

use Illuminate\Database\Eloquent;

class Todo extends Eloquent
{
  protected $fillable = [
              'todo'
            ];
  protected $primaryKey = 'id';
  protected $table = 'todos';
}

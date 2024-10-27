<?php 
namespace Model;

class Task extends ActiveRecord{
    protected static $tabla = 'tasks';
    protected static $columnasDB = ['id', 'name', 'state', 'projectId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->state = $args['state'] ?? 0;
        $this->projectId = $args['projectId'] ?? '';
    }
}
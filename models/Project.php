<?php

namespace Model;

class Project extends ActiveRecord{
    protected static $tabla = 'projects';
    protected static $columnasDB = ['id', 'project', 'url', 'ownerId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->project = $args['project'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->ownerId = $args['ownerId'] ?? '';
    }

    public function validateNameProject(){
        if (!$this->project) {
            self::$alertas['error'][] = 'Name of the Project is Required';
        }
        return self::$alertas;
    }
}
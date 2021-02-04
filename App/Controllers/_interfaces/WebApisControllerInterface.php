<?php

namespace App\Controllers\_interfaces;

interface WebApisControllerInterface {
    
    public function store(Array $data);
    public function show();
    public function update();
    public function delete();

}
<?php

class Pila {
    private $pila = [];

    public function push($data) {
        array_push($this->pila, $data);
    }

    public function pop() {
        return array_pop($this->pila);
    }

    public function obtenerPila() {
        return $this->pila;
    }
}